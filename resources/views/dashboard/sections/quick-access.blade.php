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

                    @forelse (($recentLostItems ?? collect()) as $item)
                        <div class="flex gap-5">

                            <div class="h-16 w-16 flex-none overflow-hidden rounded-xl bg-blue-100">

                                @if ($item->photo_path)
                                    <img
                                        src="{{ asset('storage/' . $item->photo_path) }}"
                                        alt="Foto {{ $item->item_name }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <img
                                            src="{{ asset('images/Pencarian.png') }}"
                                            alt=""
                                            class="w-7">
                                    </div>
                                @endif

                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex gap-4 justify-between">

                                    <div class="min-w-0">

                                        <h3 class="truncate font-semibold">

                                            {{ $item->item_name }}

                                        </h3>

                                        <p class="text-body">

                                            Laporan Kehilangan

                                        </p>

                                    </div>

                                    <span class="flex-none text-sm text-gray-400">

                                        {{ $item->created_at?->diffForHumans() }}

                                    </span>

                                </div>

                                <span
                                    class="inline-block mt-3 px-4 py-1 rounded-full text-sm bg-gray-100">

                                    {{ str($item->status)->replace('_', ' ')->title() }}

                                </span>

                            </div>

                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-blue-100 bg-blue-50/50 px-5 py-6 text-center text-body">
                            Belum ada laporan terbaru.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</section>
