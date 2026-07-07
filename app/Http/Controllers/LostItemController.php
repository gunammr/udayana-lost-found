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
        $query = LostItem::query()->orderByDesc('created_at');

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

        return redirect()
            ->route('claims.laporan')
            ->with('success', 'Status barang hilang diperbarui: Selesai – barang telah ditemukan!');
    }
}
