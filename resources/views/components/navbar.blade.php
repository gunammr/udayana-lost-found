<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-6">

        <div class="h-20 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <img src="{{ asset('images/Udayana_Logo.png') }}" alt="Logo Universitas Udayana" class="w-10 h-10">

                <span class="text-2xl font-bold text-primary">

                    Udayana Lost & Found

                </span>

            </a>

            {{-- Menu --}}
            <div class="hidden lg:flex items-center gap-10">

                <a href="{{ route('home') }}" class="font-medium text-body hover:text-primary transition">

                    Beranda

                </a>

                <a href="#" class="font-medium text-body hover:text-primary transition">

                    Barang Hilang

                </a>

                <a href="#" class="font-medium text-body hover:text-primary transition">

                    Barang Ditemukan

                </a>

                <a href="#" class="font-medium text-body hover:text-primary transition">

                    Klaim Saya

                </a>

            </div>

            {{-- Button Login / Profile --}}
            <div>

                @auth

                    <a href="{{ route('dashboard') }}"
                        class="px-5 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-hover transition">

                        Profile

                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-primary-hover transition">

                        Login

                    </a>

                @endauth

            </div>

        </div>

    </div>

</nav>
