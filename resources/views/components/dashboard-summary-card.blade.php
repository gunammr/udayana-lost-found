@props([
    'title',
    'value',
    'subtitle',
    'icon',
    'iconBg' => 'bg-blue-100',
    'iconColor' => 'text-primary',
    'valueColor' => 'text-primary',
    'href' => null,
])

@if($href)
    <a href="{{ $href }}" class="block">
@endif

<div class="bg-white rounded-3xl shadow-card p-7 hover:-translate-y-1 transition duration-300">

    <div class="flex justify-between items-start">

        <div>

            <h3 class="text-[24px] font-bold text-primary-dark">

                {{ $title }}

            </h3>

        </div>

        <div class="w-12 h-12 rounded-full {{ $iconBg }} flex items-center justify-center">

            <img
                src="{{ asset($icon) }}"
                class="w-6">

        </div>

    </div>

    <div class="mt-8 flex items-end gap-3">

        <h2 class="text-6xl font-bold {{ $valueColor }}">

            {{ $value }}

        </h2>

        <span class="mb-2 text-body">

            Laporan

        </span>

    </div>

    <div class="mt-6 border-t pt-5">

        <p class="text-body">

            {{ $subtitle }}

        </p>

    </div>

</div>

@if($href)
    </a>
@endif