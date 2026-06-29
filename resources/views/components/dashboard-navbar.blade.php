<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">

    <div class="max-w-7xl mx-auto px-8">

        <div class="h-20 flex justify-between items-center">

            {{-- 1. BAGIAN KIRI: Logo --}}
            <div class="flex items-center gap-3 shrink-0">

                <img src="{{ asset('images/Udayana_Logo.png') }}" class="w-10 h-10" alt="Logo">

                <h1 class="text-2xl font-bold text-primary">
                    Udayana Lost & Found
                </h1>

            </div>

            {{-- 2. BAGIAN TENGAH: Menu Navigasi Utama --}}
            <div class="hidden md:flex items-center gap-10">

                <a href="{{ route('dashboard') }}" class="font-semibold text-primary border-b-2 border-primary pb-1">
                    Beranda
                </a>

                <a href="#" class="text-body hover:text-primary transition">
                    Barang Hilang
                </a>

                <a href="#" class="text-body hover:text-primary transition">
                    Barang Ditemukan
                </a>

                <a href="#" class="text-body hover:text-primary transition">
                    Klaim Saya
                </a>

            </div>

            {{-- 3. BAGIAN KANAN: Profile Dropdown --}}
            <div x-data="{ open: false }" class="relative shrink-0">

                <button @click="open = !open"
                    class="bg-primary text-white px-5 py-2.5 rounded-xl flex items-center gap-2 hover:bg-primary-hover transition">

                    <span>
                        {{ Auth::user()->name }}
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>

                </button>

                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border z-50">

                    <a href="{{ route('profile.edit') }}" class="block px-5 py-3 hover:bg-gray-50">
                        Edit Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-5 py-3 text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</nav>