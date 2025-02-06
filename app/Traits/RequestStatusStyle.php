<?php

namespace App\Traits;


trait RequestStatusStyle
{
    protected $statusColors = [
        'draft' => [
            'light' => 'bg-neutral-500 text-white', // Light mode: Gray background with white text
            'dark' => 'dark:bg-neutral-700 dark:text-gray-200', // Dark mode: Dark gray background with light gray text
        ],
        'checking' => [
            'light' => 'bg-orange-500 text-white',
            'dark' => 'dark:bg-orange-700 dark:text-gray-200',
        ],
        'deleted' => [
            'light' => 'bg-red-500 text-white',
            'dark' => 'dark:bg-red-700 dark:text-gray-200',
        ],
        'wating' => [
            'light' => 'bg-yellow-500 text-black', // Yellow background with black text for contrast
            'dark' => 'dark:bg-yellow-700 dark:text-gray-200',
        ],
        'timeout' => [
            'light' => 'bg-orange-700 text-white',
            'dark' => 'dark:bg-orange-900 dark:text-gray-200',
        ],
        'working' => [
            'light' => 'bg-blue-500 text-white',
            'dark' => 'dark:bg-blue-800 dark:text-gray-200',
        ],
        'rejected' => [
            'light' => 'bg-red-600 text-white',
            'dark' => 'dark:bg-red-800 dark:text-gray-200',
        ],
        'end_rejected' => [
            'light' => 'bg-red-700 text-white',
            'dark' => 'dark:bg-red-900 dark:text-gray-200',
        ],
        'accept' => [
            'light' => 'bg-green-500 text-white',
            'dark' => 'dark:bg-green-700 dark:text-gray-200',
        ],
        'under delivery' => [
            'light' => 'bg-blue-500 text-white',
            'dark' => 'dark:bg-blue-700 dark:text-gray-200',
        ],
        'delevered' => [
            'light' => 'bg-green-600 text-white',
            'dark' => 'dark:bg-green-800 dark:text-gray-200',
        ],
    ];

    public function getStatusStyle($status){
          // Get the corresponding light and dark mode styles for the status

          $styles = $this->statusColors[$status] ?? [
            'light' => 'bg-stone-300 text-black', // Default light mode style
            'dark' => 'dark:bg-stone-700 dark:text-gray-200', // Default dark mode style
        ];

        // Combine light and dark mode styles
         return " " . $styles['light'] . ' ' . $styles['dark'] . ' ' ;
    }

}
