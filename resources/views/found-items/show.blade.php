@extends('layouts.landing')

@section('title', $foundItem->item_name . ' – Barang Ditemukan – Udayana Lost & Found')

@section('content')

    {{-- ================================================
         FLASH MESSAGES
    ================================================ --}}
    @if (session('success'))
        <div id="flash-success"
             class="fixed top-6 left-1/2 z-[200] -translate-x-1/2 flex items-center gap-3 rounded-2xl bg-emerald-500 px-6 py-3.5 text-sm font-semibold text-white shadow-xl animate-fade-in-down">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
        <script>setTimeout(()=>{ const el=document.getElementById('flash-success'); if(el) el.remove(); }, 5000);</script>
    @endif

    @if (session('error'))
        <div id="flash-error"
             class="fixed top-6 left-1/2 z-[200] -translate-x-1/2 flex items-center gap-3 rounded-2xl bg-red-500 px-6 py-3.5 text-sm font-semibold text-white shadow-xl animate-fade-in-down">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" /></svg>
            {{ session('error') }}
        </div>
        <script>setTimeout(()=>{ const el=document.getElementById('flash-error'); if(el) el.remove(); }, 5000);</script>
    @endif

    <section class="relative overflow-hidden bg-background py-10 lg:py-14">

        {{-- Decorative blobs --}}
        <div class="pointer-events-none absolute -top-20 right-20 h-80 w-80 rounded-full bg-soft-blue/30 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-10 left-10 h-60 w-60 rounded-full bg-warning/15 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-6">

            {{-- ================================================
                 BREADCRUMB
            ================================================ --}}
            <nav class="mb-8 flex items-center gap-2 text-sm text-body">
                <a href="{{ route('home') }}" class="hover:text-primary transition">Beranda</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                </svg>
                <a href="{{ route('found-items.index') }}" class="hover:text-primary transition">Barang Ditemukan</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                </svg>
                <span class="font-medium text-primary-dark line-clamp-1 max-w-[200px]">{{ $foundItem->item_name }}</span>
            </nav>

            {{-- ================================================
                 TWO COLUMN LAYOUT
            ================================================ --}}
            <div class="grid gap-8 lg:grid-cols-[45%_1fr] lg:gap-12 xl:gap-16 items-start">

                {{-- ====================================
                     LEFT: Photo
                ==================================== --}}
                <div class="relative">

                    <div class="relative overflow-hidden rounded-2xl shadow-card">

                        @if ($foundItem->photo_path)
                            <img
                                src="{{ Str::startsWith($foundItem->photo_path, 'http') ? $foundItem->photo_path : Storage::url($foundItem->photo_path) }}"
                                alt="{{ $foundItem->item_name }}"
                                class="aspect-[4/3] w-full object-cover"
                            >
                        @else
                            <div class="flex aspect-[4/3] w-full items-center justify-center bg-soft-blue/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2 1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-8h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                                </svg>
                            </div>
                        @endif

                        {{-- Status badge overlay (dinamis sesuai status item) --}}
                        <div class="absolute left-4 top-4">
                            @php
                                [$badgeBg, $badgeText] = match($foundItem->status) {
                                    'ditemukan'   => ['bg-emerald-500', 'Ditemukan'],
                                    'diklaim'     => ['bg-amber-500',   'Diklaim'],
                                    'dikembalikan'=> ['bg-blue-500',    'Dikembalikan'],
                                    'selesai'     => ['bg-gray-600',    'Selesai'],
                                    default       => ['bg-emerald-500', 'Ditemukan'],
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 rounded-full {{ $badgeBg }} px-4 py-1.5 text-sm font-bold uppercase tracking-wide text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $badgeText }}
                            </span>
                        </div>

                    </div>

                    {{-- Back button below image on desktop --}}
                    <a href="{{ route('found-items.index') }}"
                       class="mt-5 hidden items-center gap-2 text-sm font-semibold text-body transition hover:text-primary lg:inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7" />
                        </svg>
                        Kembali ke Daftar
                    </a>

                </div>

                {{-- ====================================
                     RIGHT: Details
                ==================================== --}}
                <div class="flex flex-col gap-6">

                    {{-- Header: Name + Pills --}}
                    <div>
                        <div class="flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-soft-blue/70 px-3 py-1 text-xs font-semibold text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 0 1 0 2.828l-7 7a2 2 0 0 1-2.828 0l-7-7A1.994 1.994 0 0 1 3 12V7a4 4 0 0 1 4-4z" />
                                </svg>
                                {{ $foundItem->category }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-body shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <path d="M16 2v4M8 2v4M3 10h18"/>
                                </svg>
                                {{ $foundItem->incident_date->translatedFormat('d F Y') }}
                            </span>

                        </div>

                        <h1 class="mt-3 text-3xl font-extrabold text-primary-dark leading-tight lg:text-4xl">
                            {{ $foundItem->item_name }}
                        </h1>

                    </div>

                    {{-- Divider --}}
                    <hr class="border-gray-100">

                    {{-- Description --}}
                    <div>
                        <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                            </svg>
                            Deskripsi Barang
                        </h2>
                        <p class="mt-3 text-sm leading-relaxed text-body">
                            {{ $foundItem->description }}
                        </p>
                    </div>

                    {{-- Location card --}}
                    <div class="rounded-2xl border border-blue-100 bg-soft-blue/20 p-5">
                        <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5h.01" />
                            </svg>
                            Lokasi Ditemukan
                        </h2>
                        <p class="mt-2 text-sm font-medium text-primary-dark">
                            {{ $foundItem->location }}
                        </p>
                    </div>

                    {{-- Reporter info card --}}
                    <div class="rounded-2xl border border-blue-100 bg-soft-blue/20 p-5">
                        <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c.8-3.333 3.133-5 7-5s6.2 1.667 7 5" />
                            </svg>
                            Informasi Pelapor
                        </h2>
                        <div class="mt-3 flex items-center gap-4">

                            {{-- Avatar --}}
                            @if ($foundItem->user && $foundItem->user->avatar_path)
                                <img src="{{ asset('storage/' . $foundItem->user->avatar_path) }}" class="object-cover w-12 h-12 border border-primary/20 rounded-full">
                            @else
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary/10 text-lg font-bold text-primary">
                                    {{ mb_strtoupper(mb_substr($foundItem->reporter_name, 0, 1)) }}
                                </div>
                            @endif

                            <div>
                                <p class="font-semibold text-primary-dark">{{ $foundItem->reporter_name }}</p>
                                <p class="mt-0.5 text-xs text-body">
                                    Dilaporkan pada {{ $foundItem->created_at->translatedFormat('d F Y') }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    @php
                        $isAvailable = in_array($foundItem->status, ['ditemukan']);
                    @endphp

                    {{-- Informasi pengeklaim (jika dikembalikan / selesai) --}}
                    @if (in_array($foundItem->status, ['dikembalikan', 'selesai']))
                        @php $acceptedClaim = $foundItem->acceptedClaim; @endphp
                        @if ($acceptedClaim && $acceptedClaim->user)
                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 space-y-3">
                                <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Informasi Pengeklaim
                                </h2>
                                <div class="flex items-center gap-3">
                                    @if ($acceptedClaim->user->avatar_path)
                                        <img src="{{ asset('storage/' . $acceptedClaim->user->avatar_path) }}" class="object-cover w-10 h-10 border border-emerald-200 rounded-full">
                                    @else
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-200 font-bold text-emerald-700">
                                            {{ mb_strtoupper(mb_substr($acceptedClaim->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-emerald-800">{{ $acceptedClaim->user->name }}</p>
                                        @if ($acceptedClaim->user->phone)
                                            <a href="tel:{{ $acceptedClaim->user->phone }}" class="text-xs text-emerald-600 hover:underline">{{ $acceptedClaim->user->phone }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm text-gray-500">Barang ini telah {{ $foundItem->status === 'selesai' ? 'selesai diproses' : 'dalam proses pengembalian' }}.</p>
                            </div>
                        @endif
                    @endif

                    <div class="flex flex-col gap-3 sm:flex-row">

                        {{-- Ajukan Klaim – hanya tampil jika masih tersedia --}}
                        @if ($isAvailable)
                            @auth
                                <button
                                    id="btn-ajukan-klaim"
                                    onclick="document.getElementById('modal-klaim').classList.remove('hidden')"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-hover active:scale-95 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                                    </svg>
                                    Ajukan Klaim
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                   id="btn-ajukan-klaim"
                                   class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-hover active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                                    </svg>
                                    Masuk untuk Klaim
                                </a>
                            @endauth
                        @endif

                        {{-- Hubungi Pelapor --}}
                        @if ($foundItem->phone)
                            <a href="tel:{{ $foundItem->phone }}"
                               id="btn-hubungi-pelapor"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border-2 border-primary bg-white px-6 py-3.5 text-sm font-bold text-primary shadow-sm transition hover:bg-soft-blue/30 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $foundItem->phone }}
                            </a>
                        @else
                            <span
                               id="btn-hubungi-pelapor"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-6 py-3.5 text-sm font-bold text-gray-400 shadow-sm cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Kontak Tidak Tersedia
                            </span>
                        @endif

                    </div>

                    {{-- Mobile back button --}}
                    <a href="{{ route('found-items.index') }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-body transition hover:text-primary lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7" />
                        </svg>
                        Kembali ke Daftar
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- ================================================
         MODAL: Ajukan Klaim
    ================================================ --}}
    @auth
    <div id="modal-klaim"
         class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         onclick="if(event.target===this) this.classList.add('hidden')">

        <div class="relative w-full max-w-lg rounded-3xl bg-white shadow-2xl overflow-y-auto max-h-[90vh] animate-fade-in-down">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-primary to-primary-hover px-8 py-6 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold">Ajukan Klaim</h2>
                        <p class="mt-1 text-sm text-white/80">{{ $foundItem->item_name }}</p>
                    </div>
                    <button onclick="document.getElementById('modal-klaim').classList.add('hidden')"
                            class="ml-4 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20 hover:bg-white/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <form method="POST" action="{{ route('claims.store', $foundItem) }}" class="px-8 py-7" enctype="multipart/form-data">
                @csrf

                {{-- Info barang ringkas --}}
                <div class="mb-6 flex items-center gap-4 rounded-2xl border border-blue-100 bg-soft-blue/20 px-5 py-4">
                    @if ($foundItem->photo_path)
                        <img src="{{ Str::startsWith($foundItem->photo_path, 'http') ? $foundItem->photo_path : Storage::url($foundItem->photo_path) }}"
                             alt="{{ $foundItem->item_name }}"
                             class="h-14 w-14 rounded-xl object-cover shrink-0">
                    @else
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-primary/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2 1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-8h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <p class="font-bold text-primary-dark text-sm">{{ $foundItem->item_name }}</p>
                        <p class="text-xs text-body mt-0.5">{{ $foundItem->location }}</p>
                        <span class="mt-1 inline-block rounded-full bg-soft-blue/70 px-2.5 py-0.5 text-[10px] font-semibold text-primary">{{ $foundItem->category }}</span>
                    </div>
                </div>

                {{-- Textarea pesan --}}
                <div class="mb-5">
                    <label for="claim-message" class="mb-2 block text-sm font-bold text-primary-dark">
                        Bukti Kepemilikan
                        <span class="text-red-500">*</span>
                    </label>
                    <p class="mb-3 text-xs text-body">Jelaskan mengapa barang ini milik kamu – ciri khas, isi tas, nomor seri, atau bukti lain yang dapat memverifikasi kepemilikanmu.</p>
                    <textarea
                        id="claim-message"
                        name="message"
                        rows="5"
                        maxlength="1000"
                        placeholder="Contoh: Kacamata saya memiliki frame hitam tipis dengan lensa anti-gores, bagian dalam frame tertulis 'RX -2.00'. Saya juga memiliki struk pembelian dari Optik Sari Dewata..."
                        class="w-full resize-none rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-primary-dark placeholder:text-gray-300 focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 transition"
                        oninput="document.getElementById('char-count').textContent=this.value.length"
                        >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1.5 text-right text-xs text-body">
                        <span id="char-count">{{ strlen(old('message', '')) }}</span>/1000
                    </p>
                </div>

                {{-- Upload foto bukti --}}
                <div class="mb-5">
                    <label for="claim-photo" class="mb-2 block text-sm font-bold text-primary-dark">
                        Foto Bukti
                        <span class="ml-1 text-xs font-normal text-body">(opsional, maks. 5 MB)</span>
                    </label>
                    <p class="mb-3 text-xs text-body">Lampirkan foto yang dapat membuktikan kepemilikanmu, misalnya foto struk pembelian, foto barang sebelumnya, atau foto selfie dengan barang tersebut.</p>
                    <label for="claim-photo"
                           class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-4 py-5 text-center transition hover:border-primary/50 hover:bg-soft-blue/10"
                           id="claim-photo-label">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="claim-photo-text" class="text-xs text-body">Klik untuk memilih foto</span>
                        <span class="text-[10px] text-gray-400">JPG, PNG, WebP • Maks. 5 MB</span>
                    </label>
                    <input type="file"
                           id="claim-photo"
                           name="photo"
                           accept="image/jpeg,image/png,image/webp"
                           class="hidden"
                           onchange="
                               const f = this.files[0];
                               document.getElementById('claim-photo-text').textContent = f ? f.name : 'Klik untuk memilih foto';
                               const label = document.getElementById('claim-photo-label');
                               label.classList.toggle('border-primary', !!f);
                               label.classList.toggle('bg-soft-blue/20', !!f);
                           ">
                    @error('photo')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Note --}}
                <div class="mb-6 flex items-start gap-2.5 rounded-xl bg-amber-50 border border-amber-200 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                    <p class="text-xs text-amber-700 leading-relaxed">Klaim akan ditinjau oleh admin. Pastikan informasimu akurat – klaim palsu dapat dikenakan sanksi.</p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3">
                    <button type="button"
                            onclick="document.getElementById('modal-klaim').classList.add('hidden')"
                            class="flex-1 rounded-xl border-2 border-gray-200 bg-white px-5 py-3 text-sm font-bold text-body transition hover:border-gray-300 hover:bg-gray-50 active:scale-95">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-hover active:scale-95">
                        Kirim Klaim
                    </button>
                </div>

            </form>
        </div>
    </div>
    @endauth

    {{-- Auto-buka modal klaim jika ada validation error --}}
    @if ($errors->has('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('modal-klaim');
            if (modal) modal.classList.remove('hidden');
        });
    </script>
    @endif

@endsection
