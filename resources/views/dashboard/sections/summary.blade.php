<section class="mt-12">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid lg:grid-cols-3 gap-7">

            <x-dashboard-summary-card
                title="Laporan Hilang"
                value="{{ $lostItemsCount ?? 0 }}"
                subtitle="Sedang diproses"
                icon="images/search.png"
                iconBg="bg-red-100"
                valueColor="text-red-600"/>

            <x-dashboard-summary-card
                title="Laporan Ditemukan"
                value="0"
                subtitle="Menunggu klaim"
                icon="images/Ditemukan.png"
                iconBg="bg-warning"
                valueColor="text-yellow-700"/>

            <x-dashboard-summary-card
                title="Klaim Berhasil"
                value="0"
                subtitle="Barang telah kembali"
                icon="images/Berhasil.png"
                iconBg="bg-blue-100"
                valueColor="text-primary"/>

        </div>

    </div>

</section>
