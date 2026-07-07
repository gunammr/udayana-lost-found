<div class="bg-white rounded-2xl shadow-md p-6 h-[600px]">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Barang Ditemukan Terbaru
            </h2>

            <p class="text-sm text-gray-500">
                Daftar barang ditemukan terbaru
            </p>

        </div>

        <a
            href="{{ route('admin.found-items.index') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            Lihat Semua
        </a>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-3">Barang</th>
                    <th class="text-left py-3">Kategori</th>
                    <th class="text-left py-3">Lokasi</th>
                    <th class="text-left py-3">Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($recentFoundItems as $item)

                <tr class="border-b hover:bg-gray-50">

                    <td class="py-4">
                        {{ $item->item_name }}
                    </td>

                    <td>
                        {{ optional($item->categoryData)->category }}
                    </td>

                    <td>
                        {{ $item->location }}
                    </td>

                    <td>

                        @if($item->status == 'ditemukan')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Ditemukan
                            </span>

                        @elseif($item->status == 'diklaim')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Diklaim
                            </span>

                        @elseif($item->status == 'dikembalikan')

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Dikembalikan
                            </span>

                        @elseif($item->status == 'selesai')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Selesai
                            </span>

                        @else

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ ucfirst($item->status) }}
                            </span>

                        @endif

                    </td>

                </tr>

                @endforeach

                </tbody>

        </table>

    </div>

</div>