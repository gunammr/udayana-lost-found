<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Claim;

class MyClaim extends Controller
{
    private function allItemsForUser()
    {
        // Laporan barang hilang yang dibuat user ini
        $lostItems = LostItem::with('latestFoundReport')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(fn ($item) => (object) array_merge($item->toArray(), [
                'item_type'    => 'lost',
                'created_at'   => $item->created_at,
                'updated_at'   => $item->updated_at,
                'dicari_at'    => $item->dicari_at,
                'ditemukan_at' => $item->ditemukan_at,
                'selesai_at'   => $item->selesai_at,
                'latestFoundReport' => $item->latestFoundReport,
            ]));

        // Laporan barang ditemukan yang dibuat user ini
        $foundItems = FoundItem::where('user_id', Auth::id())
            ->with(['acceptedClaim.user'])
            ->latest()
            ->get()
            ->map(fn ($item) => (object) array_merge($item->toArray(), [
                'item_type'         => 'found',
                'created_at'        => $item->created_at,
                'updated_at'        => $item->updated_at,
                'diklaim_at'        => $item->diklaim_at,
                'dikembalikan_at'   => $item->dikembalikan_at,
                'selesai_at'        => $item->selesai_at,
                'accepted_claimer'  => $item->acceptedClaim?->user
                    ? (object)[
                        'name'       => $item->acceptedClaim->user->name,
                        'phone'      => $item->acceptedClaim->user->phone,
                        'message'    => $item->acceptedClaim->message,
                        'photo_path' => $item->acceptedClaim->photo_path,
                    ]
                    : null,
            ]));

        // Klaim barang ditemukan yang diajukan user ini
        $claims = Claim::where('user_id', Auth::id())
            ->with('foundItem')
            ->latest()
            ->get()
            ->map(fn ($claim) => (object) [
                'id'                => $claim->id,
                'item_name'         => $claim->foundItem?->item_name ?? '-',
                'item_description'  => $claim->foundItem?->description ?? '-',
                'claim_message'     => $claim->message,
                'description'       => $claim->message,
                'status'            => $claim->status,
                'photo_path'        => $claim->foundItem?->photo_path,
                'claim_photo_path'  => $claim->photo_path,   // foto bukti dari si pengklaim
                'incident_date'     => $claim->foundItem?->incident_date ?? $claim->created_at,
                'category'          => $claim->foundItem?->category ?? '-',
                'location'          => $claim->foundItem?->location ?? '-',
                'phone'             => $claim->foundItem?->phone ?? null,
                'found_item_id'     => $claim->found_item_id,
                'item_type'         => 'claim',
                'created_at'        => $claim->created_at,
                'updated_at'        => $claim->updated_at,
            ]);

        return collect([])->concat($lostItems)->concat($foundItems)->concat($claims)->sortByDesc('incident_date')->values();
    }

    private function getCounts($allItems)
    {
        return [
            'totalLaporan'   => $allItems->where('item_type', 'lost')->count(),
            'totalDitemukan' => $allItems->where('item_type', 'found')->count(),
            'totalKlaim'     => $allItems->where('item_type', 'claim')->count(),
        ];
    }

    public function index()
    {
        $allItems = $this->allItemsForUser();
        $counts = $this->getCounts($allItems);

        return view('myclaim.semua_aktivitas', array_merge(['items' => $allItems], $counts));
    }

    public function laporan()
    {
        $allItems = $this->allItemsForUser();
        $laporan  = $allItems->where('item_type', 'lost')->values();
        $counts = $this->getCounts($allItems);

        return view('myclaim.laporan', array_merge(['items' => $laporan], $counts));
    }

    public function ditemukan()
    {
        $allItems = $this->allItemsForUser();
        $ditemukan = $allItems->where('item_type', 'found')->values();
        $counts = $this->getCounts($allItems);

        return view('myclaim.ditemukan', array_merge(['items' => $ditemukan], $counts));
    }

    public function status()
    {
        $allItems = $this->allItemsForUser();
        $klaim    = $allItems->where('item_type', 'claim')->values();
        $counts = $this->getCounts($allItems);

        return view('myclaim.klaim', array_merge(['items' => $klaim], $counts));
    }
}
