@extends('layouts.admin')

@section('title','Kelola Kategori')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-4xl font-bold text-gray-800">
            Kelola Kategori
        </h1>

        <p class="text-gray-500 mt-2">
            Atur kategori barang hilang dan ditemukan
        </p>

    </div>

    <button
        class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-xl font-semibold shadow">

        + Tambah Kategori

    </button>

</div>

<div class="grid grid-cols-4 gap-6">

@foreach($categories as $category)

<div
class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition p-6">

    <div
    class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center text-3xl mb-5">

        {{ $category['icon'] }}

    </div>

    <h3 class="font-bold text-xl text-gray-800">

        {{ $category['name'] }}

    </h3>

    <p class="text-gray-500 mt-2 text-sm">

        {{ $category['description'] }}

    </p>

    <div class="flex justify-between items-center mt-6">

        <span class="text-gray-400">

            {{ $category['count'] }} barang

        </span>

        <span class="text-xl text-gray-400">

            →

        </span>

    </div>

</div>

@endforeach

</div>

@endsection