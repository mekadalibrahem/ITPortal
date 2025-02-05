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
            'success' => 'bg-teal-500 text-white hover:bg-teal-600 focus:bg-teal-600 border-transparent dark:bg-teal-600 dark:hover:bg-teal-500',
            'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 border-transparent dark:bg-blue-600 dark:hover:bg-blue-500',
            'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 focus:bg-yellow-600 border-transparent dark:bg-yellow-600 dark:hover:bg-yellow-500',
            'default' => 'bg-white text-gray-800 hover:bg-gray-200 focus:bg-gray-200 border-gray-200 dark:bg-cyan-900 dark:border-cyan-700 dark:text-white dark:hover:bg-cyan-800',
        ],
        'outline' => [
            'danger' => 'border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 dark:border-red-500 dark:text-red-500 dark:hover:border-red-400',
            'success' => 'border-teal-500 text-teal-500 hover:border-teal-400 hover:text-teal-400 dark:border-teal-500 dark:text-teal-500 dark:hover:border-teal-400',
            'primary' => 'border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 dark:border-blue-500 dark:text-blue-500 dark:hover:border-blue-400',
            'warning' => 'border-yellow-500 text-yellow-500 hover:border-yellow-400 hover:text-yellow-400 dark:border-yellow-500 dark:text-yellow-500 dark:hover:border-yellow-400',
            'default' => 'border-white text-white hover:border-white/70 hover:text-white/70 dark:border-cyan-700 dark:text-cyan-300 dark:hover:border-cyan-600',
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
