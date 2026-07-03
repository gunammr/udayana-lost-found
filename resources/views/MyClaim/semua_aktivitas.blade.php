@extends('layouts.app')

@section('content')
<div class="px-8 py-12 mx-auto max-w-7xl">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <div class="lg:col-span-1">
            @include('profile.partials.profile_card')
        </div>

        <div class="lg:col-span-3">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Activity History</h1>

            <div class="flex gap-6 mb-8 text-sm font-medium border-b border-gray-200">
                <a href="{{ route('claims.index') }}"
                    class="{{ request()->routeIs('claims.index') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    All Activities
                </a>
                <a href="{{ route('claims.laporan') }}"
                    class="{{ request()->routeIs('claims.laporan') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    Loss Reports
                </a>
                <a href="{{ route('claims.status') }}"
                    class="{{ request()->routeIs('claims.status') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-3' : 'text-gray-500 pb-3' }}">
                    Claim Status
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($items as $item)
                    @php
                        $status = $item->status ?? 'dicari';
                        $statusStyle = match($status) {
                            'dicari' => 'bg-red-100 text-red-800',
                            'ditemukan' => 'bg-blue-100 text-blue-800',
                            'selesai' => 'bg-green-100 text-green-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                        
                        $statusLabel = match($status) {
                            'dicari' => 'Wanted',
                            'ditemukan' => 'Found',
                            'selesai' => 'Finished',
                            default => ucfirst($status),
                        };
                    @endphp

                    <div x-data="{ openDetail: false }" class="w-full">
                        
                        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden flex flex-col justify-between hover:shadow-md transition cursor-pointer h-full" 
                             @click="openDetail = true">
                            
                            <div class="relative h-48 bg-gray-50 flex items-center justify-center overflow-hidden">
                                @if (isset($item->photo_path) && $item->photo_path)
                                    <img src="{{ Str::startsWith($item->photo_path, ['http://', 'https://']) ? $item->photo_path : asset('storage/' . $item->photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center p-6 text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full {{ $statusStyle }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-800 mb-2">{{ $item->item_name }}</h4>
                                    <p class="text-sm text-gray-500 line-clamp-3">{{ Str::limit($item->description, 90) }}</p>
                                </div>
                                <div class="flex items-center justify-between pt-4 mt-4 text-xs text-gray-400 border-t border-gray-100">
                                    <span>📅 {{ is_string($item->incident_date) ? date('d M Y', strtotime($item->incident_date)) : $item->incident_date->format('d M Y') }}</span>
                                    <button class="font-bold text-blue-600 hover:underline">Details →</button>
                                </div>
                            </div>
                        </div>

                        <div x-show="openDetail" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
                            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative text-left" @click.outside="openDetail = false">
                                
                                <button @click="openDetail = false" class="absolute top-4 left-4 bg-white/80 hover:bg-white p-2 rounded-full shadow-md z-10 transition">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                <div class="h-64 w-full relative bg-gray-100">
                                    <img src="{{ Str::startsWith($item->photo_path, ['http://', 'https://']) ? $item->photo_path : asset('storage/' . $item->photo_path) }}" class="w-full h-full object-cover">
                                    <span class="absolute top-4 right-4 {{ $statusStyle }} px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <div class="p-8">
                                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                                        {{ $item->status == 'selesai' ? 'Klaim:' : 'Laporan:' }} {{ $item->item_name }}
                                    </h2>
                                    <p class="text-gray-500 text-sm mb-6">{{ $item->description }}</p>

                                    <div class="grid grid-cols-2 gap-y-6 gap-x-4 bg-gray-50 p-6 rounded-2xl mb-6">
                                        <div>
                                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Kategori</p>
                                            <p class="text-sm font-bold text-gray-700">Elektronik</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Tanggal</p>
                                            <p class="text-sm font-bold text-gray-700">{{ is_string($item->incident_date) ? date('d M Y', strtotime($item->incident_date)) : $item->incident_date->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Jenis</p>
                                            <p class="text-sm font-bold text-gray-700">{{ $item->status == 'selesai' ? 'Klaim Barang' : 'Laporan Barang Hilang' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">ID Barang</p>
                                            <p class="text-sm font-bold text-gray-700">#{{ $item->id }}</p>
                                        </div>
                                    </div>

                                    <h3 class="font-bold text-gray-800 mb-4 text-sm">Riwayat Status</h3>
                                    <div class="space-y-6 relative before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100">
                                        <div class="relative pl-8">
                                            <div class="absolute left-0 top-1 w-4 h-4 bg-blue-600 rounded-full border-4 border-white shadow-sm"></div>
                                            <p class="text-sm font-bold text-gray-800">{{ $item->status == 'selesai' ? 'Klaim Diajukan' : 'Laporan Diajukan' }}</p>
                                            <p class="text-xs text-gray-400">Sistem berhasil mencatat riwayat aktivitas Anda</p>
                                        </div>
                                        <div class="relative pl-8">
                                            <div class="absolute left-0 top-1 w-4 h-4 {{ $item->status != 'dicari' ? 'bg-blue-600' : 'bg-gray-200' }} rounded-full border-4 border-white shadow-sm"></div>
                                            <p class="text-sm font-bold {{ $item->status != 'dicari' ? 'text-gray-800' : 'text-gray-300' }}">Sedang Diverifikasi / Proses</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-2xl border border-gray-100">
                        <p class="text-sm text-gray-400">No activities found.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</div>
@endsection