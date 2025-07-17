@props(['show' => false , 'class' => ''])

<div {{ $attributes->merge(['class' => ($show ? '' : 'hidden') . ' p-4 bg-gray-50 flex flex-col border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700 ' . $class]) }}>
    {{ $slot }}
</div>
