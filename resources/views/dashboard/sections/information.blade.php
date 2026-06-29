<section class="mt-10 mb-20">

    <div class="max-w-7xl mx-auto px-8">

        <div class="bg-[#EAF2FF] rounded-[28px] p-8 lg:p-14">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

                {{-- Kolom Kiri: Area Gambar (Porsi 5 Kolom dari 12) --}}
                <div class="lg:col-span-5 flex justify-center w-full">
                    <img src="{{ asset('images/Rektorat.jpg') }}" 
                         alt="Ilustrasi Pengambilan Barang" 
                         class="w-full max-w-[340px] lg:max-w-full h-auto object-contain rounded-2xl">
                </div>

                {{-- Kolom Kanan: Konten Informasi (Porsi 7 Kolom dari 12) --}}
                <div class="lg:col-span-7">

                    {{-- Label --}}
                    <div class="flex items-center gap-2 text-primary font-semibold uppercase tracking-wide text-sm">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 8h.01M11 12h1v4h1" />
                        </svg>

                        <span>
                            Informasi Penting
                        </span>

                    </div>

                    {{-- Judul --}}
                    <h2 class="mt-4 text-3xl lg:text-4xl font-bold text-primary-dark leading-tight">
                        Pengambilan Barang di Gedung Rektorat
                    </h2>

                    {{-- Deskripsi --}}
                    <p class="mt-4 text-body leading-relaxed text-base lg:text-lg">
                        Mulai minggu ini, seluruh barang temuan dengan kategori
                        elektronik berharga (Laptop, Handphone, Tablet)
                        akan dipusatkan pengambilannya di Ruang Kemahasiswaan
                        Gedung Rektorat Lt. 1 untuk keamanan ekstra.
                        Pastikan membawa KTM asli saat mengklaim.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>