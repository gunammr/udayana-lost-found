<?php

namespace Database\Factories;

use App\Models\FoundItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Claim>
 */
class ClaimFactory extends Factory
{
    private const MESSAGES = [
        'Saya yakin ini adalah barang saya. Saya kehilangan barang tersebut di area yang sama sekitar waktu yang sama.',
        'Barang ini milik saya. Saya bisa mendeskripsikan isi di dalamnya secara detail sebagai bukti kepemilikan.',
        'Saya kehilangan barang ini beberapa hari yang lalu. Ciri-cirinya sangat cocok dengan yang saya miliki.',
        'Ini barang saya. Terdapat tanda khusus di bagian bawah yang dapat membuktikan kepemilikan.',
        'Saya siap untuk dihubungi dan hadir untuk mengidentifikasi barang ini secara langsung.',
        'Saya kehilangan barang ini saat sedang kuliah. Mohon dapat dikembalikan karena sangat penting bagi saya.',
        'Barang ini sangat penting untuk keperluan kuliah saya. Saya siap menunjukkan bukti kepemilikan.',
        'Saya telah mencari barang ini ke mana-mana. Sangat senang jika ini memang barang milik saya.',
    ];

    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'found_item_id' => FoundItem::factory(),
            'message'       => $this->faker->randomElement(self::MESSAGES),
            'status'        => $this->faker->randomElement([
                'menunggu',
                'menunggu',
                'diterima',
                'ditolak',
            ]),
            'admin_note'    => $this->faker->boolean(40)
                ? $this->faker->randomElement([
                    'Klaim telah diverifikasi dan barang sudah diserahkan kepada pemilik.',
                    'Klaim diterima setelah pemilik menunjukkan bukti kepemilikan yang valid.',
                    'Klaim ditolak karena deskripsi tidak sesuai dengan kondisi barang.',
                    'Harap menghubungi pelapor secara langsung untuk proses serah terima.',
                ])
                : null,
        ];
    }

    /** State: menunggu verifikasi */
    public function menunggu(): static
    {
        return $this->state(fn () => [
            'status'     => 'menunggu',
            'admin_note' => null,
        ]);
    }

    /** State: klaim diterima */
    public function diterima(): static
    {
        return $this->state(fn () => [
            'status'     => 'diterima',
            'admin_note' => 'Klaim telah diverifikasi dan barang sudah diserahkan kepada pemilik.',
        ]);
    }

    /** State: klaim ditolak */
    public function ditolak(): static
    {
        return $this->state(fn () => [
            'status'     => 'ditolak',
            'admin_note' => 'Klaim ditolak karena deskripsi yang diberikan tidak sesuai dengan kondisi barang.',
        ]);
    }
}
