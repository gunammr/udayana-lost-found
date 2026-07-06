<div class="bg-white rounded-2xl shadow-md p-6 h-[900px]">

    <div class="flex justify-between items-center">

        <h2 class="text-xl font-bold">

            Klaim Menunggu

        </h2>

        <span
            class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm">

                {{ $pendingClaims->count() }} Baru

        </span>

    </div>

        <div class="space-y-5 mt-6">

            @forelse($pendingClaims as $claim)

            <div class="border rounded-xl p-4">

                <p class="font-semibold">
                    {{ $claim->foundItem->item_name }}
                </p>

                <p class="text-sm text-gray-500">
                    Oleh : {{ $claim->user->name }}
                </p>

                <a href="#"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-center block">

                    Review Klaim

                </a>

            </div>

        @empty

            <div class="text-center text-gray-400 py-8">

                Tidak ada klaim yang menunggu.

            </div>

        @endforelse

    </div>  

</div>