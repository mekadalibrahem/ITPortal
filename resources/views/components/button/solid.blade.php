@props(['type' => '' ])
@php
    switch ($type) {
        case 'danger':
        $theme =
                'bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:bg-red-600 ';
            break;
            case 'success':
        $theme =
                'bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:bg-teal-600 ';
            break;
            case 'primary':
        $theme =
                'bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 focus:outline-none focus:bg-blue-700 ';
            break;

            case 'warning':
        $theme =
                'bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-none focus:bg-yellow-600 ';
            break;
        default:
            $theme =
                'bg-white text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 ';
            break;
    }


    $basic_style= "py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border disabled:opacity-50 disabled:pointer-events-none";
    $style= "border-transparent ";
    $fall_style =$basic_style . $style . $theme
@endphp
<button {{ $attributes->merge(['type' => 'submit', 'class' => $fall_style]) }}>
    {{ $slot }}
</button>


