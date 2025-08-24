@props(['header'])

<div class="flex flex-wrap justify-between items-center gap-2">
    <div>

        <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
            {{ $header ?? ' ' }}
        </p>
    </div>


</div>
