@props([

'title',
'id' => null,
'active' => false,
'icon' => '',
])

@php

$id = $id ?? "id-" . time() ;

$childId = $id ."-child" ;
@endphp

<li class="hs-accordion" id="{{ $id }}">
    <button type="button"
        class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-800 rounded-lg hover:bg-slate-100 focus:outline-none focus:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700  dark:focus:bg-slate-700 dark:text-slate-200"
        aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="{{ $childId }}">
        @if ($icon)
            {{ $icon }}
        @endif
        {{ $title }}

        <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="m18 15-6-6-6 6" />
        </svg>

        <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div id="{{ $childId }}" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
        role="region" aria-labelledby="{{ $id }}">
        <ul class="ps-8 pt-1 space-y-1">
            {{ $slot }}
        </ul>
    </div>
</li>
