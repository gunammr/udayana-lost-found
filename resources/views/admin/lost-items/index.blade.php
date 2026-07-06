@extends('layouts.admin')

@section('title', 'Kelola Barang Hilang')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-gray-800">
        Kelola Barang Hilang
    </h1>

    <p class="text-gray-500 mt-2">
        {{ $lostItems->total() }} laporan barang hilang terdaftar
    </p>


</div>

@if(session('success'))

<div class="mb-6 rounded-xl bg-green-100 border border-green-300 text-green-700 px-5 py-4">

    {{ session('success') }}

</div>

@endif

<div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
    
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">

        {{-- Header --}}
        <thead class="bg-gray-50">

            <tr class="text-gray-500 uppercase text-xs tracking-wider">

                <th class="px-8 py-5 text-left">ID Item</th>
                <th class="px-8 py-5 text-left">Detail Barang</th>
                <th class="px-6 py-5 text-left">Kategori</th>
                <th class="px-6 py-5 text-left">Lokasi</th>
                <th class="px-6 py-5 text-left">Tanggal</th>
                <th class="px-6 py-5 text-left">Pelapor</th>
                <th class="px-6 py-5 text-center">Status</th>
                <th class="px-6 py-5 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

        @forelse($lostItems as $item)

            <tr class="border-t hover:bg-blue-50 transition duration-200">

                {{-- ID --}}
                <td class="px-8 py-6 text-gray-500 font-medium">

                    #ITM-{{ str_pad($item->id,3,'0',STR_PAD_LEFT) }}

                </td>

                {{-- Detail --}}
                <td class="px-8 py-6">

                        <div
                            class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shadow-sm">

                            @if($item->photo_path)

                            <img
                            src="{{ $item->photo_path }}"
                            class="w-full h-full object-cover">

                            @else

                            <div class="w-full h-full flex items-center justify-center">

                                <img
                                src="{{ asset('images/icons/image.svg') }}"
                                class="w-6">

                            </div>

                            @endif

                        </div>

                    <div>

                        <p class="font-semibold text-gray-800">

                        {{ $item->item_name }}

                            </p>

                            <p class="text-sm text-gray-500">

                                {{ Str::limit($item->description,45) }}

                        </p>

                    </div>

                </td>

                {{-- Kategori --}}
                <td class="px-6 py-6">

                    <span class="inline-flex px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">

                        {{ $item->category }}

                    </span>

                </td>

                {{-- Lokasi --}}
                <td class="px-6 py-6 text-gray-700">

                    {{ $item->location }}

                </td>

                {{-- Tanggal --}}
                <td class="px-6 py-6 text-gray-700">

                    {{ \Carbon\Carbon::parse($item->incident_date)->format('d M Y') }}

                </td>

                {{-- Pelapor --}}
                <td class="px-6 py-6 text-gray-700">

                    {{ $item->reporter_name }}

                </td>

                {{-- Status --}}
                <td class="px-6 py-6 text-center">

                    @if($item->status == 'dicari')

                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-600 font-semibold text-sm">

                            Dicari

                        </span>

                    @elseif($item->status == 'ditemukan')

                        <span class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold text-sm">

                            Ditemukan

                        </span>

                    @elseif($item->status == 'selesai')

                        <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold text-sm">

                            Diklaim

                        </span>

                    @else

                        <span class="inline-flex px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-semibold text-sm">

                            {{ ucfirst($item->status) }}

                        </span>

                    @endif

                </td>

                {{-- Aksi --}}
                <td class="px-6 py-6">

                    <div class="flex justify-center gap-3">

                        <a href="{{ route('admin.lost-items.edit', $item->id) }}"
                           class="w-10 h-10 rounded-xl bg-blue-50 hover:bg-blue-100 flex items-center justify-center">

                            <img
                                src="{{ asset('images/icons/edit.svg') }}"
                                class="w-5">

                        </a>

                        <form
                            action="{{ route('admin.lost-items.destroy', $item) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-10 h-10 rounded-xl bg-red-50 hover:bg-red-100 transition flex items-center justify-center">

                                <img
                                    src="{{ asset('images/icons/delete.svg') }}"
                                    class="w-5">

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8" class="py-20 text-center text-gray-400">

                    Belum ada data.

                </td>

            </tr>

        @endforelse

        </tbody>
        </table>
    </div>

    <div class="px-8 py-5 border-t bg-gray-50">

        {{ $lostItems->links() }}

    </div>

</div>

@endsection