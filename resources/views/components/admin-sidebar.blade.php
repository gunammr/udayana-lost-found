<aside class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 shadow-sm z-50 overflow-y-auto">

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
    <nav class="mt-6">

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
           class="flex items-center gap-4 px-6 py-4 hover:bg-gray-100">

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
           class="flex items-center gap-4 px-6 py-4 hover:bg-gray-100">

            <img
                src="{{ asset(
                    request()->routeIs('admin.locations.*')
                    ? 'images/icons/lokasi-active.svg'
                    : 'images/icons/lokasi.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola Lokasi</span>

        </a>

        <a href="#"
           class="flex items-center gap-4 px-6 py-4 hover:bg-gray-100">

            <img
                src="{{ asset(
                    request()->routeIs('admin.claims.*')
                    ? 'images/icons/klaim-active.svg'
                    : 'images/icons/klaim.svg'
                ) }}"
                class="w-5 h-5">

            <span>Kelola Klaim</span>

        </a>

        <a href="#"
           class="flex items-center gap-4 px-6 py-4 hover:bg-gray-100">

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

</aside>