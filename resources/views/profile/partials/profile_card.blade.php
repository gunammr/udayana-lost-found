<div class="p-6 bg-white border border-gray-200 shadow-sm rounded-2xl">
    <div class="flex flex-col items-center text-center">

        {{-- Avatar: dari DB atau inisial --}}
        @if (Auth::user()->avatar_path)
            <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}"
                 class="w-20 h-20 rounded-full object-cover mb-3 border-2 border-blue-500 p-0.5"
                 alt="{{ Auth::user()->name }}">
        @else
            <div class="w-20 h-20 rounded-full mb-3 border-2 border-blue-500 p-0.5 bg-blue-100 flex items-center justify-center">
                <span class="text-2xl font-bold text-blue-600">
                    {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                </span>
            </div>
        @endif

        <h3 class="font-bold text-gray-800">{{ Auth::user()->name }}</h3>

        <span class="px-3 py-1 mt-1 text-xs text-blue-600 rounded-full bg-blue-50">
            {{ Auth::user()->program_studi ?? 'Mahasiswa' }}
        </span>
    </div>

    <div class="pt-4 mt-5 space-y-3 text-sm text-gray-500 border-t">

        {{-- Email --}}
        <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0l-9.75 6.75L2.25 6.75" />
            </svg>
            <p class="text-gray-700 break-all">{{ Auth::user()->email }}</p>
        </div>

        {{-- Telepon --}}
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75C2.25 15.586 9.414 22.75 18.25 22.75h1.5a2.25 2.25 0 002.25-2.25v-1.37a2.25 2.25 0 00-1.585-2.14l-3.02-.906a2.25 2.25 0 00-2.484.748l-.77 1.028a.75.75 0 01-.897.22 15.938 15.938 0 01-6.826-6.826.75.75 0 01.22-.897l1.028-.77a2.25 2.25 0 00.748-2.483l-.906-3.02A2.25 2.25 0 007.62 2.25H6.25A2.25 2.25 0 004 4.5v1.5" />
            </svg>
            <p class="text-gray-700">{{ Auth::user()->phone ?? '-' }}</p>
        </div>

        {{-- NIM --}}
        @if (Auth::user()->nim)
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
            </svg>
            <p class="text-gray-700">NIM: {{ Auth::user()->nim }}</p>
        </div>
        @endif

    </div>

    <a href="{{ route('profile.edit') }}"
       class="flex items-center justify-center gap-2 py-2 mt-4 text-sm font-medium text-center text-blue-600 transition rounded-lg bg-blue-50 hover:bg-blue-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
        </svg>
        Edit Profil
    </a>
</div>

<div class="grid grid-cols-2 gap-4 mt-4">
    <div class="p-4 text-center bg-white border border-gray-200 shadow-sm rounded-2xl">
        <p class="text-2xl font-bold text-gray-800">{{ $totalLaporan ?? 0 }}</p>
        <p class="mt-1 text-xs text-gray-400">LAPORAN</p>
    </div>
    <div class="p-4 text-center bg-white border border-gray-200 shadow-sm rounded-2xl">
        <p class="text-2xl font-bold text-gray-800">{{ $totalKlaim ?? 0 }}</p>
        <p class="mt-1 text-xs text-gray-400">KLAIM</p>
    </div>
</div>