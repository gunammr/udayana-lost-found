@extends('layouts.admin')

@section('title', 'Edit Barang Hilang')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-gray-800">
        Edit Barang Hilang
    </h1>

    <p class="text-gray-500 mt-2">
        Perbarui data barang hilang.
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

<form action="{{ route('admin.lost-items.update', $lostItem) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-6">

        <label class="block mb-2 font-semibold">
            Nama Barang
        </label>

        <input
            type="text"
            name="item_name"
            value="{{ old('item_name', $lostItem->item_name) }}"
            class="w-full rounded-xl border-gray-300">

    </div>

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
                    {{ $lostItem->category == $category ? 'selected' : '' }}>

                    {{ $category }}

                </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="block mb-2 font-semibold">
                Tanggal Hilang
            </label>

            <input
                type="date"
                name="incident_date"
                value="{{ old('incident_date', $lostItem->incident_date?->format('Y-m-d')) }}"
                class="w-full rounded-xl border-gray-300">

        </div>

    </div>

    <div class="mt-6">

        <label class="block mb-2 font-semibold">
            Lokasi
        </label>

        <input
            type="text"
            name="location"
            value="{{ old('location', $lostItem->location) }}"
            class="w-full rounded-xl border-gray-300">

    </div>

    <div class="mt-6">

        <label class="block mb-2 font-semibold">
            Deskripsi
        </label>

        <textarea
            name="description"
            rows="5"
            class="w-full rounded-xl border-gray-300">{{ old('description', $lostItem->description) }}</textarea>

    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">

        <div>

            <label class="block mb-2 font-semibold">
                Nama Pelapor
            </label>

            <input
                type="text"
                name="reporter_name"
                value="{{ old('reporter_name', $lostItem->reporter_name) }}"
                class="w-full rounded-xl border-gray-300">

        </div>

        <div>

            <label class="block mb-2 font-semibold">
                Nomor HP
            </label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone', $lostItem->phone) }}"
                class="w-full rounded-xl border-gray-300">

        </div>

    </div>

    <div class="mt-6">

        <label class="block mb-3 font-semibold">

            Foto Saat Ini

        </label>

        @if($lostItem->photo_path)

            <img
                src="{{ $lostItem->photo_path }}"
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
            href="{{ route('admin.lost-items.index') }}"
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