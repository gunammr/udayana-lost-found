<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">

    <div class="px-8 mx-auto max-w-7xl">

        {{-- Grid 3 kolom: kiri (logo) | tengah (nav) | kanan (profil) --}}
        <div class="grid h-20 items-center" style="grid-template-columns: 1fr auto 1fr;">

            {{-- 1. KIRI: Logo --}}
            <div class="flex items-center gap-3">

                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/Udayana_Logo.png') }}" class="object-contain w-auto h-12" alt="Logo">
                    <span class="text-xl font-bold text-primary whitespace-nowrap">
                        Udayana Lost &amp; Found
                    </span>
                </a>

            </div>

            {{-- 2. TENGAH: Menu Navigasi Utama --}}
            <div class="items-center hidden gap-8 md:flex">

                <a href="{{ route('home') }}"
                   class="text-sm font-medium whitespace-nowrap transition
                          {{ request()->routeIs('home') ? 'text-primary border-b-2 border-primary pb-0.5' : 'text-body hover:text-primary' }}">
                    Beranda
                </a>

                <a href="{{ route('lost-items.index') }}"
                   class="text-sm font-medium whitespace-nowrap transition
                          {{ request()->routeIs('lost-items.*') ? 'text-primary border-b-2 border-primary pb-0.5' : 'text-body hover:text-primary' }}">
                    Barang Hilang
                </a>

                <a href="{{ route('found-items.index') }}"
                   class="text-sm font-medium whitespace-nowrap transition
                          {{ request()->routeIs('found-items.*') ? 'text-primary border-b-2 border-primary pb-0.5' : 'text-body hover:text-primary' }}">
                    Barang Ditemukan
                </a>

                <a href="#"
                   class="text-sm font-medium whitespace-nowrap text-body hover:text-primary transition">
                    Klaim Saya
                </a>

            </div>

            {{-- 3. KANAN: Profile Dropdown --}}
            <div class="flex justify-end">

                <div x-data="{ open: false }" class="relative">

                    <button @click="open = !open"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-primary border border-primary/30 rounded-xl bg-soft-blue/30 hover:bg-soft-blue transition">

                        {{-- Avatar initial --}}
                        @if (Auth::user()->avatar_path)
                            <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" class="object-cover w-7 h-7 rounded-full shrink-0">
                        @else
                            <span class="flex items-center justify-center w-7 h-7 rounded-full bg-primary text-white text-xs font-bold shrink-0">
                                {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif

                        <span class="hidden lg:block max-w-[140px] truncate">
                            {{ Auth::user()->name }}
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-primary/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 z-50 w-52 mt-2 bg-white border border-gray-100 shadow-xl rounded-xl overflow-hidden">

                        <div class="px-4 py-3 border-b border-gray-100 bg-background/60">
                            <p class="text-xs text-body/70">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-primary-dark truncate">{{ Auth::user()->name }}</p>
                        </div>

                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-4 py-3 text-sm text-body hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-3 text-sm text-body hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2.5 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</nav>
