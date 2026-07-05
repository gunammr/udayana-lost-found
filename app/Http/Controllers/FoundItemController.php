<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;

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
}
