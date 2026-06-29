<footer class="bg-footer mt-24 rounded-t-[32px] border-t border-gray-100">

    <div class="max-w-7xl mx-auto px-8 pt-16 pb-12">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-y-10 gap-x-6 lg:gap-x-12 items-start">

            {{-- Kolom 1: Logo & Deskripsi (Diberi porsi 4 dari 12 kolom) --}}
            <div class="space-y-4 lg:col-span-4">

                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Udayana_Logo.png') }}"
                         alt="Logo Universitas Udayana"
                         class="w-12 h-12 object-contain">

                    <h3 class="text-xl font-bold text-primary-dark leading-tight">
                        Udayana Lost & Found
                    </h3>
                </div>

                <p class="text-sm leading-relaxed text-body max-w-[280px]">
                    Membangun komunitas kampus yang peduli dan saling membantu melalui sistem pelaporan barang hilang dan ditemukan.
                </p>

            </div>

            {{-- Kolom 2: Tautan Penting (Diberi porsi 2 dari 12 kolom) --}}
            <div class="lg:col-span-2 lg:pl-4">

                <h3 class="text-base font-bold text-primary-dark tracking-wide uppercase">
                    Tautan Penting
                </h3>

                <ul class="mt-4 space-y-2.5 text-sm">
                    <li>
                        <a href="#" class="text-body hover:text-primary transition-colors duration-200">
                            Hubungi Kami
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-body hover:text-primary transition-colors duration-200">
                            Peta Kampus
                        </a>
                    </li>
                </ul>

            </div>

            {{-- Kolom 3: Legal (Diberi porsi 2 dari 12 kolom) --}}
            <div class="lg:col-span-2">

                <h3 class="text-base font-bold text-primary-dark tracking-wide uppercase">
                    Legal
                </h3>

                <ul class="mt-4 space-y-2.5 text-sm">
                    <li>
                        <a href="#" class="text-body hover:text-primary transition-colors duration-200">
                            Syarat & Ketentuan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-body hover:text-primary transition-colors duration-200">
                            Kebijakan Privasi
                        </a>
                    </li>
                </ul>

            </div>

            {{-- Kolom 4: Kontak (Diberi porsi 4 dari 12 kolom agar teks alamat tidak patah jelek) --}}
            <div class="text-sm space-y-2 lg:col-span-4 lg:pl-6">

                <h3 class="text-base font-bold text-primary-dark tracking-wide uppercase">
                    Universitas Udayana
                </h3>

                <p class="text-body leading-relaxed pt-2">
                    Jimbaran, Badung,<br>
                    Bali 80361
                </p>

                <p class="pt-1">
                    <a href="mailto:info@unud.ac.id" class="text-body hover:text-primary transition-colors">
                        info@unud.ac.id
                    </a>
                </p>

            </div>

        </div>

        {{-- Garis Pembatas & Copyright Section --}}
        <div class="border-t border-blue-200/60 mt-12 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p class="text-body/80 text-center md:text-left w-full">
                    © {{ date('Y') }} Universitas Udayana. All rights reserved.
                </p>
            </div>
        </div>

    </div>

</footer>