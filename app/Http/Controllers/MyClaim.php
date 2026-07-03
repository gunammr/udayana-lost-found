<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\LostItem;

class MyClaim extends Controller
{
    private function getDummyItems()
    {
        return collect([
            (object)[
                'id' => 991,
                'item_name' => 'Laptop Asus ROG',
                'description' => 'Saya kehilangan laptop ini di Perpustakaan Pusat lantai 2 sekitar jam 10 pagi.',
                'status' => 'dicari',
                'photo_path' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&q=80&w=500',
                'incident_date' => now()->subDays(2),
            ],
            (object)[
                'id' => 992,
                'item_name' => 'TWS Samsung Galaxy Buds',
                'description' => 'Tertinggal di gazebo FEB setelah kelas sore.',
                'status' => 'ditemukan',
                'photo_path' => 'https://images.unsplash.com/photo-1608156639585-b3a032ef9689?auto=format&fit=crop&q=80&w=500',
                'incident_date' => now()->subDays(5),
            ],
            (object)[
                'id' => 993,
                'item_name' => 'KTM (Kartu Tanda Mahasiswa)',
                'description' => 'KTM tercecer di sekitar kantin rektorat.',
                'status' => 'selesai',
                'photo_path' => 'https://images.unsplash.com/photo-1620288627223-53302f4e8c74?auto=format&fit=crop&q=80&w=500',
                'incident_date' => now()->subDays(10),
            ],
        ]);
    }

    private function allItemsForUser()
    {
        $realItems = LostItem::where('user_id', Auth::id())->latest()->get();

        // pakai concat(), BUKAN merge(), supaya item asli tidak tertimpa dummy
        return collect($realItems)->concat($this->getDummyItems());
    }

    public function index()
    {
        $allItems = $this->allItemsForUser();

        return view('myclaim.semua_aktivitas', [
            'items'        => $allItems,
            'totalLaporan' => $allItems->whereIn('status', ['dicari', 'ditemukan'])->count(),
            'totalKlaim'   => $allItems->where('status', 'selesai')->count(),
        ]);
    }

    public function laporan()
    {
        $allItems = $this->allItemsForUser()->whereIn('status', ['dicari', 'ditemukan']);

        return view('myclaim.laporan', [
            'items'        => $allItems,
            'totalLaporan' => $allItems->count(),
            'totalKlaim'   => $this->allItemsForUser()->where('status', 'selesai')->count(),
        ]);
    }

    public function status()
    {
        $all = $this->allItemsForUser();
        $claimItems = $all->where('status', 'selesai');

        return view('myclaim.klaim', [
            'items'        => $claimItems,
            'totalLaporan' => $all->whereIn('status', ['dicari', 'ditemukan'])->count(),
            'totalKlaim'   => $claimItems->count(),
        ]);
    }
}