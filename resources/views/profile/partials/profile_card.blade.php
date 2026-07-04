<div class="p-6 bg-white border border-gray-200 shadow-sm rounded-2xl">
    <div class="flex flex-col items-center text-center">
        <img src="{{ Auth::user()->avatar_path ? asset('storage/' . Auth::user()->avatar_path) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=200' }}"
             class="w-20 h-20 rounded-full object-cover mb-3 border-2 border-primary p-0.5">

        <h3 class="font-bold text-gray-800">{{ Auth::user()->name }}</h3>

        <span class="px-3 py-1 mt-1 text-xs text-blue-600 rounded-full bg-blue-50">
            {{ Auth::user()->program_studi ?? 'Mahasiswa' }}
        </span>
    </div>

    <div class="pt-4 mt-5 space-y-2 text-sm text-gray-500 border-t">
        <div class="flex items-center gap-2">
            <span>✉️</span>
            <p class="text-gray-700 break-all">{{ Auth::user()->email }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span>📞</span>
            <p class="text-gray-700">{{ Auth::user()->phone ?? '-' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span>🪪</span>
            <p class="text-gray-700">NIM: {{ Auth::user()->nim ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('profile.edit') }}"
       class="block py-2 mt-4 text-sm font-medium text-center text-blue-600 transition rounded-lg bg-blue-50 hover:bg-blue-100">
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