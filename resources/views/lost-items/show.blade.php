@extends('layouts.landing')

@section('title', $lostItem->item_name . ' – Barang Hilang – Udayana Lost & Found')

@section('content')

    <section class="relative overflow-hidden bg-background py-10 lg:py-14">

        {{-- Decorative blobs --}}
        <div class="pointer-events-none absolute -top-20 right-20 h-80 w-80 rounded-full bg-soft-blue/30 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-10 left-10 h-60 w-60 rounded-full bg-red-100/15 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-6">

            {{-- ================================================
                 BREADCRUMB
            ================================================ --}}
            <nav class="mb-8 flex items-center gap-2 text-sm text-body">
                <a href="{{ route('home') }}" class="hover:text-primary transition">Beranda</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                </svg>
                <a href="{{ route('lost-items.index') }}" class="hover:text-primary transition">Barang Hilang</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                </svg>
                <span class="font-medium text-primary-dark line-clamp-1 max-w-[200px]">{{ $lostItem->item_name }}</span>
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

                        @if ($lostItem->photo_path)
                            <img
                                src="{{ Str::startsWith($lostItem->photo_path, 'http') ? $lostItem->photo_path : Storage::url($lostItem->photo_path) }}"
                                alt="{{ $lostItem->item_name }}"
                                class="aspect-[4/3] w-full object-cover"
                            >
                        @else
                            <div class="flex aspect-[4/3] w-full items-center justify-center bg-soft-blue/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2 1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-8h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                                </svg>
                            </div>
                        @endif

                        {{-- DICARI badge overlay --}}
                        <div class="absolute left-4 top-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500 px-4 py-1.5 text-sm font-bold uppercase tracking-wide text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 6.15 6.15a7.5 7.5 0 0 0 10.5 10.5Z" />
                                </svg>
                                Dicari
                            </span>
                        </div>

                    </div>

                    {{-- Back button below image on desktop --}}
                    <a href="{{ route('lost-items.index') }}"
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
                                {{ $lostItem->category }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-body shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <path d="M16 2v4M8 2v4M3 10h18"/>
                                </svg>
                                {{ $lostItem->incident_date->translatedFormat('d F Y') }}
                            </span>

                        </div>

                        <h1 class="mt-3 text-3xl font-extrabold text-primary-dark leading-tight lg:text-4xl">
                            {{ $lostItem->item_name }}
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
                            {{ $lostItem->description }}
                        </p>
                    </div>

                    {{-- Location card --}}
                    <div class="rounded-2xl border border-blue-100 bg-soft-blue/20 p-5">
                        <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5h.01" />
                            </svg>
                            Lokasi Kehilangan
                        </h2>
                        <p class="mt-2 text-sm font-medium text-primary-dark">
                            {{ $lostItem->location }}
                        </p>
                    </div>

                    {{-- Reporter info card --}}
                    <div class="rounded-2xl border border-blue-100 bg-soft-blue/20 p-5">
                        <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c.8-3.333 3.133-5 7-5s6.2 1.667 7 5" />
                            </svg>
                            Informasi Pemilik
                        </h2>
                        <div class="mt-3 flex items-center gap-4">

                            {{-- Avatar --}}
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary/10 text-lg font-bold text-primary">
                                {{ mb_strtoupper(mb_substr($lostItem->reporter_name, 0, 1)) }}
                            </div>

                            <div>
                                <p class="font-semibold text-primary-dark">{{ $lostItem->reporter_name }}</p>
                                <p class="mt-0.5 text-xs text-body">
                                    Dilaporkan pada {{ $lostItem->created_at->translatedFormat('d F Y') }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        {{-- Ajukan Klaim --}}
                        <a href="{{ route('found-items.create', ['lost_item_id' => $lostItem->id]) }}"
                           id="btn-saya-menemukan"
                           class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-hover active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Saya Menemukan Barang Ini
                        </a>

                        {{-- Hubungi Pelapor --}}
                        <a href="tel:{{ $lostItem->phone }}"
                           id="btn-hubungi-pemilik"
                           class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border-2 border-primary bg-white px-6 py-3.5 text-sm font-bold text-primary shadow-sm transition hover:bg-soft-blue/30 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Hubungi Pemilik
                        </a>

                    </div>

                    {{-- Mobile back button --}}
                    <a href="{{ route('lost-items.index') }}"
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

@endsection
