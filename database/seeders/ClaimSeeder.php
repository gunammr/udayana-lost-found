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

        // 1. Pastikan setiap FoundItem dengan status 'dikembalikan' atau 'selesai'
        //    memiliki tepat satu claim dengan status 'diterima' (data konsisten).
        $itemsNeedingDiterimaClaim = $foundItems->whereIn('status', ['dikembalikan', 'selesai']);
        foreach ($itemsNeedingDiterimaClaim as $item) {
            $claimer = $users->where('id', '!=', $item->user_id)->random();
            Claim::firstOrCreate(
                [
                    'user_id'       => $claimer->id,
                    'found_item_id' => $item->id,
                ],
                [
                    'message'    => $this->randomMessage(),
                    'status'     => 'diterima',
                    'admin_note' => null,
                    'photo_path' => $this->fake()->boolean(70) 
                        ? 'imagesdemo/' . $this->fake()->randomElement([
                            'buktikepemilikan1.png', 'fotokepemilikan2.png', 'fotokepemilikan3.png'
                        ])
                        : null,
                ]
            );
        }

        // 2. Buat klaim tambahan untuk sebagian barang ditemukan lainnya
        $remainingItems = $foundItems
            ->whereNotIn('status', ['dikembalikan', 'selesai'])
            ->random(min(8, $foundItems->whereNotIn('status', ['dikembalikan', 'selesai'])->count()));

        foreach ($remainingItems as $item) {
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
                        'photo_path' => $this->fake()->boolean(70) 
                            ? 'imagesdemo/' . $this->fake()->randomElement([
                                'buktikepemilikan1.png', 'fotokepemilikan2.png', 'fotokepemilikan3.png'
                            ])
                            : null,
                    ]
                );
            }
        }
    }

    private function randomMessage(): string
    {
        $messages = [
            'Halo, saya sangat yakin barang ini adalah milik saya. Saya kehilangan barang tersebut di sekitar area yang sama persis seperti yang disebutkan, kira-kira pada jam 2 siang kemarin. Sebagai bukti tambahan, ada sedikit goresan di bagian ujung kanan bawah barang tersebut akibat pernah terjatuh. Jika diperbolehkan, saya bersedia datang langsung untuk membuktikannya.',
            'Selamat pagi/siang, barang yang ditemukan ini memiliki ciri-ciri yang 100% cocok dengan milik saya. Di dalamnya terdapat sebuah kartu nama lama milik saya dan sedikit noda tinta di bagian dalam saku kecilnya. Saya bisa menyebutkan detail spesifik lainnya jika diperlukan untuk verifikasi.',
            'Saya kehilangan barang ini dua hari yang lalu saat sedang terburu-buru menuju kelas. Bukti kuat bahwa ini milik saya adalah terdapat stiker kecil bergambar kucing yang sudah agak pudar di bagian belakangnya. Saya juga melampirkan foto yang saya ambil minggu lalu saat barang ini masih ada di tangan saya.',
            'Ini benar-benar barang saya yang hilang. Terdapat tanda khusus berupa inisial nama saya yang digoreskan kecil di bagian bawahnya. Selain itu, tali pengikatnya sudah sedikit terkelupas karena sering digunakan. Saya sangat berharap barang ini bisa dikembalikan.',
            'Saya siap untuk dihubungi kapan saja dan hadir ke lokasi untuk mengidentifikasi barang ini secara langsung. Untuk meyakinkan pihak admin, saya memiliki kotak kemasan asli dan nota pembelian yang nomor serinya akan sama persis dengan yang ada di fisik barang tersebut.',
            'Barang ini tertinggal saat saya sedang duduk mengerjakan tugas di sekitar lokasi penemuan. Sebagai bukti kepemilikan, wallpaper layarnya adalah foto keluarga saya, dan terdapat retakan halus memanjang di antigores bagian atas layarnya. Mohon bantuannya untuk mengembalikan barang ini.',
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
