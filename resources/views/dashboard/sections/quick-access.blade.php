<section class="mt-10">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- LEFT --}}

            <div class="bg-white rounded-3xl shadow-card p-8">

                <h2 class="text-3xl font-bold text-primary-dark">

                    Akses Cepat

                </h2>

                <div class="grid grid-cols-2 gap-6 mt-8">

                    <x-dashboard-action-card title="Cari Barang Hilang" icon="images/Cari_Biru.png"
                        href="{{ route('lost-items.index') }}" />

                    <x-dashboard-action-card title="Lapor Barang Ditemukan" icon="images/Lapor_Biru.png"
                        href="{{ route('found-items.create') }}" />

                    <x-dashboard-action-card title="Status Klaim Saya" icon="images/Status_Biru.png"
                        href="{{ route('claims.index') }}" />

                    <x-dashboard-action-card title="Edit Profil" icon="images/Profil_Biru.png"
                        href="{{ route('profile.edit') }}" />

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="bg-white rounded-3xl shadow-card p-8">

                <div class="flex justify-between items-center">

                    <h2 class="text-3xl font-bold text-primary-dark">
                        Aktivitas Terkini
                    </h2>

                    <a href="{{ route('lost-items.index') }}" class="text-primary font-semibold hover:underline">

                        Lihat Semua

                    </a>

                </div>

                <div class="mt-8 space-y-8">

                    @forelse($recentActivities as $activity)
                        @php
                            $activityRoute = '#';
                            if ($activity['type'] == 'lost') {
                                $activityRoute = route('lost-items.show', $activity['id']);
                            } elseif ($activity['type'] == 'found') {
                                $activityRoute = route('found-items.show', $activity['id']);
                            } elseif ($activity['type'] == 'claim') {
                                $activityRoute = route('claims.index');
                            }
                        @endphp

                        <a href="{{ $activityRoute }}" class="block group">
                            <div class="flex gap-5 p-3 -mx-3 rounded-2xl transition duration-200 group-hover:bg-blue-50">

                                {{-- FOTO / ICON --}}
                                <div class="h-16 w-16 flex-none overflow-hidden rounded-xl bg-blue-100">

                                    @if ($activity['photo'])
                                        <img src="{{ asset('storage/' . $activity['photo']) }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">

                                            @if ($activity['type'] == 'lost')
                                                <img src="{{ asset('images/Pencarian.png') }}" class="w-7">
                                            @elseif($activity['type'] == 'found')
                                                <img src="{{ asset('images/Aman.png') }}" class="w-7">
                                            @else
                                                <img src="{{ asset('images/Aman.png') }}" class="w-7">
                                            @endif

                                        </div>
                                    @endif

                                </div>

                                {{-- KONTEN --}}
                                <div class="flex-1 min-w-0">

                                    <div class="flex justify-between gap-4">

                                        <div>

                                            <h3 class="font-semibold truncate group-hover:text-primary transition">

                                                {{ $activity['title'] }}

                                            </h3>

                                            <p class="text-body">

                                                @switch($activity['type'])
                                                    @case('lost')
                                                        Laporan Kehilangan
                                                    @break

                                                    @case('found')
                                                        Barang Ditemukan
                                                    @break

                                                    @case('claim')
                                                        Pengajuan Klaim
                                                    @break
                                                @endswitch

                                            </p>

                                        </div>

                                        <span class="text-sm text-gray-400 whitespace-nowrap">

                                            {{ $activity['created_at']->diffForHumans() }}

                                        </span>

                                    </div>

                                    {{-- Badge Status --}}
                                    @php

                                        $badge = match ($activity['type']) {
                                            'lost' => 'bg-red-100 text-red-600',

                                            'found' => 'bg-yellow-100 text-yellow-700',

                                            'claim' => 'bg-blue-100 text-primary',

                                            default => 'bg-gray-100 text-gray-700',
                                        };

                                    @endphp

                                    <span class="inline-flex mt-3 px-4 py-1 rounded-full text-sm {{ $badge }}">

                                        {{ Str::headline($activity['status']) }}

                                    </span>

                                </div>

                            </div>
                        </a>

                        @empty

                            <div
                                class="rounded-xl border border-dashed border-blue-100 bg-blue-50 px-5 py-6 text-center text-body">

                                Belum ada aktivitas.

                            </div>

                        @endforelse

                    </div>

                </div>

    </section>
