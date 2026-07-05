<div
    class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition duration-300">

    <div class="flex justify-between items-start">

        <div>

            <p class="text-sm text-gray-500 font-medium">
                {{ $title }}
            </p>

            <h2 class="text-4xl font-bold text-gray-800 mt-2">
                {{ $value }}
            </h2>

            <p class="text-sm text-green-500 mt-4">
                {{ $description }}
            </p>

        </div>

        <div
            class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

            <img
                src="{{ asset($icon) }}"
                class="w-7 h-7"
                alt="icon">

        </div>

    </div>

</div>