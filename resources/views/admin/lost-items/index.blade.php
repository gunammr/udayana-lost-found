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

        @forelse($lostItems as $item)

            <tr class="border-t hover:bg-blue-50 transition duration-200" x-data="{
                    status: '{{ $item->status }}',
                    showFoundModal: false,
                    updateStatus(newStatus) {
                        if (newStatus === 'ditemukan') {
                            this.showFoundModal = true;
                            this.status = '{{ $item->status }}'; // revert visual state
                        } else {
                            this.$refs.statusForm.submit();
                        }
                    }
                }">
                {{-- ID --}}
                <td class="px-4 py-3 text-gray-500 font-medium text-sm">

                    #ITM-{{ str_pad($item->id,3,'0',STR_PAD_LEFT) }}

                </td>

                {{-- Detail --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 shadow-sm flex-shrink-0">

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

                    <form x-ref="statusForm" action="{{ route('admin.lost-items.status', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" x-model="status" @change="updateStatus($event.target.value)"
                            class="px-2 py-1 rounded-lg border-gray-200 text-xs font-semibold focus:ring-primary focus:border-primary cursor-pointer outline-none shadow-sm"
                            :class="{
                                'bg-red-50 text-red-700': status === 'hilang',
                                'bg-yellow-50 text-yellow-700': status === 'dicari',
                                'bg-blue-50 text-blue-700': status === 'ditemukan',
                                'bg-green-50 text-green-700': status === 'selesai'
                            }">
                            <option value="hilang">Hilang</option>
                            <option value="dicari">Dicari</option>
                            <option value="ditemukan">Ditemukan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </form>

                    {{-- Found Modal --}}
                    <div x-show="showFoundModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            
                            <div x-show="showFoundModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50 backdrop-blur-sm" aria-hidden="true" @click="showFoundModal = false"></div>
                            
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div x-show="showFoundModal" x-transition class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 text-gray-800">
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-4 text-left">Laporkan Penemuan Barang</h3>
                                
                                <form action="{{ route('admin.lost-items.mark-found', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-left">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Nama Barang Ditemukan</label>
                                        <input type="text" name="item_name" value="{{ $item->item_name }}" required class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Kategori</label>
                                        <input type="text" name="category" value="{{ $item->category }}" required class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Lokasi Ditemukan</label>
                                        <input type="text" name="location" required class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Tanggal Ditemukan</label>
                                        <input type="date" name="incident_date" required class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Deskripsi Tambahan</label>
                                        <textarea name="description" required rows="2" class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2"></textarea>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold mb-1">Nama Penemu</label>
                                            <input type="text" name="reporter_name" required class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold mb-1">No. HP (WA)</label>
                                            <input type="text" name="phone" required class="w-full rounded-lg border-gray-200 text-sm focus:ring-primary focus:border-primary bg-gray-50 px-3 py-2">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Foto Barang (Opsional)</label>
                                        <input type="file" name="photo" accept="image/*" class="w-full text-sm rounded-lg border border-gray-200 px-3 py-2 bg-gray-50 focus:ring-primary focus:border-primary">
                                    </div>
                                    
                                    <div class="mt-6 sm:flex sm:flex-row-reverse gap-2">
                                        <button type="submit" class="inline-flex justify-center w-full px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 sm:w-auto">
                                            Simpan & Tandai
                                        </button>
                                        <button type="button" @click="showFoundModal = false" class="inline-flex justify-center w-full px-5 py-2.5 mt-3 text-sm font-bold text-gray-700 bg-gray-100 rounded-lg shadow-sm hover:bg-gray-200 sm:mt-0 sm:w-auto">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </td>

                {{-- Aksi --}}
                <td class="px-4 py-3">

                    <div class="flex justify-center gap-2">

                        <a href="{{ route('admin.lost-items.edit', $item->id) }}"
                           class="w-8 h-8 rounded bg-blue-50 hover:bg-blue-100 flex items-center justify-center">

                            <img
                                src="{{ asset('images/icons/edit.svg') }}"
                                class="w-4">

                        </a>

                        <form
                            action="{{ route('admin.lost-items.destroy', $item) }}"
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

        {{ $lostItems->links() }}

    </div>

</div>

@endsection