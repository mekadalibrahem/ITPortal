@props(['label', 'id', 'type' => 'file', 'divstyle' => ''])
<div class=" mb-4 {{ $divstyle }} ">

  


    <label for="{{ $id }}" class="block p-2 ">
        <span class="sr-only">{{ $label }}</span>

        @if ($errors->has($id))
            <div class="relative">
                <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}"
                    aria-describedby="{{ $id }}-helper"
                    {{ $attributes->merge([
                        'class' => 'block w-full text-sm text-gray-500
                            file:me-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-red-600 file:text-white
                            hover:file:bg-red-700
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:text-neutral-500
                            dark:file:bg-red-500
                            dark:hover:file:bg-red-400',
                    ]) }}>
                @error($id)
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
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
                <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}"
                    aria-describedby="{{ $id }}-helper"
                    {{ $attributes->merge([
                        'class' => 'block w-full text-sm text-gray-500
                            file:me-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:text-neutral-500
                            dark:file:bg-blue-500
                            dark:hover:file:bg-blue-400',
                    ]) }}>
            </div>
        @endif
    </label>


</div>

