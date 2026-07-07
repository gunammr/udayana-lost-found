<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FoundItemController extends Controller
{
    private const CATEGORIES = [
        'Elektronik',
        'Dokumen',
        'Aksesori',
        'Kunci',
        'Lainnya',
    ];

    public function index(Request $request)
    {
        $query = FoundItem::query()->orderByDesc('created_at');

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
            'categories' => self::CATEGORIES,
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
            'categories' => self::CATEGORIES,
            'linkedLostItem' => $linkedLostItem,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lost_item_id' => ['nullable', 'integer', 'exists:lost_items,id'],
            'item_name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', Rule::in(self::CATEGORIES)],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'location' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'reporter_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('found-items', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'ditemukan';

        FoundItem::create($validated);

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
        'categories' => self::CATEGORIES,
    ]);
}

public function update(Request $request, FoundItem $foundItem)
{
    $validated = $request->validate([
        'item_name' => 'required|max:120',
        'category' => ['required', Rule::in(self::CATEGORIES)],
        'found_date' => 'required|date',
        'location' => 'required|max:180',
        'description' => 'required',
        'finder_name' => 'required|max:120',
        'phone' => 'required|max:30',
    ]);

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
}
