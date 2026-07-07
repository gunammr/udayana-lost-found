<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\LostItem;
use App\Models\FoundItem;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::all()->map(function ($category) {

        $category->count =
            LostItem::where('category_id', $category->id)->count()
            +
            FoundItem::where('category_id', $category->id)->count();

        return $category;
    });

    return view('admin.categories.index', compact('categories'));
    }

        public function show(Category $category)
        {
        $foundItems = FoundItem::where('category_id', $category->id)
            ->latest()
            ->get();

        $lostItems = LostItem::where('category_id', $category->id)
            ->latest()
            ->get();

        return view(
            'admin.categories.show',
            compact('category', 'foundItems', 'lostItems')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100|unique:categories,category',
        ], [
            'category.required' => 'Nama kategori wajib diisi.',
            'category.unique' => 'Kategori sudah ada.',
        ]);

        Category::create([
            'category' => $validated['category'],
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100|unique:categories,category,' . $category->id,
        ]);

        $category->update([
            'category' => $validated['category'],
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $used =
            FoundItem::where('category_id', $category->id)->exists()
            ||
            LostItem::where('category_id', $category->id)->exists();

        if ($used) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Kategori berhasil dihapus.'
        );
    }
}