@props([
    'title',
    'icon',
    'href' => '#',
])

<a href="{{ $href }}"
    class="group bg-white rounded-3xl border border-gray-100 shadow-card
           hover:shadow-xl hover:-translate-y-1 transition duration-300
           p-8 flex flex-col items-center justify-center text-center h-56">

    <div
        class="w-16 h-16 rounded-full bg-blue-50
               flex items-center justify-center
               group-hover:bg-primary transition">

        <img
            src="{{ asset($icon) }}"
            class="w-8 h-8 group-hover:brightness-0 group-hover:invert">

    </div>

    <h3
        class="mt-8 font-semibold text-lg text-primary-dark">

        {{ $title }}

    </h3>

</a>