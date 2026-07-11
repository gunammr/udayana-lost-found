@extends('layouts.landing')

@section('title', 'Barang Hilang')

@section('content')

    <section class="relative overflow-hidden bg-background py-16 lg:py-20">

        <div class="absolute left-1/2 top-24 h-72 w-72 -translate-x-1/2 rounded-full bg-soft-blue/50 blur-3xl"></div>
        <div class="absolute bottom-24 left-1/4 h-48 w-48 rounded-full bg-warning/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-3xl px-6">

            <div class="rounded-2xl border border-blue-100/70 bg-white/90 p-6 shadow-card backdrop-blur-md sm:p-8 lg:p-10">

                <div class="text-center">
                    <h1 class="text-3xl font-extrabold text-primary sm:text-4xl">
                        Formulir Laporan
                    </h1>

                    <p class="mt-3 text-sm text-body sm:text-base">
                        Silakan isi detail barang yang hilang atau ditemukan.
                    </p>
                </div>

                <div
                    class="mx-auto mt-8 grid max-w-sm grid-cols-2 rounded-lg border border-gray-300 bg-white p-1 text-center text-sm font-semibold">
                    <a href="{{ route('lost-items.create') }}" class="rounded-md bg-primary px-4 py-2 text-white shadow-sm">
                        Barang Hilang
                    </a>

                    <a href="{{ route('found-items.create') }}"
                        class="rounded-md px-4 py-2 text-body transition hover:bg-gray-50 hover:text-primary">
                        Barang Ditemukan
                    </a>
                </div>

                @if (session('success'))
                    <div
                        class="mt-8 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-8 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
                        <p class="font-bold">
                            Ada data yang perlu diperbaiki.
                        </p>
                        <p class="mt-1">
                            Periksa kembali field yang ditandai di bawah ini.
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('lost-items.store') }}" enctype="multipart/form-data"
                    class="mt-8 space-y-5" x-data="{
                        photoName: '',
                        photoPreview: null,
                        updatePhoto(event) {
                            const [file] = event.target.files;
                            this.photoName = file ? file.name : '';
                            this.photoPreview = null;

                            if (!file) {
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = (readerEvent) => {
                                this.photoPreview = readerEvent.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    }">
                    @csrf

                    <div>
                        <label for="item_name" class="text-sm font-bold text-primary-dark">
                            Nama Barang
                        </label>
                        <input id="item_name" name="item_name" type="text" value="{{ old('item_name') }}"
                            placeholder="Contoh: Dompet Hitam, Kunci Motor, Laptop"
                            class="mt-2 w-full border-gray-300 bg-white text-sm text-primary-dark placeholder:text-gray-400 focus:border-primary focus:ring-primary @error('item_name') border-red-400 @enderror">
                        @error('item_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="text-sm font-bold text-primary-dark">
                                Kategori
                            </label>
                            <select id="category_id" name="category_id"
                                class="mt-2 w-full border-gray-300 bg-white text-sm text-primary-dark focus:border-primary focus:ring-primary @error('category_id') border-red-400 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((int) old('category_id') === $category->id)>
                                        {{ $category->category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="incident_date" class="text-sm font-bold text-primary-dark">
                                Tanggal Kejadian
                            </label>
                            <input id="incident_date" name="incident_date" type="date" value="{{ old('incident_date') }}"
                                class="mt-2 w-full border-gray-300 bg-white text-sm text-primary-dark focus:border-primary focus:ring-primary @error('incident_date') border-red-400 @enderror">
                            @error('incident_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="location" class="text-sm font-bold text-primary-dark">
                            Lokasi Kejadian (Terakhir dilihat/Ditemukan)
                        </label>
                        <div class="relative mt-2">
                            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5h.01" />
                                </svg>
                            </span>
                            <input id="location" name="location" type="text" value="{{ old('location') }}"
                                placeholder="Contoh: Gedung Agrokompleks Lt. 2, Parkiran Rektorat"
                                class="w-full border-gray-300 bg-white pl-10 text-sm text-primary-dark placeholder:text-gray-400 focus:border-primary focus:ring-primary @error('location') border-red-400 @enderror">
                        </div>
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="text-sm font-bold text-primary-dark">
                            Deskripsi Tambahan
                        </label>
                        <textarea id="description" name="description" rows="5"
                            placeholder="Jelaskan ciri-ciri khusus barang, merek, isi dompet, dll"
                            class="mt-2 w-full resize-none border-gray-300 bg-white text-sm text-primary-dark placeholder:text-gray-400 focus:border-primary focus:ring-primary @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="photo" class="text-sm font-bold text-primary-dark">
                            Unggah Foto (Opsional)
                        </label>
                        <label for="photo"
                            class="mt-2 flex min-h-44 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-blue-200 bg-background/70 px-6 py-8 text-center transition hover:border-primary hover:bg-blue-50">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" alt="Preview foto laporan"
                                    class="mb-4 h-36 w-full max-w-sm rounded-xl object-cover shadow-sm">
                            </template>

                            <span x-show="!photoPreview"
                                class="flex h-14 w-14 items-center justify-center rounded-full bg-soft-blue text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2 1.586-1.586a2 2 0 0 1 2.828 0L20 14m-6-8h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                                </svg>
                            </span>
                            <span class="mt-4 text-sm font-bold text-primary">
                                <span x-text="photoName || 'Klik untuk memilih file atau seret ke area ini'"></span>
                            </span>
                            <span class="mt-2 text-xs text-gray-500">
                                Mendukung format PNG, JPG, JPEG, WEBP hingga 10MB
                            </span>
                        </label>
                        <input id="photo" name="photo" type="file" accept="image/png,image/jpeg,image/webp" class="sr-only"
                            @change="updatePhoto">
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-soft-blue text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 20c.8-3.333 3.133-5 7-5s6.2 1.667 7 5" />
                                </svg>
                            </span>
                            <h2 class="text-xl font-bold text-primary-dark">
                                Informasi Kontak Anda
                            </h2>
                        </div>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="reporter_name" class="text-sm font-bold text-primary-dark">
                                    Nama Lengkap
                                </label>
                                <input id="reporter_name" name="reporter_name" type="text"
                                    value="{{ old('reporter_name', auth()->user()->name ?? '') }}"
                                    placeholder="Masukkan nama lengkap"
                                    class="mt-2 w-full border-gray-300 bg-white text-sm text-primary-dark placeholder:text-gray-400 focus:border-primary focus:ring-primary @error('reporter_name') border-red-400 @enderror">
                                @error('reporter_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="text-sm font-bold text-primary-dark">
                                    Nomor WhatsApp / HP
                                </label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                    placeholder="Contoh: 081234567890"
                                    class="mt-2 w-full border-gray-300 bg-white text-sm text-primary-dark placeholder:text-gray-400 focus:border-primary focus:ring-primary @error('phone') border-red-400 @enderror">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-body transition hover:border-primary hover:text-primary">
                                Batal
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-white shadow-md shadow-primary/10 transition hover:bg-primary-hover">
                                Kirim Laporan
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection
