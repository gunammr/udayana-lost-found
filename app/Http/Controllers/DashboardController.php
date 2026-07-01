<?php

namespace App\Http\Controllers;

use App\Models\LostItem;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'lostItemsCount' => LostItem::count(),
            'pendingLostItemsCount' => LostItem::where('status', 'menunggu_verifikasi')->count(),
            'recentLostItems' => LostItem::latest()->take(3)->get(),
        ]);
    }
}
