<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LostItemController extends Controller
{
    private function categoryNames(): array
    {
        return Category::orderBy('category')->pluck('category')->all();
    }

    private function categoryOptions()
    {
        return Category::orderBy('category')->get();
    }

    public function index(Request $request)
    {
        $query = LostItem::query()
            ->orderByRaw("FIELD(status, 'hilang', 'dicari', 'ditemukan', 'selesai')")
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'Semua') {
            $query->where('category', $request->input('category'));
        }

        $lostItems = $query->paginate(12)->withQueryString();

        return view('lost-items.index', [
            'lostItems' => $lostItems,
            'categories' => $this->categoryNames(),
            'search'     => $request->input('search', ''),
            'activeCategory' => $request->input('category', 'Semua'),
        ]);
    }

    public function show(LostItem $lostItem)
    {
        return view('lost-items.show', compact('lostItem'));
    }

    public function create()
    {
        return view('lost-items.create', [
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:120'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'location' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'reporter_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
        ], [
            'photo.uploaded' => 'Foto gagal diunggah. Pastikan ukuran file tidak melebihi batas upload PHP/Herd.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 10 MB.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('lost-items', 'public');
        }

        $validated['category'] = Category::findOrFail($validated['category_id'])->category;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'hilang';

        LostItem::create($validated);

        return redirect()
            ->route('lost-items.create')
            ->with('success', 'Laporan barang hilang berhasil dikirim dan menunggu verifikasi.');
    }

    public function adminIndex()
    {
        $lostItems = LostItem::latest()->paginate(10);

        return view('admin.lost-items.index', [
            'lostItems' => $lostItems,
        ]);
    }

    public function edit(LostItem $lostItem)
    {
        return view('admin.lost-items.edit', [
            'lostItem' => $lostItem,
            'categories' => $this->categoryNames(),
        ]);
    }

    public function update(Request $request, LostItem $lostItem)
    {
        $validated = $request->validate([
            'item_name' => 'required|max:120',
            'category' => ['required', Rule::exists('categories', 'category')],
            'incident_date' => 'required|date',
            'location' => 'required|max:180',
            'description' => 'required',
            'reporter_name' => 'required|max:120',
            'phone' => 'required|max:30',
        ]);

        $validated['category_id'] = Category::where('category', $validated['category'])->value('id');

        $result = $lostItem->update($validated);

        return redirect()
            ->route('admin.lost-items.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(LostItem $lostItem)
    {
        $lostItem->delete();

        return redirect()
            ->route('admin.lost-items.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Tandai barang hilang sebagai telah ditemukan.
     * Dipanggil oleh pemilik laporan dari halaman "Klaim Saya".
     */
    public function markFound(LostItem $lostItem)
    {
        // Hanya pemilik laporan yang boleh
        if (Auth::id() !== $lostItem->user_id) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($lostItem->status !== 'selesai') {
            $lostItem->update([
                'status'    => 'selesai',
                'selesai_at'=> now(),
            ]);
        }

        // Tandai semua laporan ditemukan yang terkait menjadi selesai
        foreach ($lostItem->foundReports as $foundReport) {
            if ($foundReport->status !== 'selesai') {
                $foundReport->update([
                    'status' => 'selesai',
                    'selesai_at' => now(),
                ]);
            }
        }

        return redirect()
            ->route('claims.laporan')
            ->with('success', 'Status barang hilang diperbarui: Selesai – barang telah diterima/ditemukan!');
    }

    public function adminUpdateStatus(Request $request, LostItem $lostItem)
    {
        $request->validate([
            'status' => 'required|in:hilang,dicari,selesai',
        ]);

        $lostItem->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status barang hilang berhasil diperbarui.');
    }

    public function adminMarkFound(Request $request, LostItem $lostItem)
    {
        $request->validate([
            'item_name'     => 'required|string|max:255',
            'category'      => 'required|string|max:100',
            'location'      => 'required|string|max:255',
            'incident_date' => 'required|date',
            'description'   => 'required|string|max:1000',
            'reporter_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'photo'         => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['photo', '_token', '_method']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'ditemukan';
        $data['lost_item_id'] = $lostItem->id;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('found_items', 'public');
        }

        \App\Models\FoundItem::create($data);

        // Update lost item status as well, but wait, do we change it to ditemukan?
        // Wait, standard flow leaves it as 'hilang' but gives it a found report, or 'dicari'.
        // But since admin explicitly chose 'ditemukan', we update the status.
        $lostItem->update([
            'status' => 'ditemukan',
        ]);

        return redirect()->route('admin.lost-items.index')->with('success', 'Barang hilang berhasil ditandai sebagai ditemukan dan laporan temuan telah dibuat.');
    }
}
