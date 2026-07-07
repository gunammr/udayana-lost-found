<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F6F8FC]">

    {{-- Sidebar --}}
    @include('components.admin-sidebar')

    {{-- Content --}}
    <div class="ml-64 min-h-screen flex flex-col">

        {{-- Navbar --}}
        @include('components.admin-navbar')

        {{-- Main --}}
        <main class="p-8">

            @yield('content')

        </main>

    </div>

</body>

</html>