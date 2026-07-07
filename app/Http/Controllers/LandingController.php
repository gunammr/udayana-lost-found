<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {

        // Laporan kehilangan terbaru
        $latestLostItem = LostItem::latest()->first();

        // Barang ditemukan terbaru
        $latestFoundItem = FoundItem::latest()->first();

        // Jumlah barang yang berhasil dikembalikan
        $returnedItemsCount = Claim::where('status', 'diterima')->count();

        // Jumlah seluruh laporan kehilangan
        $lostItemsCount = LostItem::count();

        // Jumlah seluruh laporan barang ditemukan
        $foundItemsCount = FoundItem::count();

        return view('landing.index', [

            'latestLostItem' => $latestLostItem,

            'latestFoundItem' => $latestFoundItem,

            'returnedItemsCount' => $returnedItemsCount,

            'lostItemsCount' => $lostItemsCount,

            'foundItemsCount' => $foundItemsCount,

        ]);
    }
}