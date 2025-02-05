@props([ "href"])
<a href="{{$href}}" {{ $attributes->class([
    'p-2 flex items-center text-sm text-slate-800 hover:bg-slate-100 rounded-lg focus:outline-none focus:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700 dark:focus:bg-slate-700',
    'bg-slate-100 dark:bg-slate-700' => url()->current() === $href

]) }}>
{{
    $slot
}}
</a>

