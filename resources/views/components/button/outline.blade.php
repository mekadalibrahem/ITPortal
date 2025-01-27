@props(['type' => '' ])
@php
    switch ($type) {
        case 'danger':
        $theme =
                'border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 focus:outline-none focus:border-red-400 focus:text-red-400 ';
            break;
            case 'success':
        $theme =
                'border-teal-500 text-teal-500 hover:border-teal-400 hover:text-teal-400 focus:outline-none focus:border-teal-400 focus:text-teal-400 ';
            break;
            case 'primary':
        $theme =
                'border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none focus:border-blue-500 focus:text-blue-500  dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400';
            break;

            case 'warning':
        $theme =
                'border-yellow-500 text-yellow-500 hover:border-yellow-400 focus:outline-none focus:border-yellow-400 focus:text-yellow-400 ';
            break;
        default:
            $theme =
                'border-white text-white hover:border-white/70 hover:text-white/70 focus:outline-none focus:border-white/70 focus:text-white/70';
            break;
    }


    $basic_style= "py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border disabled:opacity-50 disabled:pointer-events-none";
    $style= "border-transparent ";
    $fall_style =$basic_style . $style . $theme
@endphp
<button {{ $attributes->merge(['type' => 'submit', 'class' => $fall_style]) }}>
    {{ $slot }}
</button>



