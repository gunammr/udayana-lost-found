<?php

namespace Database\Seeders;

use App\Models\LostItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class LostItemSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user yang ada atau buat baru
        $users = User::all();

        // Buat 20 laporan barang hilang dengan distribusi status yang realistis
        LostItem::factory()->count(12)->dicari()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        LostItem::factory()->count(5)->ditemukan()->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        LostItem::factory()->count(3)->selesai()->create([
            'user_id' => fn () => $users->random()->id,
        ]);
    }
}
