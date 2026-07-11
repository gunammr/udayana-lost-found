<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Claim;

class DashboardController extends Controller
{
    /**
     * Dashboard User
     */
    public function index()
    {
        $user = auth()->user();

        $lostItemsCount = LostItem::where('user_id', $user->id)->count();
        $foundItemsCount = FoundItem::where('user_id', $user->id)->count();
        $claimsCount = Claim::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->count();

        $recentLostItems = LostItem::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentFoundItems = FoundItem::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentClaims = Claim::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = collect();
        // Lost Item
        foreach ($recentLostItems as $item) {

            $recentActivities->push([
                'id' => $item->id,
                'type' => 'lost',
                'title' => $item->item_name,
                'status' => $item->status,
                'photo' => $item->photo_path,
                'created_at' => $item->created_at,

            ]);
        }

        // Found Item
        foreach ($recentFoundItems as $item) {

            $recentActivities->push([
                'id' => $item->id,
                'type' => 'found',

                'title' => $item->item_name,

                'status' => $item->status,

                'photo' => $item->photo_path,

                'created_at' => $item->created_at,

            ]);
        }

        // Claim
        foreach ($recentClaims as $claim) {

            $recentActivities->push([
                'id' => $claim->id,
                'type' => 'claim',

                'title' => optional($claim->foundItem)->item_name ?? 'Barang',

                'status' => $claim->status,

                'photo' => optional($claim->foundItem)->photo_path,

                'created_at' => $claim->created_at,

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Urutkan Berdasarkan Waktu Terbaru
        |--------------------------------------------------------------------------
        */

        $recentActivities = $recentActivities
            ->sortByDesc('created_at')
            ->take(5);

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', [

            'lostItemsCount' => $lostItemsCount,

            'foundItemsCount' => $foundItemsCount,

            'claimsCount' => $claimsCount,

            'recentActivities' => $recentActivities,

        ]);
    }

    /**
     * Dashboard Admin
     */
    public function admin()
    {
        return view('admin.dashboard.index', [

            'totalLostItems' => LostItem::count(),

            'totalFoundItems' => FoundItem::count(),

            'totalClaims' => Claim::where('status', 'diterima')->count(),

            'totalUsers' => User::count(),

            'recentLostItems' => LostItem::latest()
                ->take(5)
                ->get(),

            'recentFoundItems' => FoundItem::latest()
                ->take(5)
                ->get(),

            'pendingClaims' => Claim::where('status', 'menunggu')
                ->latest()
                ->take(5)
                ->get(),

        ]);
    }
}