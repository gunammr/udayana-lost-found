@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

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

                <p class="text-white text-base leading-8 max-w-sm">

                    Jangan khawatir, kami akan membantu
                    Anda mengatur ulang kata sandi akun
                    dengan aman.

                </p>

                <div
                    class="mt-8 flex items-center gap-3 text-blue-100">

                    <div
                        class="w-7 h-7 flex items-center justify-center text-sm">

                        <img src="{{ asset('images/Aman.png') }}" alt="Icon Berhasil" class="w-4 h-4 object-contain">

                    </div>

                    <span class="text-sm">

                        Platform Terpercaya Sivitas Akademika

                    </span>

                </div>

            </div>

        </div>

        {{-- PANEL KANAN --}}
        <div
            class="flex items-center justify-center px-12 py-10">

            <div class="w-full max-w-sm">

                <h2
                    class="text-3xl font-bold text-primary-dark">

                    Lupa Kata Sandi

                </h2>

                <p
                    class="mt-3 text-body leading-7">

                    Masukkan email Udayana Anda.
                    Kami akan mengirimkan tautan
                    untuk mengatur ulang kata sandi.

                </p>

                @if (session('status'))

                    <div
                        class="mt-6 rounded-xl bg-green-100 text-green-700 p-4 text-sm">

                        {{ session('status') }}

                    </div>

                @endif

                <form
                    method="POST"
                    action="{{ route('password.email') }}"
                    class="space-y-6 mt-8">

                    @csrf

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
                            autofocus
                            placeholder="nim@student.unud.ac.id"
                            class="w-full h-12 rounded-xl border border-gray-300 px-4 focus:ring-2 focus:ring-primary focus:border-primary">

                        @error('email')

                            <p
                                class="mt-2 text-sm text-red-500">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 rounded-xl bg-primary text-white font-semibold hover:bg-blue-700 transition">

                        Kirim Link Reset Password

                    </button>

                    <div
                        class="text-center">

                        <a
                            href="{{ route('login') }}"
                            class="text-primary font-semibold hover:underline">

                            ← Kembali ke Login

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection