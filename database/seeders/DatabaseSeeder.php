<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun uji utama
        User::factory()->create([
            'name'          => 'Test User',
            'email'         => 'test@example.com',
            'nim'           => '2301010001',
            'tahun_angkatan'=> '2023',
            'program_studi' => 'Teknik Informatika',
            'fakultas'      => 'Teknik',
            'phone'         => '081234567890',
        ]);

        // Buat 10 user tambahan dengan profil lengkap
        User::factory()->count(10)->create();

        // Seed data dalam urutan yang benar (dependencies first)
        $this->call([
            FoundItemSeeder::class,  // barang ditemukan
            LostItemSeeder::class,   // barang hilang
            ClaimSeeder::class,      // klaim (bergantung pada found_items & users)
        ]);
    }
}
