<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoundItem>
 */
class FoundItemFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Elektronik', 'Dokumen', 'Aksesori', 'Kunci', 'Lainnya'];

        $items = [
            ['Dompet Kulit Hitam', 'Aksesori', 'Dompet kulit berwarna hitam berisi kartu identitas dan uang tunai. Ditemukan di dekat parkiran rektorat.'],
            ['Kunci Motor Honda', 'Kunci', 'Satu buah kunci motor Honda dengan gantungan kunci warna merah. Ditemukan di depan Gedung Agrokompleks.'],
            ['Laptop ASUS Vivobook', 'Elektronik', 'Laptop ASUS Vivobook warna abu-abu dengan stiker warna-warni di bagian belakang. Ditemukan di perpustakaan lantai 2.'],
            ['Kartu Mahasiswa Unud', 'Dokumen', 'Kartu Mahasiswa Universitas Udayana atas nama Budi Santoso. Ditemukan di kantin Fakultas Teknik.'],
            ['Earphone TWS Putih', 'Elektronik', 'Earphone TWS warna putih di dalam casing pengisi daya. Ditemukan di ruang tunggu Gedung Rektorat.'],
            ['Tas Ransel Hitam', 'Aksesori', 'Tas ransel merk Eiger warna hitam berisi buku dan alat tulis. Ditemukan di halte bus dalam kampus.'],
            ['Kacamata Frame Hitam', 'Aksesori', 'Kacamata minus dengan frame hitam tipis. Ditemukan di meja perpustakaan pusat.'],
            ['Flashdisk Kingston 32GB', 'Elektronik', 'Flashdisk Kingston warna merah kapasitas 32GB. Ditemukan di lab komputer Fakultas MIPA.'],
            ['Buku Catatan Biru', 'Dokumen', 'Buku catatan hardcover berwarna biru berisi catatan kuliah. Ditemukan di bangku taman depan Gedung Widya Sabha.'],
            ['Jam Tangan Casio', 'Aksesori', 'Jam tangan Casio G-Shock warna hitam. Ditemukan di lapangan basket kampus.'],
            ['Kunci Gembok Sepeda', 'Kunci', 'Kunci gembok sepeda warna kuning dengan kode. Ditemukan di area parkir sepeda Fakultas Kedokteran.'],
            ['Powerbank Xiaomi', 'Elektronik', 'Powerbank Xiaomi 10000mAh warna putih. Ditemukan di loker Gedung Agrobisnis.'],
        ];

        $item = $this->faker->randomElement($items);
        $photoIndex = $this->faker->numberBetween(1, 100);

        return [
            'item_name'     => $item[0],
            'category'      => $item[1],
            'incident_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'location'      => $this->faker->randomElement([
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
            ]),
            'description'   => $item[2],
            'photo_path'    => "https://picsum.photos/seed/{$photoIndex}/800/600",
            'reporter_name' => 'Anonim',
            'phone'         => $this->faker->numerify('08##########'),
            'status'        => 'ditemukan',
        ];
    }
}
