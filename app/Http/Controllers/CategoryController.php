<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\FoundItem;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = collect([
            [
                'name' => 'Elektronik',
                'icon' => '💻',
                'description' => 'Laptop, HP, charger, kabel data, dll',
            ],
            [
                'name' => 'Aksesori',
                'icon' => '👜',
                'description' => 'Dompet, jam tangan, kacamata',
            ],
            [
                'name' => 'Dokumen',
                'icon' => '📄',
                'description' => 'KTM, KTP, SIM, sertifikat',
            ],
            [
                'name' => 'Tas',
                'icon' => '🎒',
                'description' => 'Ransel, selempang, totebag',
            ],
            [
                'name' => 'Kunci',
                'icon' => '🔑',
                'description' => 'Kunci motor, rumah, gembok',
            ],
            [
                'name' => 'Pakaian',
                'icon' => '👕',
                'description' => 'Jaket, topi, sepatu',
            ],
            [
                'name' => 'Buku & ATK',
                'icon' => '📚',
                'description' => 'Buku, alat tulis',
            ],
            [
                'name' => 'Lainnya',
                'icon' => '📦',
                'description' => 'Kategori lainnya',
            ],
        ]);

        $categories = $categories->map(function ($category) {

            $category['count'] =
                LostItem::where('category', $category['name'])->count()
                +
                FoundItem::where('category', $category['name'])->count();

            return $category;
        });

        return view('admin.categories.index', compact('categories'));
    }
}