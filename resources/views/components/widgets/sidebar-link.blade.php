@props(['href' => "#"])
<li>
    <a href="{{$href}}" {{ $attributes->class([
        "flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-800 rounded-lg hover:bg-slate-100
        focus:outline-none focus:bg-slate-100 dark:text-white dark:hover:bg-slate-700 dark:focus:bg-slate-700" ,
        'bg-slate-100 dark:bg-slate-700' => url()->current() === $href])
        }}
        >
        {{$slot}}
    </a>
</li>
