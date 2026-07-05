@extends('layouts.landing')

@section('title', 'Barang Hilang – Udayana Lost & Found')

@section('content')

    {{-- =========================================================
         HERO SECTION
    ========================================================= --}}
    <section class="relative overflow-hidden bg-background py-16 lg:py-20">

        {{-- Decorative blobs --}}
        <div class="pointer-events-none absolute -top-20 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-soft-blue/40 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 right-10 h-64 w-64 rounded-full bg-red-100/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-6">

            {{-- Heading --}}
            <div class="text-center">

                <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-soft-blue/60 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 6.15 6.15a7.5 7.5 0 0 0 10.5 10.5Z" />
                    </svg>
                    Bantu Mencari
                </span>

                <h1 class="mt-4 text-4xl font-extrabold text-primary-dark lg:text-5xl">
                    Barang Hilang
                </h1>

                <p class="mx-auto mt-4 max-w-xl text-base text-body">
                    Daftar barang yang dilaporkan hilang di lingkungan Universitas Udayana.
                    Bantu sesama dengan melihat daftar ini.
                </p>

            </div>

            {{-- =========================================================
                 SEARCH & FILTER BAR
            ========================================================= --}}
            <div class="mt-10">
                <form method="GET" action="{{ route('lost-items.index') }}"
                      class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">

                    {{-- Search input --}}
                    <div class="relative flex-1">
                        <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0Z" />
                            </svg>
                        </span>
                        <input
                            id="search-input"
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari nama barang, lokasi…"
                            class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-primary-dark shadow-sm placeholder:text-gray-400 focus:border-primary focus:ring-primary"
                        >
                    </div>

                    {{-- Category filter --}}
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Semua', ...$categories] as $cat)
                            <button
                                type="submit"
                                name="category"
                                value="{{ $cat }}"
                                id="filter-{{ Str::slug($cat) }}"
                                class="rounded-full border px-4 py-2 text-xs font-semibold transition
                                    {{ $activeCategory === $cat
                                        ? 'border-primary bg-primary text-white shadow-md shadow-primary/20'
                                        : 'border-gray-200 bg-white text-body hover:border-primary hover:text-primary' }}">
                                {{ $cat }}
                            </button>
                        @endforeach
                    </div>

                </form>
            </div>

        </div>

    </section>

    {{-- =========================================================
         ITEMS GRID
    ========================================================= --}}
    <section class="relative pb-24">

        <div class="mx-auto max-w-7xl px-6">

            {{-- Result count --}}
            <p class="mb-6 text-sm text-body">
                Menampilkan
                <span class="font-semibold text-primary-dark">{{ $lostItems->total() }}</span>
                barang hilang
                @if($search)
                    untuk pencarian "<span class="font-semibold text-primary-dark">{{ $search }}</span>"
                @endif
                @if($activeCategory !== 'Semua')
                    dalam kategori "<span class="font-semibold text-primary-dark">{{ $activeCategory }}</span>"
                @endif
            </p>

            @if($lostItems->isEmpty())

                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-soft-blue/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0Z" />
                        </svg>
                    </div>
                    <h2 class="mt-5 text-lg font-bold text-primary-dark">Tidak Ada Barang Hilang</h2>
                    <p class="mt-2 text-sm text-body">Coba ubah kata kunci atau filter kategori Anda.</p>
                    <a href="{{ route('lost-items.index') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-primary-hover">
                        Reset Filter
                    </a>
                </div>

            @else

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                    @foreach ($lostItems as $item)
                        <a href="{{ route('lost-items.show', $item) }}"
                           id="lost-item-{{ $item->id }}"
                           class="group relative flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-card transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                            {{-- Photo --}}
                            <div class="relative h-48 w-full overflow-hidden bg-soft-blue/30">

                                @if ($item->photo_path)
                                    <img
                                        src="{{ Str::startsWith($item->photo_path, 'http') ? $item->photo_path : Storage::url($item->photo_path) }}"
                                        alt="{{ $item->item_name }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2 1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-8h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Status badge --}}
                                <span class="absolute left-3 top-3 rounded-full bg-red-500 px-3 py-1 text-xs font-bold uppercase tracking-wide text-white shadow">
                                    Dicari
                                </span>

                            </div>

                            {{-- Card body --}}
                            <div class="flex flex-1 flex-col p-5">

                                {{-- Category + Date --}}
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-soft-blue/70 px-2.5 py-0.5 text-[11px] font-semibold text-primary">
                                        {{ $item->category }}
                                    </span>
                                    <span class="flex items-center gap-1 text-[11px] text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" />
                                        </svg>
                                        {{ $item->incident_date->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                {{-- Name --}}
                                <h2 class="mt-3 text-base font-bold text-primary-dark line-clamp-2 leading-snug group-hover:text-primary transition">
                                    {{ $item->item_name }}
                                </h2>

                                {{-- Location --}}
                                <p class="mt-2 flex items-start gap-1.5 text-xs text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-primary/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5h.01" />
                                    </svg>
                                    <span class="line-clamp-2">{{ $item->location }}</span>
                                </p>

                                {{-- CTA --}}
                                <div class="mt-auto pt-4">
                                    <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition group-hover:gap-2.5">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                                        </svg>
                                    </span>
                                </div>

                            </div>

                        </a>
                    @endforeach

                </div>

                {{-- Pagination --}}
                @if ($lostItems->hasPages())
                    <div class="mt-12">
                        {{ $lostItems->links() }}
                    </div>
                @endif

            @endif

        </div>

    </section>

@endsection
