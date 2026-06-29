<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8F9FF] font-sans overflow-hidden">

    {{-- Blur Kiri --}}
    <div
        class="fixed
               -left-40
               -top-40
               w-[360px]
               h-[360px]
               rounded-full
               bg-[#CFDCFF]
               blur-[120px]
               opacity-80
               -z-10">
    </div>

    {{-- Blur Kanan --}}
    <div
        class="fixed
               -right-40
               bottom-0
               w-[360px]
               h-[360px]
               rounded-full
               bg-[#CFDCFF]
               blur-[120px]
               opacity-80
               -z-10">
    </div>

    <main
        class="relative min-h-screen
           flex
           items-center
           justify-center
           px-6
           py-8">

        {{-- Tombol Kembali --}}
        <a href="{{ route('home') }}"
            class="absolute top-8 left-8
               flex items-center gap-2
               px-4 py-2
               bg-white
               rounded-xl
               border border-gray-200
               shadow-sm
               hover:shadow-md
               hover:text-primary
               transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

            </svg>

            <span class="font-medium">

                Kembali

            </span>

        </a>

        @yield('content')

    </main>

</body>

</html>
