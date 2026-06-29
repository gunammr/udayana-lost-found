@extends('layouts.auth')

@section('title', 'Masuk')

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

            {{-- Overlay --}}
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

                        <image src="{{ asset('images/Aman.png') }}" alt="Icon Berhasil" class="w-4 h-4 object-contain">

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
                        class="pb-4 text-center font-bold text-primary border-b-2 border-primary">

                        Masuk

                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="pb-4 text-center text-body hover:text-primary">

                        Daftar

                    </a>

                </div>

                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="space-y-5">

                    @csrf

                    {{-- EMAIL --}}
                    <div>

                        <label class="block mb-2 text-sm font-semibold">

                            Email Udayana

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nim@student.unud.ac.id"
                            required
                            autofocus
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                        @error('email')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                        @enderror

                    </div>

                    {{-- PASSWORD --}}
                    <div>

                        <label class="block mb-2 text-sm font-semibold">

                            Kata Sandi

                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                        @error('password')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                        @enderror

                    </div>

                    <div class="flex justify-end">

                        @if(Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-primary hover:underline">

                            Lupa Kata Sandi?

                        </a>

                        @endif

                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-xl bg-primary text-white font-semibold hover:bg-blue-700 transition">

                        Masuk

                    </button>

                    <p
                        class="mt-6 text-center text-xs leading-6 text-body">

                        Dengan masuk atau mendaftar, Anda menyetujui

                        <a href="#"
                            class="font-semibold text-primary">

                            Syarat & Ketentuan

                        </a>

                        serta

                        <a href="#"
                            class="font-semibold text-primary">

                            Kebijakan Privasi

                        </a>.

                    </p>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection