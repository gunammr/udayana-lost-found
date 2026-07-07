@extends('layouts.admin')

@section('title', 'Kelola Klaim')

@section('content')

<div class="mb-8 flex items-start justify-between">

    <div>

        <h1 class="text-4xl font-bold text-gray-800">
            Kelola Klaim
        </h1>

        <p class="mt-2 text-gray-500">
            {{ $claims->count() }} klaim masuk
        </p>

    </div>

</div>

<div class="mb-6 flex gap-3">

    <a href="{{ route('admin.claims.index') }}"
       class="rounded-xl px-5 py-2 font-semibold transition
       {{ request('status') == null ? 'bg-blue-700 text-white' : 'bg-white border border-gray-300' }}">
        Semua
    </a>

    <a href="{{ route('admin.claims.index', ['status' => 'menunggu']) }}"
       class="rounded-xl px-5 py-2 font-semibold transition
       {{ request('status') == 'menunggu' ? 'bg-yellow-500 text-white' : 'bg-white border border-gray-300' }}">
        Menunggu
    </a>

    <a href="{{ route('admin.claims.index', ['status' => 'diterima']) }}"
       class="rounded-xl px-5 py-2 font-semibold transition
       {{ request('status') == 'diterima' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300' }}">
        Selesai
    </a>

    <a href="{{ route('admin.claims.index', ['status' => 'ditolak']) }}"
       class="rounded-xl px-5 py-2 font-semibold transition
       {{ request('status') == 'ditolak' ? 'bg-red-600 text-white' : 'bg-white border border-gray-300' }}">
        Ditolak
    </a>

</div>

@if(session('success'))

    <div class="mb-6 rounded-xl border border-green-300 bg-green-100 px-5 py-4 text-green-700">

        {{ session('success') }}

    </div>

@endif

<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="rounded-2xl bg-white p-6 shadow">

        <p class="text-gray-500">

            Total Klaim

        </p>

        <h2 class="mt-2 text-3xl font-bold">

            {{ $claims->count() }}

        </h2>

    </div>

    <div class="rounded-2xl bg-white p-6 shadow">

        <p class="text-gray-500">

            Menunggu

        </p>

        <h2 class="mt-2 text-3xl font-bold text-yellow-500">

            {{ $claims->where('status','menunggu')->count() }}

        </h2>

    </div>

    <div class="rounded-2xl bg-white p-6 shadow">

        <p class="text-gray-500">

            Selesai

        </p>

        <h2 class="mt-2 text-3xl font-bold text-green-600">

            {{ $claims->where('status','diterima')->count() }}

        </h2>

    </div>

</div>

<div class="overflow-hidden rounded-3xl bg-white shadow">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr class="border-b">

                <th class="px-6 py-5 text-left">

                    Barang

                </th>

                <th class="px-6 py-5 text-left">

                    Kategori

                </th>

                <th class="px-6 py-5 text-left">

                    Pengklaim

                </th>

                <th class="px-6 py-5 text-left">

                    Status

                </th>

                <th class="px-6 py-5 text-center">

                    Aksi

                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($claims as $claim)

                <tr class="border-b hover:bg-blue-50">

                    <td class="px-6 py-6">

                        <div>

                            <p class="font-semibold">

                                {{ optional($claim->foundItem->categoryData)->item_name }}

                            </p>

                            <p class="text-sm text-gray-500">

                                {{ optional($claim->foundItem)->item_name }}

                            </p>

                        </div>

                    </td>

                    <td class="px-6 py-6">

                        {{ optional($claim->foundItem->categoryData)->category }}

                    </td>

                    <td class="px-6 py-6">

                        <div>

                            <p class="font-semibold">

                                {{ optional($claim->user)->name }}

                            </p>

                            <p class="text-sm text-gray-500">

                                {{ optional($claim->user)->email }}

                            </p>

                        </div>

                    </td>

                    <td class="px-6 py-6">
                                                @if($claim->status == 'menunggu')

                            <span
                                class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">

                                Menunggu

                            </span>

                        @elseif($claim->status == 'diterima')

                            <span
                                class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">

                                Diterima

                            </span>

                        @else

                            <span
                                class="rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">

                                Ditolak

                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-6">

                        <div class="flex justify-center gap-3">

                            {{-- Detail --}}
                            <button
                                type="button"
                                class="detailBtn flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 transition"

                                data-item="{{ $claim->foundItem->item_name }}"
                                data-category="{{ optional($claim->foundItem->categoryData)->category }}"
                                data-user="{{ optional($claim->user)->name }}"
                                data-email="{{ optional($claim->user)->email }}"
                                data-message="{{ $claim->message }}"
                                data-photo="{{ $claim->photo_path ? asset('storage/' . $claim->photo_path) : '' }}"
                                data-status="{{ $claim->status }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="h-5 w-5">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>

                            {{-- Terima --}}
                            @if($claim->status == 'menunggu')

                                <form
                                    action="{{ route('admin.claims.verify', $claim) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-700 hover:bg-green-200">

                                        ✓

                                    </button>

                                </form>

                                {{-- Tolak --}}
                                <form
                                    action="{{ route('admin.claims.reject', $claim) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-700 hover:bg-red-200">

                                        ✕

                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="5"
                        class="py-16 text-center text-gray-400">

                        Belum ada data klaim.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- Modal Detail Klaim --}}
<div
    id="detailModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-2xl rounded-2xl bg-white p-8 shadow-xl max-h-[90vh] overflow-y-auto">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold text-gray-800">
                Detail Klaim
            </h2>

            <button
                id="closeDetailModal"
                class="text-3xl text-gray-400 hover:text-red-500">

                &times;

            </button>

        </div>

        <div class="grid grid-cols-2 gap-6">

            <div>

                <label class="text-sm text-gray-500">
                    Nama Barang
                </label>

                <p
                    id="detailItem"
                    class="mt-1 font-semibold text-gray-800">
                </p>

            </div>

            <div>

                <label class="text-sm text-gray-500">
                    Kategori
                </label>

                <p
                    id="detailCategory"
                    class="mt-1 font-semibold text-gray-800">
                </p>

            </div>

            <div>

                <label class="text-sm text-gray-500">
                    Nama Pengklaim
                </label>

                <p
                    id="detailUser"
                    class="mt-1 font-semibold text-gray-800">
                </p>

            </div>

            <div>

                <label class="text-sm text-gray-500">
                    Email
                </label>

                <p
                    id="detailEmail"
                    class="mt-1 font-semibold text-gray-800">
                </p>

            </div>

            <div class="col-span-2">

                <label class="text-sm text-gray-500">
                    Bukti Kepemilikan
                </label>

                <div
                    id="detailMessage"
                    class="mt-2 rounded-xl bg-gray-100 p-4 text-gray-700 break-words whitespace-pre-wrap">
                </div>

            </div>

            {{-- Foto Bukti --}}
            <div class="col-span-2" id="detailPhotoWrapper" style="display:none">
                <label class="text-sm text-gray-500">Foto Bukti</label>
                <img id="detailPhoto" src="" alt="Foto bukti klaim" class="mt-2 w-full aspect-square rounded-xl object-contain bg-gray-50 border border-gray-200">
            </div>

            <div class="col-span-2">

                <label class="text-sm text-gray-500">
                    Status
                </label>

                <div class="mt-2">

                    <span
                        id="detailStatus"
                        class="inline-block rounded-full px-4 py-2 text-sm font-semibold">
                    </span>

                </div>

            </div>

        </div>

        <div class="mt-8 flex justify-end">

            <button
                id="closeDetailBottom"
                class="rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-800">

                Tutup

            </button>

        </div>

    </div>

</div>

<script>

    const detailModal = document.getElementById('detailModal');

    document.querySelectorAll('.detailBtn').forEach(button => {

        button.addEventListener('click', function () {

            document.getElementById('detailItem').innerText =
                this.dataset.item;

            document.getElementById('detailCategory').innerText =
                this.dataset.category;

            document.getElementById('detailUser').innerText =
                this.dataset.user;

            document.getElementById('detailEmail').innerText =
                this.dataset.email;

            document.getElementById('detailMessage').innerText =
                this.dataset.message;

            // Foto bukti
            const photoUrl = this.dataset.photo;
            const photoWrapper = document.getElementById('detailPhotoWrapper');
            const photoImg = document.getElementById('detailPhoto');
            if (photoUrl) {
                photoImg.src = photoUrl;
                photoWrapper.style.display = 'block';
            } else {
                photoWrapper.style.display = 'none';
            }

            const status = button.dataset.status;
            const detailStatus = document.getElementById('detailStatus');

            detailStatus.textContent =
                status.charAt(0).toUpperCase() + status.slice(1);

            detailStatus.className =
                'inline-block rounded-full px-4 py-2 text-sm font-semibold';

            if (status === 'menunggu') {

                detailStatus.classList.add(
                    'bg-yellow-100',
                    'text-yellow-700'
                );

            } else if (status === 'diterima') {

                detailStatus.classList.add(
                    'bg-green-100',
                    'text-green-700'
                );

            } else {

                detailStatus.classList.add(
                    'bg-red-100',
                    'text-red-700'
                );

            }

            detailModal.classList.remove('hidden');

            detailModal.classList.add('flex');

        });

    });

    function closeDetailModal() {

        detailModal.classList.remove('flex');

        detailModal.classList.add('hidden');

    }

    document
        .getElementById('closeDetailModal')
        .addEventListener('click', closeDetailModal);

    document
        .getElementById('closeDetailBottom')
        .addEventListener('click', closeDetailModal);

</script>

@endsection