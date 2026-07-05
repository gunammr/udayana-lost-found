<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Claim;

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
    // ==============================
    // Dashboard Admin
    // ==============================
    public function admin()
    {
        return view('admin.dashboard.index', [

            'totalLostItems' => LostItem::count(),
            'totalFoundItems' => FoundItem::count(),
            'totalClaims' => Claim::where('status', 'diterima')->count(),
            'totalUsers' => User::count(),
            'recentLostItems' => LostItem::latest()->take(5)->get(),
            'recentFoundItems' => FoundItem::latest()->take(5)->get(),
            'pendingClaims' => Claim::where('status', 'menunggu')->latest()->take(5)->get(),
        ]);
    }
}