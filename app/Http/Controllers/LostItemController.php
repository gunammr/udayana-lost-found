<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LostItemController extends Controller
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
            'categories' => self::CATEGORIES,
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
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
            $validated['photo_path'] = $request->file('photo')->store('lost-items', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'menunggu_verifikasi';

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
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, LostItem $lostItem)
    {
        $validated = $request->validate([
            'item_name' => 'required|max:120',
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'incident_date' => 'required|date',
            'location' => 'required|max:180',
            'description' => 'required',
            'reporter_name' => 'required|max:120',
            'phone' => 'required|max:30',
        ]);

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
}
