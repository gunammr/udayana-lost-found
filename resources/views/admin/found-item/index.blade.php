@extends('layouts.admin')

@section('title', 'Kelola Barang Ditemukan')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-gray-800">
        Kelola Barang Ditemukan
    </h1>

    <p class="text-gray-500 mt-2">
        {{ $foundItems->total() }} laporan barang ditemukan terdaftar
    </p>

</div>

<div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
    
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">

        <thead class="bg-gray-50">

            <tr class="text-gray-500 uppercase text-xs tracking-wider bg-gray-50">

                <th class="px-4 py-3 text-left">ID Item</th>
                <th class="px-4 py-3 text-left">Detail Barang</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Lokasi</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-left">Pelapor</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

        @forelse($foundItems as $item)

            <tr class="border-t hover:bg-blue-50 transition duration-200" x-data="{
                    status: '{{ $item->status }}'
                }">

                {{-- ID --}}
                <td class="px-4 py-3 text-gray-500 font-medium text-sm">

                    #FND-{{ str_pad($item->id,3,'0',STR_PAD_LEFT) }}

                </td>

                {{-- Detail Barang --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 shadow-sm flex-shrink-0">

                            @if($item->photo_path)

                                <img
                                    src="{{ Str::startsWith($item->photo_path, ['http://', 'https://']) ? $item->photo_path : asset('storage/' . $item->photo_path) }}"
                                    class="w-full h-full object-cover">

                            @else

                                <div class="w-full h-full flex items-center justify-center">
                                    <img
                                        src="{{ asset('images/icons/image.svg') }}"
                                        class="w-5">
                                </div>

                            @endif

                        </div>

                        <div>
                            <p class="font-semibold text-gray-800 text-sm">
                                {{ $item->item_name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ Str::limit($item->description, 35) }}
                            </p>
                        </div>
                    </div>
                </td>

                {{-- Kategori --}}
                <td class="px-4 py-3">
                    <span class="inline-flex px-2 py-1 rounded border bg-gray-50 text-gray-600 text-[10px] font-semibold tracking-wide">
                        {{ $item->category }}
                    </span>
                </td>

                {{-- Lokasi --}}
                <td class="px-4 py-3 text-gray-700 text-sm">
                    <div class="truncate max-w-[150px]" title="{{ $item->location }}">{{ $item->location }}</div>
                </td>

                {{-- Tanggal --}}
                <td class="px-4 py-3 text-gray-700 text-sm whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($item->incident_date)->format('d M Y') }}
                </td>

                {{-- Pelapor --}}
                <td class="px-4 py-3 text-gray-700 text-sm">
                    {{ $item->reporter_name }}
                </td>

                {{-- Status --}}
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.found-items.status', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" x-model="status" @change="$el.form.submit()"
                            class="px-2 py-1 rounded-lg border-gray-200 text-xs font-semibold focus:ring-primary focus:border-primary cursor-pointer outline-none shadow-sm"
                            :class="{
                                'bg-red-50 text-red-700': status === 'ditemukan',
                                'bg-yellow-50 text-yellow-700': status === 'diklaim',
                                'bg-blue-50 text-blue-700': status === 'dikembalikan',
                                'bg-green-50 text-green-700': status === 'selesai'
                            }">
                            <option value="ditemukan">Ditemukan</option>
                            <option value="diklaim">Diklaim</option>
                            <option value="dikembalikan">Dikembalikan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </form>
                </td>

                {{-- Aksi --}}
                <td class="px-4 py-3">

                    <div class="flex justify-center gap-2">

                        <a
                            href="{{ route('admin.found-items.edit', $item) }}"
                            class="w-8 h-8 rounded bg-blue-50 hover:bg-blue-100 flex items-center justify-center">

                            <img
                                src="{{ asset('images/icons/edit.svg') }}"
                                class="w-4">

                        </a>

                        <form
                            action="{{ route('admin.found-items.destroy', $item) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-8 h-8 rounded bg-red-50 hover:bg-red-100 transition flex items-center justify-center">

                                <img
                                    src="{{ asset('images/icons/delete.svg') }}"
                                    class="w-4">

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

        {{ $foundItems->links() }}

    </div>

</div>

@endsection