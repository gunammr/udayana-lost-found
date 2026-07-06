<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\LostItem;
use App\Models\Claim;

class MyClaim extends Controller
{
    /**
     * Semua laporan barang hilang milik user yang login,
     * plus semua klaim yang mereka ajukan (pada barang ditemukan).
     */
    private function allItemsForUser()
    {
        // Laporan barang hilang yang dibuat user ini
        $lostItems = LostItem::where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(fn ($item) => (object) array_merge($item->toArray(), [
                'item_type' => 'lost',
            ]));

        // Klaim barang ditemukan yang diajukan user ini
        $claims = Claim::where('user_id', Auth::id())
            ->with('foundItem')
            ->latest()
            ->get()
            ->map(fn ($claim) => (object) [
                'id'            => $claim->id,
                'item_name'     => $claim->foundItem?->item_name ?? '-',
                'description'   => $claim->message,
                'status'        => $claim->status,   // menunggu | diterima | ditolak
                'photo_path'    => $claim->foundItem?->photo_path,
                'incident_date' => $claim->foundItem?->incident_date ?? $claim->created_at,
                'category'      => $claim->foundItem?->category ?? '-',
                'location'      => $claim->foundItem?->location ?? '-',
                'item_type'     => 'claim',
                'found_item_id' => $claim->found_item_id,
            ]);

        return $lostItems->concat($claims)->sortByDesc('incident_date')->values();
    }

    public function index()
    {
        $allItems = $this->allItemsForUser();

        return view('myclaim.semua_aktivitas', [
            'items'        => $allItems,
            'totalLaporan' => $allItems->where('item_type', 'lost')->count(),
            'totalKlaim'   => $allItems->where('item_type', 'claim')->count(),
        ]);
    }

    public function laporan()
    {
        $allItems  = $this->allItemsForUser();
        $laporan   = $allItems->where('item_type', 'lost')->values();

        return view('myclaim.laporan', [
            'items'        => $laporan,
            'totalLaporan' => $laporan->count(),
            'totalKlaim'   => $allItems->where('item_type', 'claim')->count(),
        ]);
    }

    public function status()
    {
        $allItems = $this->allItemsForUser();
        $klaim    = $allItems->where('item_type', 'claim')->values();

        return view('myclaim.klaim', [
            'items'        => $klaim,
            'totalLaporan' => $allItems->where('item_type', 'lost')->count(),
            'totalKlaim'   => $klaim->count(),
        ]);
    }
}