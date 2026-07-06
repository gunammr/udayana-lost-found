<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Status alur Found Item: ditemukan → diklaim → dikembalikan → selesai
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoundItem>
 */
class FoundItemFactory extends Factory
{
    private const LOCATIONS = [
        'Parkiran Rektorat',
        'Gedung Agrokompleks Lt. 2',
        'Perpustakaan Pusat Lt. 2',
        'Kantin Fakultas Teknik',
        'Halte Bus Dalam Kampus',
        'Lab Komputer Fakultas MIPA',
        'Taman Depan Widya Sabha',
        'Lapangan Basket Kampus',
        'Gedung Agrobisnis Lt. 1',
        'Loket Parkir Fakultas Kedokteran',
        'Masjid Kampus Jimbaran',
        'Gedung Pasca Sarjana',
        'Koperasi Mahasiswa',
        'Gedung Rektorat Lt. 3',
        'Area Foodcourt Kampus',
    ];

    private const ITEMS = [
        ['Dompet Kulit Hitam',     'Aksesori',  'Dompet kulit berwarna hitam berisi kartu identitas dan sejumlah uang tunai. Ditemukan di dekat parkiran rektorat.'],
        ['Kunci Motor Honda',      'Kunci',     'Satu buah kunci motor Honda dengan gantungan kunci warna merah dan tali putih. Ditemukan di depan Gedung Agrokompleks.'],
        ['Laptop ASUS Vivobook',   'Elektronik','Laptop ASUS Vivobook warna abu-abu dengan stiker warna-warni di bagian belakang. Ditemukan di perpustakaan lantai 2.'],
        ['Kartu Mahasiswa Unud',   'Dokumen',   'Kartu Mahasiswa Universitas Udayana atas nama Budi Santoso, Fakultas Teknik angkatan 2022. Ditemukan di kantin Fakultas Teknik.'],
        ['Earphone TWS Putih',     'Elektronik','Earphone TWS warna putih di dalam casing pengisi daya berwarna transparan. Ditemukan di ruang tunggu Gedung Rektorat.'],
        ['Tas Ransel Hitam',       'Aksesori',  'Tas ransel merk Eiger warna hitam berisi buku catatan dan alat tulis. Ditemukan di halte bus dalam kampus.'],
        ['Kacamata Frame Hitam',   'Aksesori',  'Kacamata minus dengan frame hitam tipis, lensa tidak tergores. Ditemukan di meja perpustakaan pusat.'],
        ['Flashdisk Kingston 32GB','Elektronik','Flashdisk Kingston warna merah kapasitas 32GB. Ditemukan tergeletak di meja lab komputer Fakultas MIPA.'],
        ['Buku Catatan Biru',      'Dokumen',   'Buku catatan hardcover berwarna biru berisi catatan kuliah mata kuliah Kalkulus. Ditemukan di bangku taman depan Gedung Widya Sabha.'],
        ['Jam Tangan Casio',       'Aksesori',  'Jam tangan Casio G-Shock warna hitam dengan tali karet hitam. Ditemukan di lapangan basket kampus.'],
        ['Kunci Gembok Sepeda',    'Kunci',     'Kunci gembok sepeda warna kuning dengan rantai baja. Ditemukan di area parkir sepeda Fakultas Kedokteran.'],
        ['Powerbank Xiaomi',       'Elektronik','Powerbank Xiaomi 10000mAh warna putih bersih tanpa goresan. Ditemukan di loker Gedung Agrobisnis.'],
        ['Dompet Warna Coklat',    'Aksesori',  'Dompet tipis warna coklat berisi kartu ATM dan kartu mahasiswa. Ditemukan di foodcourt kampus.'],
        ['Kunci Mobil Toyota',     'Kunci',     'Remote kunci mobil Toyota dengan logo Toyota. Ditemukan di parkiran Gedung Pascasarjana.'],
        ['SIM & KTP',              'Dokumen',   'SIM A dan KTP atas nama Ni Made Ayu. Ditemukan di kantin FISIP.'],
        ['Airpods Generasi 3',     'Elektronik','Airpods Apple generasi 3 di dalam case putih. Ditemukan di bangku taman rektorat.'],
        ['Headphone Sony',         'Elektronik','Headphone Sony WH-1000XM4 warna hitam. Ditemukan di lab bahasa Gedung Sastra.'],
        ['Kunci Kamar Kost',       'Kunci',     'Satu buah kunci kamar kost dengan gantungan warna ungu. Ditemukan di dekat pintu gerbang utama.'],
        ['Buku Panduan Skripsi',   'Dokumen',   'Buku panduan penulisan skripsi Universitas Udayana edisi 2024. Ditemukan di ruang baca perpustakaan.'],
        ['Charger Laptop Dell',    'Elektronik','Charger laptop Dell 65W warna hitam. Ditemukan di colokan listrik lobi Gedung Agrokompleks.'],
    ];

    public function definition(): array
    {
        $item      = $this->faker->randomElement(self::ITEMS);
        $photoSeed = $this->faker->numberBetween(10, 200);

        return [
            'item_name'      => $item[0],
            'category'       => $item[1],
            'incident_date'  => $this->faker->dateTimeBetween('-6 months', 'now'),
            'location'       => $this->faker->randomElement(self::LOCATIONS),
            'description'    => $item[2],
            'photo_path'     => "https://picsum.photos/seed/{$photoSeed}/800/600",
            'reporter_name'  => $this->faker->randomElement(['Anonim', 'Anonim', $this->faker->name()]),
            'phone'          => $this->faker->numerify('08##########'),
            // Default: baru ditemukan, belum diklaim
            'status'         => 'ditemukan',
            'diklaim_at'     => null,
            'dikembalikan_at'=> null,
            'selesai_at'     => null,
        ];
    }

    // ── States ───────────────────────────────────────────────────────────

    /** Baru ditemukan, belum ada yang mengklaim */
    public function ditemukan(): static
    {
        return $this->state(fn (array $attrs) => [
            'status'         => 'ditemukan',
            'diklaim_at'     => null,
            'dikembalikan_at'=> null,
            'selesai_at'     => null,
        ]);
    }

    /** Ada yang mengajukan klaim, sedang diproses */
    public function diklaim(): static
    {
        return $this->state(function (array $attrs) {
            $base      = $attrs['created_at'] ?? now()->subDays(rand(3, 30));
            $diklaimAt = $this->faker->dateTimeBetween($base, '+5 days');
            return [
                'status'         => 'diklaim',
                'diklaim_at'     => $diklaimAt,
                'dikembalikan_at'=> null,
                'selesai_at'     => null,
            ];
        });
    }

    /** Barang sudah diserahkan ke pemilik, menunggu konfirmasi */
    public function dikembalikan(): static
    {
        return $this->state(function (array $attrs) {
            $base            = $attrs['created_at'] ?? now()->subDays(rand(5, 60));
            $diklaimAt       = $this->faker->dateTimeBetween($base, '+5 days');
            $dikembalikanAt  = $this->faker->dateTimeBetween($diklaimAt, '+3 days');
            return [
                'status'         => 'dikembalikan',
                'diklaim_at'     => $diklaimAt,
                'dikembalikan_at'=> $dikembalikanAt,
                'selesai_at'     => null,
            ];
        });
    }

    /** Proses selesai sepenuhnya */
    public function selesai(): static
    {
        return $this->state(function (array $attrs) {
            $base            = $attrs['created_at'] ?? now()->subDays(rand(10, 90));
            $diklaimAt       = $this->faker->dateTimeBetween($base, '+5 days');
            $dikembalikanAt  = $this->faker->dateTimeBetween($diklaimAt, '+3 days');
            $selesaiAt       = $this->faker->dateTimeBetween($dikembalikanAt, '+2 days');
            return [
                'status'         => 'selesai',
                'diklaim_at'     => $diklaimAt,
                'dikembalikan_at'=> $dikembalikanAt,
                'selesai_at'     => $selesaiAt,
            ];
        });
    }
}
