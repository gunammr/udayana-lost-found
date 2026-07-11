<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FoundItemController extends Controller
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
        $query = FoundItem::query()
            ->orderByRaw("FIELD(status, 'ditemukan', 'diklaim', 'dikembalikan', 'selesai')")
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

        $foundItems = $query->paginate(12)->withQueryString();

        return view('found-items.index', [
            'foundItems' => $foundItems,
            'categories' => $this->categoryNames(),
            'search'     => $request->input('search', ''),
            'activeCategory' => $request->input('category', 'Semua'),
        ]);
    }

    public function show(FoundItem $foundItem)
    {
        return view('found-items.show', compact('foundItem'));
    }

    public function create(Request $request)
    {
        $linkedLostItem = null;

        if ($request->filled('lost_item_id')) {
            $linkedLostItem = LostItem::find($request->integer('lost_item_id'));
        }

        return view('found-items.create', [
            'categories' => $this->categoryOptions(),
            'linkedLostItem' => $linkedLostItem,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lost_item_id' => ['nullable', 'integer', 'exists:lost_items,id'],
            'item_name' => ['required', 'string', 'max:120'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'location' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20240'],
            'reporter_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
        ], [
            'photo.uploaded' => 'Foto gagal diunggah. Pastikan ukuran file tidak melebihi 10 MB.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 10 MB.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('found-items', 'public');
        }

        $validated['category'] = Category::findOrFail($validated['category_id'])->category;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'ditemukan';

        $foundItem = FoundItem::create($validated);

        if ($foundItem->lost_item_id) {
            $lostItem = LostItem::find($foundItem->lost_item_id);
            if ($lostItem && in_array($lostItem->status, ['hilang', 'dicari'])) {
                $lostItem->update([
                    'status' => 'ditemukan',
                    'ditemukan_at' => now(),
                ]);
            }

            // Set status FoundItem menjadi dikembalikan karena pemilik sudah diketahui
            $foundItem->update([
                'status' => 'dikembalikan',
                'dikembalikan_at' => now(),
            ]);

            return redirect()
                ->route('lost-items.show', $foundItem->lost_item_id)
                ->with('success', 'Laporan barang ditemukan berhasil dikirim. Pemilik bisa melihat informasi temuan ini.');
        }

        return redirect()
            ->route('found-items.create')
            ->with('success', 'Laporan barang ditemukan berhasil dikirim dan menunggu verifikasi.');
    }

    public function adminIndex()
{
    $foundItems = FoundItem::latest()->paginate(10);

    return view('admin.found-item.index', compact('foundItems'));
}

public function edit(FoundItem $foundItem)
{
    return view('admin.found-item.edit', [
        'foundItem' => $foundItem,
        'categories' => $this->categoryNames(),
    ]);
}

public function update(Request $request, FoundItem $foundItem)
{
    $validated = $request->validate([
        'item_name' => 'required|max:120',
        'category' => ['required', Rule::exists('categories', 'category')],
        'found_date' => 'required|date',
        'location' => 'required|max:180',
        'description' => 'required',
        'finder_name' => 'required|max:120',
        'phone' => 'required|max:30',
    ]);

    $validated['category_id'] = Category::where('category', $validated['category'])->value('id');

    if ($request->hasFile('photo')) {
        $validated['photo_path'] = $request->file('photo')->store('found-items', 'public');
    }

    $result = $foundItem->update($validated);

    return redirect()
        ->route('admin.found-items.index')
        ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(FoundItem $foundItem)
    {
        $foundItem->delete();

        return redirect()
            ->route('admin.found-items.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function adminUpdateStatus(Request $request, FoundItem $foundItem)
    {
        $request->validate([
            'status' => 'required|in:ditemukan,diklaim,dikembalikan,selesai',
        ]);

        $foundItem->update([
            'status' => $request->status,
        ]);

        // If the foundItem is linked to a lost item and marked as selesai/dikembalikan,
        // we might also want to update the lostItem if needed, but since it's admin forcing status,
        // we can just update the found item for now.
        if ($request->status === 'selesai' && $foundItem->lost_item_id) {
            $lostItem = \App\Models\LostItem::find($foundItem->lost_item_id);
            if ($lostItem && $lostItem->status !== 'selesai') {
                $lostItem->update([
                    'status' => 'selesai',
                    'selesai_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status barang ditemukan berhasil diperbarui.');
    }
}
