<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-8">

        <div class="text-center">

            <h2 class="text-5xl font-bold text-primary-dark">

                Fitur Utama

            </h2>

            <p class="mt-5 text-body text-lg">

                Sistem yang dirancang untuk memudahkan sivitas akademika Universitas Udayana.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-16">

            {{-- Card 1 --}}
            <div class="bg-background rounded-3xl p-10 shadow-card hover:-translate-y-2 transition duration-300">

                <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-white">

                    <img src="{{ asset('images/Cepat.png') }}" alt="Lapor Cepat" class="w-10 h-10 object-contain">

                </div>

                <h3 class="mt-8 text-3xl font-bold text-primary-dark">
                    Lapor Cepat
                </h3>

                <p class="mt-5 leading-8 text-body">
                    Proses pelaporan barang hilang atau ditemukan yang intuitif dan tidak memakan waktu lama.
                </p>

            </div>

            {{-- Card 2 --}}
            <div class="bg-background rounded-3xl p-10 shadow-card hover:-translate-y-2 transition duration-300">

                <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-white">

                    <img src="{{ asset('images/Pencarian.png') }}" alt="Pencarian Pintar"
                        class="w-10 h-10 object-contain">

                </div>

                <h3 class="mt-8 text-3xl font-bold text-primary-dark">
                    Pencarian Pintar
                </h3>

                <p class="mt-5 leading-8 text-body">
                    Filter berdasarkan kategori, lokasi, dan tanggal untuk menemukan barang dengan cepat.
                </p>

            </div>

            {{-- Card 3 --}}
            <div class="bg-background rounded-3xl p-10 shadow-card hover:-translate-y-2 transition duration-300">

                <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-white">

                    <img src="{{ asset('images/Aman.png') }}" alt="Klaim Aman" class="w-10 h-10 object-contain">

                </div>

                <h3 class="mt-8 text-3xl font-bold text-primary-dark">
                    Klaim Aman
                </h3>

                <p class="mt-5 leading-8 text-body">
                    Sistem verifikasi identitas memastikan barang kembali kepada pemilik yang sah.
                </p>

            </div>

        </div>

    </div>

</section>
