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
        id="openAddCategoryModal"
        type="button"
        class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-xl font-semibold shadow">

        + Tambah Kategori

    </button>

</div>

<div class="grid grid-cols-4 gap-6">

    @foreach($categories as $category)

    <div
    class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition p-6">

        <div class="flex justify-between items-start">

            <h3 class="font-bold text-xl text-gray-800">

                {{ $category->category }}

            </h3>

            <div class="flex gap-3">

                {{-- Edit --}}
                <button
                    type="button"
                    class="editCategoryBtn rounded-lg p-2 hover:bg-blue-100 transition"
                    data-id="{{ $category->id }}"
                    data-category="{{ $category->category }}">

                    <img
                        src="{{ asset('images/icons/edit.svg') }}"
                        class="h-5 w-5"
                        alt="Edit">

                </button>

                {{-- Delete --}}
                <form
                    action="{{ route('admin.categories.destroy', $category) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rounded-lg p-2 hover:bg-red-100 transition">

                        <img
                            src="{{ asset('images/icons/delete.svg') }}"
                            class="h-5 w-5"
                            alt="Delete">

                    </button>

                </form>

            </div>

        </div>

        <div class="flex justify-between items-center mt-6">

            <span class="text-gray-400">

                {{ $category->count }} barang

            </span>

            <a
                href="{{ route('admin.categories.show', $category) }}"
                class="font-semibold text-blue-600 hover:text-blue-800">

                Lihat Semua →

            </a>

        </div>

    </div>

    @endforeach

</div>

{{-- Modal Tambah Kategori --}}
<div
    id="addCategoryModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white p-8 shadow-xl">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold text-gray-800">

                Tambah Kategori

            </h2>

            <button
                type="button"
                id="closeAddCategoryModal"
                class="text-3xl text-gray-400 hover:text-red-500">

                &times;

            </button>

        </div>

        <form
            action="{{ route('admin.categories.store') }}"
            method="POST">

            @csrf

            {{-- Nama Kategori --}}
            <div class="mb-5">

                <label class="mb-2 block text-sm font-medium text-gray-700">

                    Nama Kategori

                </label>

                <input
                    type="text"
                    name="category"
                    required
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-600 focus:outline-none">

            </div>

            <div class="flex justify-end gap-3">

                <button
                    type="button"
                    id="cancelAddCategory"
                    class="rounded-xl border border-gray-300 px-5 py-3 font-semibold hover:bg-gray-100">

                    Batal

                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white hover:bg-blue-800">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<div
    id="editCategoryModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-lg rounded-2xl bg-white p-8">

        <h2 class="mb-6 text-2xl font-bold">

            Edit Kategori

        </h2>

        <form
            id="editCategoryForm"
            method="POST">

            @csrf
            @method('PUT')

            <div class="mb-6">

                <label class="block mb-2">

                    Nama Kategori

                </label>

                <input
                    id="editCategoryInput"
                    type="text"
                    name="category"
                    class="w-full rounded-xl border px-4 py-3">

            </div>

            <div class="flex justify-end gap-3">

                <button
                    type="button"
                    id="cancelEditCategory"
                    class="rounded-xl border px-5 py-3">

                    Batal

                </button>

                <button
                    class="rounded-xl bg-blue-700 px-5 py-3 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

    const addCategoryModal =
        document.getElementById('addCategoryModal');

    document
    .getElementById('openAddCategoryModal')
    .addEventListener('click', () => {

        addCategoryModal.classList.remove('hidden');
        addCategoryModal.classList.add('flex');

    });

    function closeAddCategoryModal() {

        addCategoryModal.classList.add('hidden');
        addCategoryModal.classList.remove('flex');

    }

    document
    .getElementById('closeAddCategoryModal')
    .addEventListener('click', closeAddCategoryModal);

    document
    .getElementById('cancelAddCategory')
    .addEventListener('click', closeAddCategoryModal);

    addCategoryModal.addEventListener('click', function(e){

        if(e.target === addCategoryModal){

            closeAddCategoryModal();

        }

    });

    const editModal =
    document.getElementById('editCategoryModal');

    document.querySelectorAll('.editCategoryBtn')
    .forEach(btn=>{

        btn.addEventListener('click',()=>{

            document
            .getElementById('editCategoryInput')
            .value = btn.dataset.category;

            document
            .getElementById('editCategoryForm')
            .action =
            `/admin/kategori/${btn.dataset.id}`;

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');

        });

    });

    document
    .getElementById('cancelEditCategory')
    .onclick=()=>{

        editModal.classList.add('hidden');
        editModal.classList.remove('flex');

    };

</script>

@endsection