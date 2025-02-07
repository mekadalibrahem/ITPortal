@props([
    'status' => 'default',
    'variant' => 'filled', // 'filled', 'outline'
    'size' => 'default',   // 'sm', 'default', 'lg'
    'rounded' => 'lg',     // 'lg', 'full'
    'block' => false,
])

@php
    // Theme configuration
    $themeConfig = [
        'filled' => [
            'danger' => 'bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 border-transparent dark:bg-red-600 dark:hover:bg-red-500',
            'success' => 'bg-green-500 text-white hover:bg-green-600 focus:bg-green-600 border-transparent dark:bg-green-600 dark:hover:bg-green-500',
            'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 border-transparent dark:bg-blue-600 dark:hover:bg-blue-500',
            'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 focus:bg-yellow-600 border-transparent dark:bg-yellow-600 dark:hover:bg-yellow-500',
            'default' => 'bg-gray-50  text-gray-800 hover:bg-gray-100 focus:bg-gray-100 border-gray-300 dark:bg-neutral-700 dark:border-neutral-800 dark:text-gray-200 dark:hover:bg-neutral-600',
        ],
        'outline' => [
            'danger' => 'border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 dark:border-red-500 dark:text-red-500 dark:hover:border-red-400',
            'success' => 'border-green-500 text-green-500 hover:border-green-400 hover:text-green-400 dark:border-green-500 dark:text-green-500 dark:hover:border-green-400',
            'primary' => 'border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 dark:border-blue-500 dark:text-blue-500 dark:hover:border-blue-400',
            'warning' => 'border-yellow-500 text-yellow-500 hover:border-yellow-400 hover:text-yellow-400 dark:border-yellow-500 dark:text-yellow-500 dark:hover:border-yellow-400',
            'default' => 'border-white text-white hover:border-white/70 hover:text-white/70 dark:border-neutral-800 dark:text-gray-200 dark:hover:border-neutral-700',
        ]
    ];

    // Size configuration
    $sizeConfig = [
        'sm' => 'py-2 px-3',
        'default' => 'py-3 px-4',
        'lg' => 'p-4 sm:p-5',
    ];

    // Rounded configuration
    $roundedConfig = [
        'lg' => 'rounded-lg',
        'full' => 'rounded-full',
    ];

    // Get theme classes
    $theme = $themeConfig[$variant][$status] ?? $themeConfig[$variant]['default'];

    // Base classes
    $baseClasses = 'inline-flex items-center gap-x-2 text-sm font-medium border focus:outline-none disabled:opacity-50 disabled:pointer-events-none';

    // Combine all classes
    $classes = implode(' ', [
        $sizeConfig[$size],
        $roundedConfig[$rounded],
        $block ? 'w-full justify-center' : '',
        $baseClasses,
        $theme,
    ]);
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
