@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')

<div
    class="w-full
           max-w-5xl
           bg-white
           rounded-[28px]
           shadow-2xl
           overflow-hidden">

    <div class="grid lg:grid-cols-2">

        {{-- PANEL KIRI --}}
        <div
            class="relative hidden lg:flex flex-col justify-between
                   p-10
                   min-h-[560px]
                   bg-cover bg-center"
            style="background-image:url('{{ asset('images/Rektorat.jpg') }}')">

            <div class="absolute inset-0 bg-primary/90"></div>

            <div class="relative z-10">

                <div class="flex items-center gap-4">

                    <img
                        src="{{ asset('images/Udayana_Logo.png') }}"
                        class="w-12 h-12">

                    <div>

                        <h1 class="text-white text-3xl font-bold">
                            Udayana
                        </h1>

                        <p class="text-blue-100 text-xl">
                            Lost and Found
                        </p>

                    </div>

                </div>

            </div>

            <div class="relative z-10">

                <p
                    class="text-white text-base leading-8 max-w-sm">

                    Membantu Anda menemukan kembali barang
                    berharga yang hilang di area kampus
                    dengan cepat dan aman.

                </p>

                <div
                    class="mt-8 flex items-center gap-3 text-blue-100">

                    <div
                        class="w-7 h-7 flex items-center justify-center text-sm">

                        <img src="{{ asset('images/Aman.png') }}" alt="Icon Berhasil" class="w-4 h-4 object-contain">

                    </div>

                    <span class="text-sm">

                        Platform Terpercaya Civitas Akademika

                    </span>

                </div>

            </div>

        </div>

        {{-- PANEL KANAN --}}
        <div
            class="flex items-center justify-center px-12 py-10">

            <div class="w-full max-w-sm">

                {{-- TAB --}}
                <div
                    class="grid grid-cols-2 border-b mb-8">

                    <a
                        href="{{ route('login') }}"
                        class="pb-4 text-center text-body hover:text-primary">

                        Masuk

                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="pb-4 text-center font-bold text-primary border-b-2 border-primary">

                        Daftar

                    </a>

                </div>

                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="space-y-4">

                    @csrf

                    {{-- Nama --}}
                    <div>

                        <label
                            class="block mb-2 text-sm font-semibold">

                            Nama Lengkap

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            placeholder="Masukkan nama lengkap"
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                        @error('name')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                        @enderror

                    </div>

                    {{-- Email --}}
                    <div>

                        <label
                            class="block mb-2 text-sm font-semibold">

                            Email Udayana

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="nim@student.unud.ac.id"
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                        @error('email')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                        @enderror

                    </div>

                    {{-- Password --}}
                    <div>

                        <label
                            class="block mb-2 text-sm font-semibold">

                            Kata Sandi

                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                        @error('password')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                        @enderror

                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>

                        <label
                            class="block mb-2 text-sm font-semibold">

                            Konfirmasi Kata Sandi

                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            placeholder="••••••••"
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-xl bg-primary text-white font-semibold hover:bg-blue-700 transition">

                        Daftar

                    </button>

                    <p
                        class="text-center text-xs leading-6 text-body">

                        Sudah memiliki akun?

                        <a
                            href="{{ route('login') }}"
                            class="font-semibold text-primary">

                            Masuk di sini

                        </a>

                    </p>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection