<section class="pt-14">

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex justify-between items-center">

            <div>

                <h1
                    class="text-5xl font-bold text-primary-dark">

                    Selamat Datang,
                    {{ Auth::user()->name }}!

                </h1>

                <p
                    class="mt-4 text-lg text-body">

                    Berikut adalah ringkasan aktivitas
                    dan laporan Anda di lingkungan
                    Universitas Udayana.

                </p>

            </div>

            <a href="#"

                class="bg-primary
                       hover:bg-primary-hover
                       transition
                       px-7
                       py-4
                       rounded-2xl
                       text-white
                       font-semibold">

                + Buat Laporan Baru

            </a>

        </div>

    </div>

</section>