<?php

namespace Database\Seeders;

use App\Models\LostItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class LostItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // Distribusi status realistis (total 25 laporan)
        // hilang: baru dilaporkan, belum ada tindakan
        LostItem::factory()->count(5)->hilang()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // dicari: petugas sedang mencari
        LostItem::factory()->count(10)->dicari()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // ditemukan: barang berhasil ditemukan
        LostItem::factory()->count(6)->ditemukan()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // selesai: barang sudah dikembalikan ke pemilik
        LostItem::factory()->count(4)->selesai()->create([
            'user_id' => fn () => $users->random()->id,
        ]);
    }
}
