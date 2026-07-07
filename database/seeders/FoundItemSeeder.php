<?php

namespace Database\Seeders;

use App\Models\FoundItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class FoundItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // Distribusi status realistis (total 25 laporan temuan)
        // ditemukan: baru dilaporkan, belum ada yang klaim
        FoundItem::factory()->count(14)->ditemukan()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // diklaim: ada yang mengajukan klaim, sedang diproses
        FoundItem::factory()->count(5)->diklaim()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // dikembalikan: barang sudah diserahkan, menunggu konfirmasi
        FoundItem::factory()->count(3)->dikembalikan()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // selesai: proses selesai sepenuhnya
        FoundItem::factory()->count(3)->selesai()->create([
            'user_id' => fn () => $users->random()->id,
        ]);
    }
}
