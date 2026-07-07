@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')

<div class="mb-8 flex items-start justify-between">

    <div>

        <h1 class="text-4xl font-bold text-gray-800">
            Kelola User
        </h1>

        <p class="mt-2 text-gray-500">
            {{ $totalUser }} user terdaftar
        </p>

    </div>

    <button
        id="openCreateModal"
        class="rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white shadow transition hover:bg-blue-800">

        + Tambah User

    </button>

</div>

@if(session('success'))

    <div class="mb-6 rounded-xl border border-green-300 bg-green-100 px-5 py-4 text-green-700">

        {{ session('success') }}

    </div>

@endif

<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="rounded-2xl bg-white shadow-md p-6">

        <p class="text-gray-500 text-sm">
            Total User
        </p>

        <h2 class="mt-2 text-3xl font-bold">
            {{ $totalUser }}
        </h2>

    </div>

    <div class="rounded-2xl bg-white shadow-md p-6">

        <p class="text-gray-500 text-sm">
            Admin
        </p>

        <h2 class="mt-2 text-3xl font-bold">
            {{ $totalAdmin }}
        </h2>

    </div>

    <div class="rounded-2xl bg-white shadow-md p-6">

        <p class="text-gray-500 text-sm">
            User
        </p>

        <h2 class="mt-2 text-3xl font-bold">
            {{ $totalMahasiswa }}
        </h2>

    </div>

</div>

<div class="overflow-x-auto rounded-3xl border border-gray-100 bg-white shadow-lg">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr class="text-xs uppercase tracking-wider text-gray-500">

                <th class="px-8 py-5 text-left">
                    User
                </th>

                <th class="px-6 py-5 text-left">
                    NIM
                </th>

                <th class="px-6 py-5 text-left">
                    Fakultas
                </th>

                <th class="px-6 py-5 text-left">
                    Role
                </th>

                <th class="px-6 py-5 text-left">
                    Bergabung
                </th>

                <th class="px-6 py-5 text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

                <tr class="border-t hover:bg-blue-50 transition">

                    <td class="px-8 py-6">

                        <div class="flex items-center gap-4">

                            @if ($user->avatar_path)
                                <img src="{{ asset('storage/' . $user->avatar_path) }}" class="object-cover w-12 h-12 border border-blue-200 rounded-full">
                            @else
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                            <div>

                                <p class="font-semibold text-gray-800">

                                    {{ $user->name }}

                                </p>

                                <p class="text-sm text-gray-500">

                                    {{ $user->email }}

                                </p>

                            </div>

                        </div>

                    </td>

                    <td class="px-6 py-6">

                        {{ $user->nim }}

                    </td>

                    <td class="px-6 py-6">

                        {{ $user->fakultas }}

                    </td>

                    <td class="px-6 py-6">

                        @if($user->role == 'admin')

                            <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">

                                Admin

                            </span>

                        @else

                            <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">

                                User

                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-6">

                        {{ $user->created_at->format('d M Y') }}

                    </td>

                    <td class="px-6 py-6">

                        <div class="flex justify-center gap-3">

                            <button
                                type="button"
                                class="editUserBtn flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 hover:bg-blue-100"

                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-nim="{{ $user->nim }}"
                                data-fakultas="{{ $user->fakultas }}"
                                data-program="{{ $user->program_studi }}"
                                data-angkatan="{{ $user->tahun_angkatan }}"
                                data-phone="{{ $user->phone }}"
                                data-role="{{ $user->role }}">

                                <img
                                    src="{{ asset('images/icons/edit.svg') }}"
                                    class="w-5">

                            </button>

                            <form
                                action="{{ route('admin.users.destroy', $user) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 hover:bg-red-100">

                                    <img
                                        src="{{ asset('images/icons/delete.svg') }}"
                                        class="w-5">

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="py-16 text-center text-gray-400">

                        Belum ada data user.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="border-t bg-gray-50 px-8 py-5">

        {{ $users->links() }}

    </div>

</div>

{{-- Modal Tambah User --}}
<div
    id="createModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-2xl rounded-2xl bg-white p-8">

        <div class="flex items-center justify-between mb-6">

            <h2 class="text-2xl font-bold">
                Tambah User
            </h2>

            <button
                id="closeCreateModal"
                class="text-2xl text-gray-400 hover:text-red-500">

                &times;

            </button>

        </div>

        <form
            action="{{ route('admin.users.store') }}"
            method="POST">

            @csrf

            <div class="grid grid-cols-2 gap-5">

                <div>

                    <label class="font-medium">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        NIM
                    </label>

                    <input
                        type="text"
                        name="nim"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        Fakultas
                    </label>

                    <input
                        type="text"
                        name="fakultas"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        Program Studi
                    </label>

                    <input
                        type="text"
                        name="program_studi"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        Tahun Angkatan
                    </label>

                    <input
                        type="number"
                        name="tahun_angkatan"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div>

                    <label class="font-medium">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="mt-2 w-full rounded-lg border p-3"
                        required>

                </div>

                <div class="col-span-2">

                    <label class="font-medium">
                        Role
                    </label>

                    <select
                        name="role"
                        class="mt-2 w-full rounded-lg border p-3">

                        <option value="user">
                            User
                        </option>

                        <option value="admin">
                            Admin
                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <button
                    type="button"
                    id="cancelCreateModal"
                    class="rounded-lg bg-gray-200 px-5 py-3">

                    Batal

                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-700 px-5 py-3 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

{{-- Modal Edit User --}}
<div
    id="editModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="w-full max-w-2xl rounded-2xl bg-white p-8">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold">
                Edit User
            </h2>

            <button
                type="button"
                id="closeEditModal"
                class="text-2xl text-gray-400 hover:text-red-500">

                &times;

            </button>

        </div>

        <form
            id="editForm"
            method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-5">

                <div>

                    <label>Nama</label>

                    <input
                        id="edit_name"
                        name="name"
                        type="text"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>Email</label>

                    <input
                        id="edit_email"
                        name="email"
                        type="email"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>Password Baru</label>

                    <input
                        name="password"
                        type="password"
                        placeholder="Kosongkan jika tidak diubah"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>NIM</label>

                    <input
                        id="edit_nim"
                        name="nim"
                        type="text"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>Fakultas</label>

                    <input
                        id="edit_fakultas"
                        name="fakultas"
                        type="text"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>Program Studi</label>

                    <input
                        id="edit_program"
                        name="program_studi"
                        type="text"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>Tahun Angkatan</label>

                    <input
                        id="edit_angkatan"
                        name="tahun_angkatan"
                        type="number"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div>

                    <label>No HP</label>

                    <input
                        id="edit_phone"
                        name="phone"
                        type="text"
                        class="mt-2 w-full rounded-lg border p-3">

                </div>

                <div class="col-span-2">

                    <label>Role</label>

                    <select
                        id="edit_role"
                        name="role"
                        class="mt-2 w-full rounded-lg border p-3">

                        <option value="user">User</option>
                        <option value="admin">Admin</option>

                    </select>

                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <button
                    type="button"
                    id="cancelEditModal"
                    class="rounded-lg bg-gray-200 px-5 py-3">

                    Batal

                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-700 px-5 py-3 text-white">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

    const createModal = document.getElementById('createModal');

    document
        .getElementById('openCreateModal')
        .addEventListener('click', () => {

            createModal.classList.remove('hidden');

            createModal.classList.add('flex');

        });

    function closeModal() {

        createModal.classList.remove('flex');

        createModal.classList.add('hidden');

    }

    document
        .getElementById('closeCreateModal')
        .addEventListener('click', closeModal);

    document
        .getElementById('cancelCreateModal')
        .addEventListener('click', closeModal);


    const editModal = document.getElementById('editModal');

    document.querySelectorAll('.editUserBtn').forEach(button => {

        button.addEventListener('click', function () {

            document.getElementById('editForm').action =
                `/admin/users/${this.dataset.id}`;

            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_email').value = this.dataset.email;
            document.getElementById('edit_nim').value = this.dataset.nim;
            document.getElementById('edit_fakultas').value = this.dataset.fakultas;
            document.getElementById('edit_program').value = this.dataset.program;
            document.getElementById('edit_angkatan').value = this.dataset.angkatan;
            document.getElementById('edit_phone').value = this.dataset.phone;
            document.getElementById('edit_role').value = this.dataset.role;

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');

        });

    });

    function closeEditModal() {

        editModal.classList.remove('flex');
        editModal.classList.add('hidden');

    }

    document.getElementById('closeEditModal')
        .addEventListener('click', closeEditModal);

    document.getElementById('cancelEditModal')
        .addEventListener('click', closeEditModal);

</script>



@endsection