<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        $users      = User::all();
        $foundItems = FoundItem::all();

        if ($users->isEmpty() || $foundItems->isEmpty()) {
            return;
        }

        // Buat klaim untuk sebagian barang ditemukan
        // Setiap barang maksimal diklaim oleh 1-2 user berbeda
        $foundItems->random(min(10, $foundItems->count()))->each(function (FoundItem $item) use ($users) {

            // Pilih 1 atau 2 user berbeda untuk mengajukan klaim
            $claimants = $users->random(min($this->fake()->numberBetween(1, 2), $users->count()));

            foreach ($claimants as $user) {
                Claim::firstOrCreate(
                    [
                        'user_id'       => $user->id,
                        'found_item_id' => $item->id,
                    ],
                    [
                        'message'    => $this->randomMessage(),
                        'status'     => $this->randomStatus(),
                        'admin_note' => null,
                    ]
                );
            }
        });
    }

    private function randomMessage(): string
    {
        $messages = [
            'Saya yakin ini adalah barang saya. Saya kehilangan barang tersebut di area yang sama sekitar waktu yang sama.',
            'Barang ini milik saya. Saya bisa mendeskripsikan isi di dalamnya secara detail sebagai bukti kepemilikan.',
            'Saya kehilangan barang ini beberapa hari yang lalu. Ciri-cirinya sangat cocok dengan yang saya miliki.',
            'Ini barang saya. Terdapat tanda khusus di bagian bawah yang dapat membuktikan kepemilikan.',
            'Saya siap untuk dihubungi dan hadir untuk mengidentifikasi barang ini secara langsung.',
            'Saya kehilangan barang ini saat sedang kuliah. Mohon dapat dikembalikan karena sangat penting bagi saya.',
        ];

        return $messages[array_rand($messages)];
    }

    private function randomStatus(): string
    {
        $statuses = ['menunggu', 'menunggu', 'menunggu', 'diterima', 'ditolak'];
        return $statuses[array_rand($statuses)];
    }

    private function fake(): \Faker\Generator
    {
        return \Faker\Factory::create('id_ID');
    }
}
