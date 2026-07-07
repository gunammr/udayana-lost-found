@extends('layouts.admin')

@section('title', $category->category)

@section('content')

<div class="mb-8">

    <a
        href="{{ route('admin.categories.index') }}"
        class="text-blue-600">

        ← Kembali

    </a>

    <h1 class="mt-3 text-4xl font-bold">

        {{ $category->category }}

    </h1>

    <p class="text-gray-500">

        Total:
        {{ $foundItems->count() + $lostItems->count() }}
        barang

    </p>

</div>

<h2 class="mb-4 text-2xl font-bold">

    Barang Ditemukan

</h2>

<div class="space-y-4">

@forelse($foundItems as $item)

<div class="rounded-xl bg-white p-5 shadow">

    <h3 class="font-bold">

        {{ $item->item_name }}

    </h3>

    <p class="text-gray-500">

        {{ $item->location }}

    </p>

    <span
        class="mt-3 inline-block rounded-full bg-green-100 px-3 py-1 text-green-700">

        Ditemukan

    </span>

</div>

@empty

<p class="text-gray-400">

    Tidak ada barang ditemukan.

</p>

@endforelse

</div>

<h2 class="mt-10 mb-4 text-2xl font-bold">

    Barang Hilang

</h2>

<div class="space-y-4">

@forelse($lostItems as $item)

<div class="rounded-xl bg-white p-5 shadow">

    <h3 class="font-bold">

        {{ $item->item_name }}

    </h3>

    <p class="text-gray-500">

        {{ $item->location }}

    </p>

    <span
        class="mt-3 inline-block rounded-full bg-red-100 px-3 py-1 text-red-700">

        Hilang

    </span>

</div>

@empty

<p class="text-gray-400">

    Tidak ada barang hilang.

</p>

@endforelse

</div>

@endsection
