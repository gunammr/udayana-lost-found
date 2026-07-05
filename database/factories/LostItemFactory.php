<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
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
        ['Dompet Kulit Coklat',   'Aksesori',  'Dompet kulit warna coklat berisi KTP, kartu mahasiswa, dan uang tunai sekitar Rp 150.000. Terakhir terlihat di kantin kampus.'],
        ['Kunci Motor Yamaha',    'Kunci',     'Kunci motor Yamaha NMAX warna hitam dengan gantungan kunci berbentuk roda gigi. Hilang di area parkiran Gedung Rektorat.'],
        ['Handphone Samsung',     'Elektronik','Samsung Galaxy A54 warna hijau muda dengan case transparan. Hilang di perpustakaan saat saya meninggalkan meja sebentar.'],
        ['Buku Kuliah Statistik', 'Dokumen',   'Buku teks Statistika Dasar edisi ke-3, sudah ada coretan dan tanda penting di dalamnya. Hilang di kelas Gedung FISIP.'],
        ['Kacamata Minus Kotak',  'Aksesori',  'Kacamata minus -2.5 dengan frame kotak warna tortoiseshell. Hilang di lapangan olahraga saat berolahraga.'],
        ['Laptop Lenovo ThinkPad','Elektronik','Laptop Lenovo ThinkPad warna hitam berisi data tugas akhir yang sangat penting. Hilang di perpustakaan pusat.'],
        ['KTM + SIM A',           'Dokumen',   'Kartu Tanda Mahasiswa dan SIM A bersama di dalam dompet kecil. Hilang di kantin Fakultas Hukum.'],
        ['Kunci Mobil Honda',     'Kunci',     'Remote kunci mobil Honda Brio silver dengan 3 tombol. Hilang di parkiran Gedung Pascasarjana.'],
        ['Jam Tangan Fossil',     'Aksesori',  'Jam tangan Fossil tipe FS5660 warna silver. Hilang mungkin saat berwudhu di masjid kampus.'],
        ['Tas Selempang Hitam',   'Aksesori',  'Tas selempang hitam berisi charger laptop, notes, dan pulpen. Hilang di halte bus dalam kampus.'],
        ['Earphone Sennheiser',   'Elektronik','Earphone kabel Sennheiser warna putih. Hilang di ruang baca perpustakaan lantai 3.'],
        ['Kunci Kamar Kost',      'Kunci',     'Kunci kamar kost bermerk Kino warna kuning. Hilang setelah kuliah sore di Gedung Agrokompleks.'],
        ['Ijazah SMA',            'Dokumen',   'Ijazah SMA Negeri 1 Denpasar tahun 2023 atas nama Kadek Mahendra. Hilang saat mengurus berkas di gedung administrasi.'],
        ['Mouse Wireless Logitech','Elektronik','Mouse wireless Logitech M235 warna hitam-abu. Hilang di lab komputer Fakultas Ekonomi.'],
        ['Dompet Merah Muda',     'Aksesori',  'Dompet warna merah muda dengan monogram LL berisi uang Rp 200.000 dan kartu mahasiswa. Hilang di area foodcourt.'],
    ];

    public function definition(): array
    {
        $item      = $this->faker->randomElement(self::ITEMS);
        $photoSeed = $this->faker->numberBetween(200, 400);

        return [
            'item_name'     => $item[0],
            'category'      => $item[1],
            'incident_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'location'      => $this->faker->randomElement(self::LOCATIONS),
            'description'   => $item[2],
            'photo_path'    => $this->faker->boolean(70)
                ? "https://picsum.photos/seed/{$photoSeed}/800/600"
                : null, // 30% tanpa foto
            'reporter_name' => $this->faker->name(),
            'phone'         => $this->faker->numerify('08##########'),
            'status'        => $this->faker->randomElement([
                'dicari',
                'dicari',
                'dicari', // mayoritas masih dicari
                'ditemukan',
                'selesai',
            ]),
        ];
    }

    /** State: masih dicari */
    public function dicari(): static
    {
        return $this->state(fn () => ['status' => 'dicari']);
    }

    /** State: sudah ditemukan */
    public function ditemukan(): static
    {
        return $this->state(fn () => ['status' => 'ditemukan']);
    }

    /** State: selesai */
    public function selesai(): static
    {
        return $this->state(fn () => ['status' => 'selesai']);
    }
}
