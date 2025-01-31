@props([ "href"])
<a href="{{$href}}" {{ $attributes->class([
    'p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
    'bg-gray-100 dark:bg-neutral-700' => url()->current() === $href

]) }}>
{{
    $slot
}}
</a>

