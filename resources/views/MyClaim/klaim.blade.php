@use('Illuminate\Support\Str')
@extends('layouts.app')

@section('content')
<div class="px-8 py-12 mx-auto max-w-7xl">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

        <div class="lg:col-span-1">
            @include('profile.partials.profile_card')
        </div>

        <div class="lg:col-span-3">
            <h1 class="mb-6 text-3xl font-bold text-gray-800">Riwayat Aktivitas</h1>

            <div class="flex gap-6 mb-8 text-sm font-medium border-b border-gray-200">
                <a href="{{ route('claims.index') }}"
                    class="{{ request()->routeIs('claims.index') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    Semua Aktivitas
                </a>
                <a href="{{ route('claims.laporan') }}"
                    class="{{ request()->routeIs('claims.laporan') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    Laporan Kehilangan
                </a>
                <a href="{{ route('claims.ditemukan') }}"
                    class="{{ request()->routeIs('claims.ditemukan') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    Laporan Ditemukan
                </a>
                <a href="{{ route('claims.status') }}"
                    class="{{ request()->routeIs('claims.status') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    Status Klaim
                </a>
            </div>

            <div class="flex flex-wrap gap-6">
                @forelse ($items as $item)
                    @php
                        $status  = $item->status ?? 'menunggu';
                        [$statusStyle, $statusLabel] = match($status) {
                            'menunggu' => ['bg-amber-100 text-amber-700', 'Menunggu'],
                            'diterima' => ['bg-green-100 text-green-700', 'Diterima'],
                            'ditolak'  => ['bg-red-100 text-red-700',    'Ditolak'],
                            default    => ['bg-gray-100 text-gray-700',   ucfirst($status)],
                        };

                        $createdAt = \Carbon\Carbon::parse($item->created_at);
                        $updatedAt = \Carbon\Carbon::parse($item->updated_at);
                        $dateStr   = \Carbon\Carbon::parse($item->incident_date)->translatedFormat('d M Y');

                        // Deskripsi barang (dari foundItem), pesan klaim dari pengklaim
                        $itemDescription = $item->item_description ?? $item->description ?? '-';
                        $claimMessage    = $item->claim_message ?? $item->description ?? '-';
                    @endphp

                    <div x-data="{ openDetail: false }" class="w-full sm:w-[calc(50%-0.75rem)]">

                        <div class="flex flex-col justify-between h-full overflow-hidden transition bg-white border border-gray-200 shadow-sm cursor-pointer rounded-2xl hover:shadow-md"
                             @click="openDetail = true">

                            <div class="relative flex items-center justify-center h-48 overflow-hidden bg-gray-50">
                                @if (isset($item->photo_path) && $item->photo_path)
                                    <img src="{{ Str::startsWith($item->photo_path, ['http://', 'https://']) ? $item->photo_path : asset('storage/' . $item->photo_path) }}"
                                         class="object-cover w-full h-full">
                                @else
                                    <div class="flex flex-col items-center text-gray-300 gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        <span class="text-xs">Tidak ada foto</span>
                                    </div>
                                @endif
                                <span class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full {{ $statusStyle }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="flex flex-col justify-between flex-1 p-5">
                                <div>
                                    <p class="mb-1 text-[10px] font-semibold uppercase tracking-wider text-blue-400">Pengajuan Klaim</p>
                                    <h4 class="mb-2 text-lg font-bold text-gray-800">{{ $item->item_name }}</h4>
                                    {{-- Card ringkas: tampilkan pesan klaim sebagai ringkasan --}}
                                    <p class="text-sm text-gray-500 line-clamp-3">{{ Str::limit($claimMessage, 90) }}</p>
                                </div>
                                <div class="flex items-center justify-between pt-4 mt-4 text-xs text-gray-400 border-t border-gray-100">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                                        </svg>
                                        {{ $dateStr }}
                                    </span>
                                    <button class="font-bold text-blue-600 hover:underline">Detail →</button>
                                </div>
                            </div>
                        </div>

                        {{-- Modal --}}
                        <div x-show="openDetail"
                             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-cloak>

                            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative text-left"
                                 @click.outside="openDetail = false">

                                <button @click="openDetail = false"
                                        class="absolute z-10 p-2 transition rounded-full shadow-md top-4 left-4 bg-white/80 hover:bg-white">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>

                                {{-- Foto --}}
                                <div class="relative w-full h-64 bg-gray-100">
                                    @if (isset($item->photo_path) && $item->photo_path)
                                        <img src="{{ Str::startsWith($item->photo_path, ['http://', 'https://']) ? $item->photo_path : asset('storage/' . $item->photo_path) }}"
                                             class="object-cover w-full h-full">
                                    @else
                                        <div class="flex flex-col items-center justify-center w-full h-full text-gray-300 gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="absolute top-4 right-4 {{ $statusStyle }} px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <div class="p-8">
                                    <p class="mb-1 text-xs font-semibold uppercase tracking-wider text-blue-400">Pengajuan Klaim</p>
                                    <h2 class="mb-2 text-2xl font-bold text-gray-800">{{ $item->item_name }}</h2>
                                    {{-- Deskripsi barang ditemukan (bukan pesan klaim) --}}
                                    <p class="mb-6 text-sm text-gray-500 leading-relaxed">{{ $itemDescription }}</p>

                                    {{-- Info grid dari DB --}}
                                    <div class="p-6 mb-6 bg-gray-50 rounded-2xl">
                                        <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                                            @if (!empty($item->category))
                                            <div>
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Kategori</p>
                                                <p class="text-sm font-bold text-gray-700">{{ $item->category }}</p>
                                            </div>
                                            @endif
                                            <div>
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Tanggal</p>
                                                <p class="text-sm font-bold text-gray-700">{{ $dateStr }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">ID Barang Ditemukan</p>
                                                <p class="text-sm font-bold text-gray-700">#{{ $item->found_item_id ?? $item->id }}</p>
                                            </div>
                                            @if (!empty($item->phone))
                                            <div>
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Kontak</p>
                                                <p class="text-sm font-bold text-gray-700">{{ $item->phone }}</p>
                                            </div>
                                            @endif
                                            @if (!empty($item->location))
                                            <div class="col-span-2">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Lokasi</p>
                                                <p class="flex items-center gap-1 text-sm font-bold text-blue-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                                    </svg>
                                                    {{ $item->location }}
                                                </p>
                                            </div>
                                            @endif

                                            {{-- Status Barang Ditemukan sebagai badge --}}
                                            <div class="col-span-2 pt-4 mt-1 border-t border-gray-200">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-2">Status Klaim</p>
                                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold
                                                    {{ $status === 'diterima' ? 'bg-green-100 text-green-800' : ($status === 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-amber-400 text-amber-950') }}">
                                                    @if ($status === 'menunggu')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    @elseif($status === 'diterima')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    @endif
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>

                                            {{-- Bukti Kepemilikan: pesan dari pengklaim --}}
                                            <div class="col-span-2 pt-1">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-2">Bukti Kepemilikan</p>
                                                <p class="text-sm text-gray-600 leading-relaxed break-words">{{ $claimMessage }}</p>
                                            </div>

                                            {{-- Foto Bukti (jika ada) --}}
                                            @if (!empty($item->photo_path) && $item->item_type === 'claim')
                                            @php
                                                // photo_path dari claim sendiri (bukan found item)
                                                // Diakses via klaim object yang dipetakan di MyClaim controller
                                                $claimPhotoPath = $item->claim_photo_path ?? null;
                                            @endphp
                                            @if (!empty($claimPhotoPath))
                                            <div class="col-span-2">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-2">Foto Bukti</p>
                                                <img src="{{ \Illuminate\Support\Str::startsWith($claimPhotoPath, ['http://', 'https://']) ? $claimPhotoPath : asset('storage/' . $claimPhotoPath) }}"
                                                     alt="Foto bukti klaim"
                                                     class="w-full rounded-xl object-cover max-h-48 border border-gray-100">
                                            </div>
                                            @endif
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Riwayat Status dengan timestamp --}}
                                    <h3 class="mb-4 text-sm font-bold text-gray-800">Riwayat Status</h3>
                                    <div class="space-y-5 relative before:absolute before:left-[7px] before:top-4 before:bottom-4 before:w-0.5 before:bg-gray-100">

                                        {{-- 1. Klaim Diajukan --}}
                                        <div class="relative pl-8">
                                            <div class="absolute left-0 w-4 h-4 bg-blue-600 border-4 border-white rounded-full shadow-sm top-0.5"></div>
                                            <p class="text-sm font-bold text-gray-800">Klaim Diajukan</p>
                                            <p class="text-xs text-gray-400">Pengajuan klaim diterima dan menunggu verifikasi admin</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $createdAt->translatedFormat('d M Y, H:i') }}</p>
                                        </div>

                                        {{-- 2. Sedang Diverifikasi / hasil --}}
                                        @php $step2Active = in_array($status, ['diterima', 'ditolak']); @endphp
                                        <div class="relative pl-8">
                                            <div class="absolute left-0 top-0.5 w-4 h-4 {{ $step2Active ? ($status === 'ditolak' ? 'bg-red-500' : 'bg-blue-600') : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                            <p class="text-sm font-bold {{ $step2Active ? 'text-gray-800' : 'text-gray-300' }}">
                                                @if ($status === 'diterima') Klaim Diterima ✓
                                                @elseif($status === 'ditolak') Klaim Ditolak ✗
                                                @else Menunggu Verifikasi Admin
                                                @endif
                                            </p>
                                            <p class="text-xs {{ $step2Active ? 'text-gray-400' : 'text-gray-300' }}">
                                                Admin memeriksa bukti kepemilikan yang diajukan
                                            </p>
                                            <p class="text-xs {{ $step2Active ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">
                                                {{ $step2Active ? $updatedAt->translatedFormat('d M Y, H:i') : '—' }}
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @empty
                    <div class="w-full py-12 text-center bg-white border border-gray-100 rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-gray-400">Belum ada klaim yang diajukan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection