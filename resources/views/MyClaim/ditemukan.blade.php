@use('Illuminate\Support\Str')
@extends('layouts.app')

@section('content')

{{-- Flash Messages --}}
@if (session('success'))
    <div id="flash-success"
         class="fixed top-6 left-1/2 z-[200] -translate-x-1/2 flex items-center gap-3 rounded-2xl bg-emerald-500 px-6 py-3.5 text-sm font-semibold text-white shadow-xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        {{ session('success') }}
    </div>
    <script>setTimeout(()=>{ const el=document.getElementById('flash-success'); if(el) el.remove(); }, 5000);</script>
@endif

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
                        $itemType = $item->item_type ?? 'lost';
                        $status   = $item->status ?? '';

                        if ($itemType === 'lost') {
                            [$statusStyle, $statusLabel] = match($status) {
                                'hilang'    => ['bg-red-100 text-red-700',    'Hilang'],
                                'dicari'    => ['bg-amber-100 text-amber-700','Dicari'],
                                'ditemukan' => ['bg-blue-100 text-blue-700',  'Ditemukan'],
                                'selesai'   => ['bg-green-100 text-green-700','Selesai'],
                                default     => ['bg-gray-100 text-gray-700',  ucfirst($status)],
                            };
                        } elseif ($itemType === 'found') {
                            [$statusStyle, $statusLabel] = match($status) {
                                'ditemukan'    => ['bg-emerald-100 text-emerald-700', 'Ditemukan'],
                                'diklaim'      => ['bg-amber-100 text-amber-700',     'Diklaim'],
                                'dikembalikan' => ['bg-blue-100 text-blue-700',       'Dikembalikan'],
                                'selesai'      => ['bg-gray-100 text-gray-700',       'Selesai'],
                                default        => ['bg-gray-100 text-gray-700',       ucfirst($status)],
                            };
                        } else {
                            // claim
                            [$statusStyle, $statusLabel] = match($status) {
                                'menunggu' => ['bg-amber-100 text-amber-700', 'Menunggu'],
                                'diterima' => ['bg-green-100 text-green-700', 'Diterima'],
                                'ditolak'  => ['bg-red-100 text-red-700',    'Ditolak'],
                                default    => ['bg-gray-100 text-gray-700',   ucfirst($status)],
                            };
                        }

                        $createdAt       = \Carbon\Carbon::parse($item->created_at);
                        $updatedAt       = \Carbon\Carbon::parse($item->updated_at);
                        $dateStr         = \Carbon\Carbon::parse($item->incident_date)->translatedFormat('d M Y');
                        $itemDescription = $item->item_description ?? $item->description ?? '-';
                        $claimMessage    = $item->claim_message ?? $item->description ?? '-';
                        
                        $cardSummary = $itemType === 'claim' ? $claimMessage : ($item->description ?? '-');
                        
                        $badgeText = match($itemType) {
                            'lost'  => 'Laporan Kehilangan',
                            'found' => 'Laporan Ditemukan',
                            'claim' => 'Pengajuan Klaim',
                            default => 'Laporan',
                        };
                        $badgeColor = match($itemType) {
                            'lost'  => 'text-red-400',
                            'found' => 'text-emerald-400',
                            'claim' => 'text-blue-400',
                            default => 'text-gray-400',
                        };
                    @endphp

                    {{-- ===== CARD ===== --}}
                    <div x-data="{ openDetail: false }" class="w-full sm:w-[calc(50%-0.75rem)]">

                        <div class="flex flex-col justify-between h-full overflow-hidden transition bg-white border border-gray-200 shadow-sm cursor-pointer rounded-2xl hover:shadow-md"
                             @click="openDetail = true">

                            {{-- Thumbnail --}}
                            <div class="relative flex items-center justify-center h-48 overflow-hidden bg-gray-50">
                                @if (!empty($item->photo_path))
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

                            {{-- Card body --}}
                            <div class="flex flex-col justify-between flex-1 p-5">
                                <div>
                                    <p class="mb-1 text-[10px] font-semibold uppercase tracking-wider {{ $badgeColor }}">
                                        {{ $badgeText }}
                                    </p>
                                    <h4 class="mb-2 text-lg font-bold text-gray-800">{{ $item->item_name }}</h4>
                                    <p class="text-sm text-gray-500 line-clamp-3">{{ Str::limit($cardSummary, 90) }}</p>
                                </div>
                                {{-- Tampilkan info pengeklaim di card jika status selesai --}}
                                @if ($itemType === 'found' && $status === 'selesai' && !empty($item->accepted_claimer))
                                    <div class="mt-3 flex items-center gap-2 rounded-xl bg-emerald-50 border border-emerald-100 px-3 py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-emerald-700 truncate">{{ $item->accepted_claimer->name }}</p>
                                            @if (!empty($item->accepted_claimer->phone))
                                                <p class="text-[10px] text-emerald-600">{{ $item->accepted_claimer->phone }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
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

                        {{-- ===== MODAL ===== --}}
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

                                {{-- Foto besar --}}
                                <div class="relative w-full h-64 bg-gray-100">
                                    @if (!empty($item->photo_path))
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

                                {{-- Konten modal --}}
                                <div class="p-8">

                                    <p class="mb-1 text-xs font-semibold uppercase tracking-wider {{ $badgeColor }}">
                                        {{ $badgeText }}
                                    </p>
                                    <h2 class="mb-2 text-2xl font-bold text-gray-800">{{ $item->item_name }}</h2>

                                    {{-- Deskripsi: barang untuk lost, deskripsi foundItem untuk claim --}}
                                    <p class="mb-6 text-sm text-gray-500 leading-relaxed">
                                        {{ $itemType === 'lost' ? ($item->description ?? '-') : $itemDescription }}
                                    </p>

                                    {{-- Info grid --}}
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
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Jenis</p>
                                                <p class="text-sm font-bold text-gray-700">{{ $badgeText }}</p>
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
                                            @if ($itemType === 'claim')
                                            <div class="col-span-2 pt-1">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-2">Bukti Kepemilikan</p>
                                                <p class="text-sm text-gray-600 leading-relaxed">{{ $claimMessage }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Riwayat Status --}}
                                    <h3 class="mb-4 text-sm font-bold text-gray-800">Riwayat Status</h3>
                                    <div class="space-y-5 relative before:absolute before:left-[7px] before:top-4 before:bottom-4 before:w-0.5 before:bg-gray-100">

                                        @if ($itemType === 'lost')
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 w-4 h-4 bg-blue-600 border-4 border-white rounded-full shadow-sm top-0.5"></div>
                                                <p class="text-sm font-bold text-gray-800">Laporan Dibuat</p>
                                                <p class="text-xs text-gray-400">Laporan kehilangan diterima dan dicatat</p>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $createdAt->translatedFormat('d M Y, H:i') }}</p>
                                            </div>
                                            @php $s2 = in_array($status, ['dicari','ditemukan','selesai']); @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $s2 ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $s2 ? 'text-gray-800' : 'text-gray-300' }}">Dicari</p>
                                                <p class="text-xs {{ $s2 ? 'text-gray-400' : 'text-gray-300' }}">Petugas sedang mencari di area yang dilaporkan</p>
                                                <p class="text-xs {{ $s2 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $s2 && !empty($item->dicari_at) ? \Carbon\Carbon::parse($item->dicari_at)->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                            @php $s3 = in_array($status, ['ditemukan','selesai']); @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $s3 ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $s3 ? 'text-gray-800' : 'text-gray-300' }}">Ditemukan</p>
                                                <p class="text-xs {{ $s3 ? 'text-gray-400' : 'text-gray-300' }}">Barang ditemukan dan dapat diambil</p>
                                                <p class="text-xs {{ $s3 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $s3 && !empty($item->ditemukan_at) ? \Carbon\Carbon::parse($item->ditemukan_at)->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                            @php $s4 = $status === 'selesai'; @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $s4 ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $s4 ? 'text-gray-800' : 'text-gray-300' }}">Selesai</p>
                                                <p class="text-xs {{ $s4 ? 'text-gray-400' : 'text-gray-300' }}">Barang berhasil dikembalikan ke pemilik</p>
                                                <p class="text-xs {{ $s4 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $s4 && !empty($item->selesai_at) ? \Carbon\Carbon::parse($item->selesai_at)->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                        @elseif ($itemType === 'found')
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 w-4 h-4 bg-blue-600 border-4 border-white rounded-full shadow-sm top-0.5"></div>
                                                <p class="text-sm font-bold text-gray-800">Laporan Ditemukan Dibuat</p>
                                                <p class="text-xs text-gray-400">Barang ditemukan dan dilaporkan ke sistem</p>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $createdAt->translatedFormat('d M Y, H:i') }}</p>
                                            </div>
                                            @php $f2 = in_array($status, ['diklaim','dikembalikan','selesai']); @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $f2 ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $f2 ? 'text-gray-800' : 'text-gray-300' }}">Diklaim</p>
                                                <p class="text-xs {{ $f2 ? 'text-gray-400' : 'text-gray-300' }}">Ada pengguna yang mengajukan klaim kepemilikan</p>
                                                <p class="text-xs {{ $f2 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $f2 && !empty($item->diklaim_at) ? \Carbon\Carbon::parse($item->diklaim_at)->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                            @php $f3 = in_array($status, ['dikembalikan','selesai']); @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $f3 ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $f3 ? 'text-gray-800' : 'text-gray-300' }}">Dikembalikan</p>
                                                <p class="text-xs {{ $f3 ? 'text-gray-400' : 'text-gray-300' }}">Sedang dalam proses pengembalian</p>
                                                <p class="text-xs {{ $f3 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $f3 && !empty($item->dikembalikan_at) ? \Carbon\Carbon::parse($item->dikembalikan_at)->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                            @php $f4 = $status === 'selesai'; @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $f4 ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $f4 ? 'text-gray-800' : 'text-gray-300' }}">Selesai</p>
                                                <p class="text-xs {{ $f4 ? 'text-gray-400' : 'text-gray-300' }}">Proses selesai seluruhnya</p>
                                                <p class="text-xs {{ $f4 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $f4 && !empty($item->selesai_at) ? \Carbon\Carbon::parse($item->selesai_at)->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                        @else
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 w-4 h-4 bg-blue-600 border-4 border-white rounded-full shadow-sm top-0.5"></div>
                                                <p class="text-sm font-bold text-gray-800">Klaim Diajukan</p>
                                                <p class="text-xs text-gray-400">Pengajuan klaim diterima dan menunggu verifikasi admin</p>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $createdAt->translatedFormat('d M Y, H:i') }}</p>
                                            </div>
                                            @php $sk2 = in_array($status, ['diterima','ditolak']); @endphp
                                            <div class="relative pl-8">
                                                <div class="absolute left-0 top-0.5 w-4 h-4 {{ $sk2 ? ($status === 'ditolak' ? 'bg-red-500' : 'bg-blue-600') : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                                <p class="text-sm font-bold {{ $sk2 ? 'text-gray-800' : 'text-gray-300' }}">
                                                    @if ($status === 'diterima') Klaim Diterima ✓
                                                    @elseif($status === 'ditolak') Klaim Ditolak ✗
                                                    @else Menunggu Verifikasi Admin
                                                    @endif
                                                </p>
                                                <p class="text-xs {{ $sk2 ? 'text-gray-400' : 'text-gray-300' }}">Admin memeriksa bukti kepemilikan yang diajukan</p>
                                                <p class="text-xs {{ $sk2 ? 'text-gray-400' : 'text-gray-300' }} mt-0.5">{{ $sk2 ? $updatedAt->translatedFormat('d M Y, H:i') : '—' }}</p>
                                            </div>
                                        @endif

                                    </div>
                                    {{-- end riwayat status --}}

                                    {{-- Info pengeklaim jika status dikembalikan atau selesai --}}
                                    @if ($itemType === 'found' && in_array($status, ['dikembalikan', 'selesai']) && !empty($item->accepted_claimer))
                                        @php $claimer = $item->accepted_claimer; @endphp
                                        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 space-y-4">
                                            <h3 class="flex items-center gap-2 text-sm font-bold text-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Informasi Pengeklaim
                                            </h3>

                                            {{-- Nama & Kontak --}}
                                            <div class="flex items-center gap-4">
                                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-emerald-200 text-lg font-bold text-emerald-700">
                                                    {{ mb_strtoupper(mb_substr($claimer->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-emerald-800">{{ $claimer->name }}</p>
                                                    @if (!empty($claimer->phone))
                                                        <a href="tel:{{ $claimer->phone }}" class="mt-0.5 flex items-center gap-1 text-xs text-emerald-600 hover:underline">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                            </svg>
                                                            {{ $claimer->phone }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Pesan Bukti Kepemilikan --}}
                                            @if (!empty($claimer->message))
                                                <div class="rounded-xl border border-emerald-100 bg-white p-4">
                                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-emerald-500">Bukti Kepemilikan</p>
                                                    <p class="text-sm leading-relaxed text-gray-700 break-words">{{ $claimer->message }}</p>
                                                </div>
                                            @endif


                                            {{-- Foto Bukti --}}
                                            @if (!empty($claimer->photo_path))
                                                <div>
                                                    <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-emerald-500">Foto Bukti</p>
                                                    <img src="{{ Str::startsWith($claimer->photo_path, ['http://', 'https://']) ? $claimer->photo_path : asset('storage/' . $claimer->photo_path) }}"
                                                         alt="Foto bukti klaim"
                                                         class="w-full rounded-xl object-cover max-h-48 border border-emerald-100">
                                                </div>
                                            @endif
                                        </div>
                                    @endif


                                    {{-- Tombol Telah Dikembalikan (hanya jika status dikembalikan) --}}
                                    @if ($itemType === 'found' && $status === 'dikembalikan')
                                        <form method="POST" action="{{ route('my.found-items.mark-returned', $item->id) }}" class="mt-4">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Konfirmasi: Apakah barang ini benar-benar sudah dikembalikan ke pemiliknya?')"
                                                    class="w-full flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-600/25 transition hover:bg-blue-700 active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Telah Dikembalikan ke Pemilik
                                            </button>
                                        </form>
                                    @endif

                                </div>
                                {{-- end konten modal --}}

                            </div>
                            {{-- end modal box --}}

                        </div>
                        {{-- end modal overlay --}}

                    </div>
                    {{-- end card wrapper --}}

                @empty
                    <div class="w-full py-12 text-center bg-white border border-gray-100 rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <p class="text-sm text-gray-400">Belum ada laporan barang ditemukan.</p>
                    </div>
                @endforelse
            </div>
            {{-- end flex grid --}}

        </div>
        {{-- end col-span-3 --}}

    </div>
    {{-- end grid --}}

</div>
@endsection
