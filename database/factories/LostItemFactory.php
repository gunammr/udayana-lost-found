<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Status alur Lost Item: hilang → dicari → ditemukan → selesai
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LostItem>
 */
class LostItemFactory extends Factory
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
        ['Dompet Kulit Coklat',    'Aksesori',  'Dompet kulit warna coklat berisi KTP, kartu mahasiswa, dan uang tunai sekitar Rp 150.000. Terakhir terlihat di kantin kampus.'],
        ['Kunci Motor Yamaha',     'Kunci',     'Kunci motor Yamaha NMAX warna hitam dengan gantungan kunci berbentuk roda gigi. Hilang di area parkiran Gedung Rektorat.'],
        ['Handphone Samsung',      'Elektronik','Samsung Galaxy A54 warna hijau muda dengan case transparan. Hilang di perpustakaan saat saya meninggalkan meja sebentar.'],
        ['Buku Kuliah Statistik',  'Dokumen',   'Buku teks Statistika Dasar edisi ke-3, sudah ada coretan dan tanda penting di dalamnya. Hilang di kelas Gedung FISIP.'],
        ['Kacamata Minus Kotak',   'Aksesori',  'Kacamata minus -2.5 dengan frame kotak warna tortoiseshell. Hilang di lapangan olahraga saat berolahraga.'],
        ['Laptop Lenovo ThinkPad', 'Elektronik','Laptop Lenovo ThinkPad warna hitam berisi data tugas akhir yang sangat penting. Hilang di perpustakaan pusat.'],
        ['KTM + SIM A',            'Dokumen',   'Kartu Tanda Mahasiswa dan SIM A bersama di dalam dompet kecil. Hilang di kantin Fakultas Hukum.'],
        ['Kunci Mobil Honda',      'Kunci',     'Remote kunci mobil Honda Brio silver dengan 3 tombol. Hilang di parkiran Gedung Pascasarjana.'],
        ['Jam Tangan Fossil',      'Aksesori',  'Jam tangan Fossil tipe FS5660 warna silver. Hilang mungkin saat berwudhu di masjid kampus.'],
        ['Tas Selempang Hitam',    'Aksesori',  'Tas selempang hitam berisi charger laptop, notes, dan pulpen. Hilang di halte bus dalam kampus.'],
        ['Earphone Sennheiser',    'Elektronik','Earphone kabel Sennheiser warna putih. Hilang di ruang baca perpustakaan lantai 3.'],
        ['Kunci Kamar Kost',       'Kunci',     'Kunci kamar kost bermerk Kino warna kuning. Hilang setelah kuliah sore di Gedung Agrokompleks.'],
        ['Ijazah SMA',             'Dokumen',   'Ijazah SMA Negeri 1 Denpasar tahun 2023 atas nama Kadek Mahendra. Hilang saat mengurus berkas di gedung administrasi.'],
        ['Mouse Wireless Logitech','Elektronik','Mouse wireless Logitech M235 warna hitam-abu. Hilang di lab komputer Fakultas Ekonomi.'],
        ['Dompet Merah Muda',      'Aksesori',  'Dompet warna merah muda dengan monogram LL berisi uang Rp 200.000 dan kartu mahasiswa. Hilang di area foodcourt.'],
    ];

    public function definition(): array
    {
        $item        = $this->faker->randomElement(self::ITEMS);
        $photoSeed   = $this->faker->numberBetween(200, 400);
        $incidentDate = $this->faker->dateTimeBetween('-6 months', 'now');

        return [
            'item_name'     => $item[0],
            'category'      => $item[1],
            'incident_date' => $incidentDate,
            'location'      => $this->faker->randomElement(self::LOCATIONS),
            'description'   => $item[2],
            'photo_path'    => $this->faker->boolean(70)
                ? "https://picsum.photos/seed/{$photoSeed}/800/600"
                : null,
            'reporter_name' => $this->faker->name(),
            'phone'         => $this->faker->numerify('08##########'),
            // Default: hilang (belum ada update status)
            'status'        => 'hilang',
            'dicari_at'     => null,
            'ditemukan_at'  => null,
            'selesai_at'    => null,
        ];
    }

    // ── States ───────────────────────────────────────────────────────────

    /** Baru dilaporkan, belum ada tindakan */
    public function hilang(): static
    {
        return $this->state(fn (array $attrs) => [
            'status'      => 'hilang',
            'dicari_at'   => null,
            'ditemukan_at'=> null,
            'selesai_at'  => null,
        ]);
    }

    /** Petugas sedang mencari */
    public function dicari(): static
    {
        return $this->state(function (array $attrs) {
            $base = $attrs['created_at'] ?? now()->subDays(rand(3, 30));
            $dicariAt = $this->faker->dateTimeBetween($base, '+2 hours');
            return [
                'status'      => 'dicari',
                'dicari_at'   => $dicariAt,
                'ditemukan_at'=> null,
                'selesai_at'  => null,
            ];
        });
    }

    /** Barang sudah ditemukan, menunggu klaim */
    public function ditemukan(): static
    {
        return $this->state(function (array $attrs) {
            $base     = $attrs['created_at'] ?? now()->subDays(rand(5, 60));
            $dicariAt    = $this->faker->dateTimeBetween($base, '+3 hours');
            $ditemukanAt = $this->faker->dateTimeBetween($dicariAt, '+2 days');
            return [
                'status'      => 'ditemukan',
                'dicari_at'   => $dicariAt,
                'ditemukan_at'=> $ditemukanAt,
                'selesai_at'  => null,
            ];
        });
    }

    /** Barang sudah dikembalikan ke pemilik */
    public function selesai(): static
    {
        return $this->state(function (array $attrs) {
            $base     = $attrs['created_at'] ?? now()->subDays(rand(10, 90));
            $dicariAt    = $this->faker->dateTimeBetween($base, '+3 hours');
            $ditemukanAt = $this->faker->dateTimeBetween($dicariAt, '+2 days');
            $selesaiAt   = $this->faker->dateTimeBetween($ditemukanAt, '+5 days');
            return [
                'status'      => 'selesai',
                'dicari_at'   => $dicariAt,
                'ditemukan_at'=> $ditemukanAt,
                'selesai_at'  => $selesaiAt,
            ];
        });
    }
}
