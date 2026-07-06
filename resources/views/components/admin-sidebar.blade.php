<aside class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 shadow-sm z-50 flex flex-col">

    {{-- Logo --}}
    <div class="px-6 py-6 border-b">

        <div class="flex items-center gap-3">

            <img
                src="{{ asset('images/Udayana_Logo.png') }}"
                class="w-10 h-13"
                alt="Logo">

            <div>

                <h1 class="font-bold text-2xl text-gray-800">
                    Admin Panel
                </h1>

                <p class="text-sm text-gray-500">
                    Udayana Lost & Found
                </p>

            </div>

        </div>

    </div>

    {{-- Menu --}}
    <nav class="mt-6 flex-1 overflow-y-auto pb-4">

        <a href="{{ route('dashboard.admin') }}"
        class="flex items-center gap-4 px-6 py-4 transition
        {{ request()->routeIs('dashboard.admin')
                ? 'border-l-4 border-blue-700 bg-blue-50 text-blue-700 font-semibold'
                : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }}">

            <img
                src="{{ asset(
                    request()->routeIs('dashboard.admin')
                    ? 'images/icons/Dashboard-active.svg'
                    : 'images/icons/Dashboard.svg'
                ) }}"
                class="w-5 h-5"
                alt="Dashboard">

            <span>Dashboard</span>

        </a>

        <a href="{{ route('admin.lost-items.index') }}"
            class="flex items-center gap-4 px-6 py-4 transition
            {{ request()->routeIs('admin.lost-items.*')
                ? 'border-l-4 border-blue-700 bg-blue-50 text-blue-700 font-semibold'
                : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }}">

            <img
                src="{{ asset(
                    request()->routeIs('admin.lost-items.*')
                    ? 'images/icons/hilang-active.svg'
                    : 'images/icons/hilang.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola Barang Hilang</span>

        </a>

        <a href="{{ route('admin.found-items.index') }}"
            class="flex items-center gap-4 px-6 py-4 transition
            {{ request()->routeIs('admin.found-items.*')
                ? 'border-l-4 border-blue-700 bg-blue-50 text-blue-700 font-semibold'
                : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }}">

             <img
                src="{{ asset(
                    request()->routeIs('admin.found-items.*')
                    ? 'images/icons/ketemu-active.svg'
                    : 'images/icons/ketemu.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola Barang Ditemukan</span>

        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="flex items-center gap-4 px-6 py-4 transition
            {{ request()->routeIs('admin.categories.*')
                ? 'border-l-4 border-blue-700 bg-blue-50 text-blue-700 font-semibold'
                : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }}">

            <img
                src="{{ asset(
                    request()->routeIs('admin.categories.*')
                    ? 'images/icons/kategori-active.svg'
                    : 'images/icons/kategori.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola Kategori</span>

        </a>

        <a href="#"
           class="flex items-center gap-4 px-6 py-4 transition
           {{ request()->routeIs('admin.claims.*')
               ? 'border-l-4 border-blue-700 bg-blue-50 text-blue-700 font-semibold'
               : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }}">

            <img
                src="{{ asset(
                    request()->routeIs('admin.claims.*')
                    ? 'images/icons/klaim-active.svg'
                    : 'images/icons/klaim.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola Klaim</span>

        </a>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-4 px-6 py-4 transition
           {{ request()->routeIs('admin.users.*')
               ? 'border-l-4 border-blue-700 bg-blue-50 text-blue-700 font-semibold'
               : 'text-gray-600 hover:bg-gray-100 hover:text-blue-600' }}">

            <img
                src="{{ asset(
                    request()->routeIs('admin.users.*')
                    ? 'images/icons/user-active.svg'
                    : 'images/icons/user.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola User</span>

        </a>

    </nav>

    {{-- Logout --}}
    <div class="mt-auto border-t p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-50 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>

</aside>