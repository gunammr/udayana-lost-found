<section class="mt-10">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- LEFT --}}

            <div class="bg-white rounded-3xl shadow-card p-8">

                <h2 class="text-3xl font-bold text-primary-dark">

                    Akses Cepat

                </h2>

                <div class="grid grid-cols-2 gap-6 mt-8">

                    <x-dashboard-action-card
                        title="Cari Barang Hilang"
                        icon="images/Cari_Biru.png"/>

                    <x-dashboard-action-card
                        title="Lapor Barang Ditemukan"
                        icon="images/Lapor_Biru.png"/>

                    <x-dashboard-action-card
                        title="Status Klaim Saya"
                        icon="images/Status_Biru.png"/>

                    <x-dashboard-action-card
                        title="Edit Profil"
                        icon="images/Profil_Biru.png"/>

                </div>

            </div>

            {{-- RIGHT --}}

            <div class="bg-white rounded-3xl shadow-card p-8">

                <div class="flex justify-between items-center">

                    <h2
                        class="text-3xl font-bold text-primary-dark">

                        Aktivitas Terkini

                    </h2>

                    <a href="#"
                        class="text-primary font-semibold">

                        Lihat Semua

                    </a>

                </div>

                <div class="mt-8 space-y-8">

                    {{-- Item 1 --}}

                    <div class="flex gap-5">

                        <div
                            class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">

                            <img
                                src="{{ asset('images/Pencarian.png') }}"
                                class="w-6">

                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between">

                                <div>

                                    <h3 class="font-semibold">

                                        Dompet Hitam Kulit

                                    </h3>

                                    <p class="text-body">

                                        Laporan Kehilangan

                                    </p>

                                </div>

                                <span class="text-gray-400">

                                    2 jam lalu

                                </span>

                            </div>

                            <span
                                class="inline-block mt-3 px-4 py-1 rounded-full text-sm bg-gray-100">

                                Menunggu Verifikasi

                            </span>

                        </div>

                    </div>

                    {{-- Item 2 --}}

                    <div class="flex gap-5">

                        <div
                            class="w-14 h-14 rounded-full bg-warning flex items-center justify-center">

                            <img
                                src="{{ asset('images/Ditemukan.png') }}"
                                class="w-6">

                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between">

                                <div>

                                    <h3 class="font-semibold">

                                        Kunci Motor Honda

                                    </h3>

                                    <p class="text-body">

                                        Klaim Diajukan

                                    </p>

                                </div>

                                <span class="text-gray-400">

                                    Kemarin

                                </span>

                            </div>

                            <span
                                class="inline-block mt-3 px-4 py-1 rounded-full text-sm bg-yellow-100">

                                Diproses Admin

                            </span>

                        </div>

                    </div>

                    {{-- Item 3 --}}

                    <div class="flex gap-5">

                        <div
                            class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center">

                            <img
                                src="{{ asset('images/Berhasil.png') }}"
                                class="w-6 brightness-0 invert">

                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between">

                                <div>

                                    <h3 class="font-semibold">

                                        KTM Mahasiswa

                                    </h3>

                                    <p class="text-body">

                                        Klaim Selesai

                                    </p>

                                </div>

                                <span class="text-gray-400">

                                    3 Hari lalu

                                </span>

                            </div>

                            <span
                                class="inline-block mt-3 px-4 py-1 rounded-full text-sm bg-blue-100">

                                Berhasil

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>