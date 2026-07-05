<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">

    <div class="px-8 mx-auto max-w-7xl">

        <div class="flex items-center justify-between h-20">

            {{-- 1. BAGIAN KIRI: Logo --}}
            <div class="flex items-center gap-3 shrink-0">

                <img src="{{ asset('images/Udayana_Logo.png') }}" class="object-contain w-auto h-12" alt="Logo">

                <h1 class="text-2xl font-bold text-primary">
                    Udayana Lost & Found
                </h1>

            </div>

            {{-- 2. BAGIAN TENGAH: Menu Navigasi Utama --}}
            <div class="items-center hidden gap-10 md:flex">

                <a href="{{ route('dashboard') }}"
                 class="{{ request()->routeIs('dashboard') ? 'font-semibold text-primary border-b-2 border-primary pb-1' : 'text-body hover:text-primary transition pb-1' }}">
                 Beranda
                </a>

                <a href="{{ route('lost-items.create') }}"
                    class="{{ request()->routeIs('lost-items.create') ? 'font-semibold text-primary border-b-2 border-primary pb-1' : 'text-body hover:text-primary transition' }}">
                    Barang Hilang
                </a>

<<<<<<< HEAD
                <a href="{{ route('found-items.index') }}"
                    class="{{ request()->routeIs('found-items.*') ? 'font-semibold text-primary border-b-2 border-primary pb-1' : 'text-body hover:text-primary transition' }}">
=======
                <a href="#" class="transition text-body hover:text-primary">
>>>>>>> be6692a8c95cffcbdbc2f726216a0dc81bfc8317
                    Barang Ditemukan
                </a>

                <a href="{{ route('claims.index') }}" 
                 class="{{ request()->routeIs('claims.*') ? 'font-semibold text-primary border-b-2 border-primary pb-1' : 'text-body hover:text-primary transition pb-1' }}">
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
                    class="absolute right-0 z-50 w-56 mt-2 bg-white border shadow-xl rounded-xl">

                    <a href="{{ route('profile.edit') }}" class="block px-5 py-3 hover:bg-gray-50">
                        Edit Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-5 py-3 text-left text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</nav>
