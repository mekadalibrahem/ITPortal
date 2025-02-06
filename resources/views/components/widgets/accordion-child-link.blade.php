@props(['href' => '#'])

@php
$classes = ""
@endphp

<li>
    @if (url()->current() == $href)
    <a href="{{$href}}" {{ $attributes->merge(['class' => "flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-800 rounded-lg hover:bg-slate-100 focus:outline-none focus:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 dark:focus:bg-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-700" ]) }}>
        {{ $slot }}
    </a>
    @else
    <a href="{{$href}}" {{ $attributes->merge(['class' => "flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-800 rounded-lg hover:bg-slate-100 focus:outline-none focus:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 dark:focus:bg-slate-700 dark:text-slate-200 " ]) }}>
        {{ $slot }}
    </a>
    @endif


</li>
