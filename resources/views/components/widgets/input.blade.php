@props(['label', 'id', 'type'])
<div>
    <label for="{{ $id }}" class="block text-sm font-medium mb-2 dark:text-white">
        {{ $label }}
    </label>

    @if ($errors->has($id))
        <div class="relative">
            <input type="text" id="{{ $id }}" name="{{ $id }}"
                aria-describedby="{{ $id }}-helper"
                {{ $attributes->merge(['class' => 'py-2.5 sm:py-3 px-4 block rounded-lg sm:text-sm w-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 border border-red-400 focus:border-red-600 focus:ring-red-600']) }}>
            @error($id)
                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                    <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" x2="12" y1="8" y2="12"></line>
                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-red-600 mt-2" id="{{ $id }}-helper">{{ $message }}</p>
        @enderror
    @else
        <div class="relative">
            <input type="text" id="{{ $id }}" name="{{ $id }}"
                aria-describedby="{{ $id }}-helper"
                {{ $attributes->merge(['class' => 'py-2.5 sm:py-3 px-4 block rounded-lg sm:text-sm w-full border-gray-300 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400']) }}>
        </div>
    @endif

</div>



{{--
@props(['label', 'id', 'type' => 'text', 'wire' => ''])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium mb-2 dark:text-white">
        {{ $label }}
    </label>

    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $id }}"
            {{$wire}}
            {{ $attributes->merge(['class' => 'py-2.5 sm:py-3 px-4 block w-full rounded-lg sm:text-sm dark:bg-neutral-800  dark:text-neutral-400' . ($errors->has($id) ? 'border border-red-400 focus:border-red-600 focus:ring-red-600' : ' border-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700')]) }}

            aria-describedby="{{ $id }}-helper">

        @error($id)
            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" x2="12" y1="8" y2="12"></line>
                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                </svg>
            </div>
        @enderror
    </div>

    @error($id)
        <p class="text-sm text-red-600 mt-2" id="{{ $id }}-helper">{{ $message }}</p>
    @else
        @if ($slot->isNotEmpty())
            <p class="text-sm text-gray-500 mt-2" id="{{ $id }}-helper">{{ $slot }}</p>
        @endif
    @enderror
</div> --}}
