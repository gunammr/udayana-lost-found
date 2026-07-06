@extends('layouts.admin')

@section('title', 'Edit Barang Ditemukan')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-gray-800">
        Edit Barang Ditemukan
    </h1>

    <p class="text-gray-500 mt-2">
        Perbarui data barang ditemukan.
    </p>

</div>

<div class="bg-white rounded-2xl shadow-md p-8">

@if ($errors->any())

    <div class="mb-6 rounded-xl bg-red-100 border border-red-300 p-4">

        <h4 class="font-semibold text-red-700 mb-2">
            Terjadi kesalahan:
        </h4>

        <ul class="list-disc list-inside text-red-600">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form action="{{ route('admin.found-items.update', $foundItem) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- Nama Barang --}}
    <div class="mb-6">

        <label class="block mb-2 font-semibold">
            Nama Barang
        </label>

        <input
            type="text"
            name="item_name"
            value="{{ old('item_name', $foundItem->item_name) }}"
            class="w-full rounded-xl border-gray-300">

    </div>

    {{-- Kategori & Tanggal --}}
    <div class="grid grid-cols-2 gap-6">

        <div>

            <label class="block mb-2 font-semibold">
                Kategori
            </label>

            <select
                name="category"
                class="w-full rounded-xl border-gray-300">

                @foreach($categories as $category)

                    <option
                        value="{{ $category }}"
                        {{ old('category', $foundItem->category) == $category ? 'selected' : '' }}>

                        {{ $category }}

                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="block mb-2 font-semibold">
                Tanggal Ditemukan
            </label>

            <input
                type="date"
                name="found_date"
                value="{{ old('found_date', $foundItem->found_date?->format('Y-m-d')) }}"
                class="w-full rounded-xl border-gray-300">

        </div>

    </div>

    {{-- Lokasi --}}
    <div class="mt-6">

        <label class="block mb-2 font-semibold">
            Lokasi
        </label>

        <input
            type="text"
            name="location"
            value="{{ old('location', $foundItem->location) }}"
            class="w-full rounded-xl border-gray-300">

    </div>

    {{-- Deskripsi --}}
    <div class="mt-6">

        <label class="block mb-2 font-semibold">
            Deskripsi
        </label>

        <textarea
            name="description"
            rows="5"
            class="w-full rounded-xl border-gray-300">{{ old('description', $foundItem->description) }}</textarea>

    </div>

    {{-- Penemu --}}
    <div class="grid grid-cols-2 gap-6 mt-6">

        <div>

            <label class="block mb-2 font-semibold">
                Nama Penemu
            </label>

            <input
                type="text"
                name="finder_name"
                value="{{ old('finder_name', $foundItem->finder_name) }}"
                class="w-full rounded-xl border-gray-300">

        </div>

        <div>

            <label class="block mb-2 font-semibold">
                Nomor HP
            </label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone', $foundItem->phone) }}"
                class="w-full rounded-xl border-gray-300">

        </div>

    </div>

    {{-- Foto --}}
    <div class="mt-6">

        <label class="block mb-3 font-semibold">
            Foto Saat Ini
        </label>

        @if($foundItem->photo_path)

            <img
                src="{{ $foundItem->photo_path }}"
                class="w-40 h-40 rounded-xl object-cover shadow">

        @endif

    </div>

    <div class="mt-6">

        <label class="block mb-2 font-semibold">
            Upload Foto Baru
        </label>

        <input
            type="file"
            name="photo"
            class="block">

    </div>

    <div class="flex justify-end gap-4 mt-10">

        <a
            href="{{ route('admin.found-items.index') }}"
            class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300">

            Batal

        </a>

        <button
            type="submit"
            class="px-6 py-3 rounded-xl bg-blue-700 text-white hover:bg-blue-800">

            Simpan Perubahan

        </button>

    </div>

</form>

</div>

@endsection