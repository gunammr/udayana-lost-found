@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Card Statistik --}}
<div class="grid grid-cols-4 gap-6">

    @include('components.stat-card', [
        'title' => 'Barang Hilang',
        'value' => $totalLostItems,
        'description' => '+12 minggu ini',
        'icon' => 'images/icons/hilang.svg'
    ])

    @include('components.stat-card', [
        'title' => 'Barang Ditemukan',
        'value' => $totalFoundItems,
        'description' => '+5 minggu ini',
        'icon' => 'images/icons/ketemu.svg'
    ])

    @include('components.stat-card', [
        'title' => 'Klaim Berhasil',
        'value' => $totalClaims,
        'description' => '+8 minggu ini',
        'icon' => 'images/icons/klaim.svg'
    ])

    @include('components.stat-card', [
        'title' => 'Total User',
        'value' => $totalUsers,
        'description' => 'Pengguna Terdaftar',
        'icon' => 'images/icons/user.svg'
    ])

</div>

{{-- Content bawah --}}
<div class="grid grid-cols-3 gap-6 mt-8">

    <div class="col-span-2 space-y-6">

        @include('components.report-lost-table')

        @include('components.report-found-table')

    </div>

    <div>

        @include('components.pending-claim')

    </div>

</div>

@endsection