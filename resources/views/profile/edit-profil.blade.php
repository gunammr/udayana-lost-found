@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl px-4 py-12 mx-auto sm:px-6 lg:px-8">

    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-1 text-sm font-medium text-primary hover:underline">
            ‹ Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Profil</h1>
        <p class="mt-1 text-sm text-gray-500">Perbarui informasi akun dan data diri Anda yang tersimpan di sistem.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="px-4 py-3 mb-6 text-sm font-medium text-green-700 bg-green-50 rounded-xl">
            Profil berhasil diperbarui.
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Foto Profil --}}
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
            <h3 class="mb-4 text-sm font-bold text-gray-800">Foto Profil</h3>
            <div class="flex items-center gap-5">
                <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('images/default-avatar.png') }}"
                     class="object-cover w-16 h-16 border rounded-full">
                <div>
                    <p class="text-sm font-semibold text-gray-700">Ubah foto profil</p>
                    <p class="mb-2 text-xs text-gray-400">Format JPG, PNG. Ukuran maksimal 2MB.</p>
                    <label class="inline-block px-4 py-2 text-xs font-bold transition rounded-lg cursor-pointer bg-blue-50 text-primary hover:bg-blue-100">
                        Pilih Foto
                        <input type="file" name="avatar" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>
            @error('avatar')
                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Data Akun --}}
        <div class="p-6 space-y-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Data Akun</h3>
                <p class="text-xs text-gray-400">Kelola data utama akun Anda.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Nomor HP (WhatsApp)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           placeholder="+62 8xx-xxxx-xxxx"
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Role</label>
                    <div class="flex items-center justify-between w-full px-4 py-3 text-sm text-gray-500 bg-gray-100 rounded-xl">
                        <span class="capitalize">{{ $user->role ?? 'user' }}</span>
                        <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Read-only</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Akademik --}}
        <div class="p-6 space-y-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Data Akademik</h3>
                <p class="text-xs text-gray-400">Informasi tambahan sebagai mahasiswa.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim', $user->nim) }}"
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('nim')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Tahun Angkatan</label>
                    <input type="text" name="tahun_angkatan" value="{{ old('tahun_angkatan', $user->tahun_angkatan) }}"
                           placeholder="2021"
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('tahun_angkatan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Program Studi</label>
                    <input type="text" name="program_studi" value="{{ old('program_studi', $user->program_studi) }}"
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('program_studi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-xs font-bold text-gray-700">Fakultas</label>
                    <input type="text" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}"
                           class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">
                    @error('fakultas')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Bio --}}
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl">
            <h3 class="mb-1 text-sm font-bold text-gray-800">Bio</h3>
            <label class="block mt-4 mb-2 text-xs font-bold text-gray-700">Tentang Saya</label>
            <textarea name="bio" rows="3" placeholder="Deskripsi singkat tentang diri Anda..."
                      class="w-full px-4 py-3 text-sm text-gray-800 transition border border-gray-200 outline-none resize-none bg-gray-50 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 pt-2">
            <a href="{{ route('dashboard') }}"
               class="px-6 py-3 text-sm font-bold text-gray-700 transition bg-gray-100 rounded-xl hover:bg-gray-200">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-3 text-sm font-bold text-white transition shadow-sm rounded-xl bg-primary hover:bg-primary-hover">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection