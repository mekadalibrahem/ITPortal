@php
    $route_list = $route_list ?? config('breadcrumbs');
    $paths = $route_list['paths'] ?? [];
    $path = $paths[Route::currentRouteName()] ?? null;

    if (!$path) {
        return;
    }

    $segments = explode('.', $path);
    $breadcrumbs = [];
    $currentLevel = [];

    // Determine user role configuration
    if (auth()->user()->hasRole('admin')) {
        $currentLevel = $route_list['admin'] ?? [];
    } elseif (auth()->user()->hasRole('employee')) {
        $currentLevel = $route_list['employee'] ?? [];
    }
    if (!function_exists('buildBreadcrumbs')) {
        // Define the function if it does not exist

        // Recursive function to build breadcrumbs
        function buildBreadcrumbs($segments, $currentLevel, &$breadcrumbs)
        {
            foreach ($segments as $segment) {
                if (!isset($currentLevel[$segment])) {
                    break;
                }

                $item = $currentLevel[$segment];
                $breadcrumbs[] = [
                    'name' => trans($item['name'] ?? ''),
                    'url' => isset($item['route']) && Route::has($item['route']) ? route($item['route']) : null,
                    'children' => $item['children'] ?? [],
                ];

                if (!empty($item['children'])) {
                    $currentLevel = $item['children'];
                }
            }
        }
    }

    buildBreadcrumbs($segments, $currentLevel, $breadcrumbs);

@endphp

@if (!empty($breadcrumbs))
    <ol class="ms-3 flex items-center whitespace-nowrap mb-4">
        @foreach ($breadcrumbs as $crumb)
            <li class="flex items-center text-sm text-gray-800 dark:text-gray-50">
                @if (!empty($crumb['children']))
                    {{-- Parent with dropdown --}}
                    <div x-data="{ open: false }" class="relative" @mouseover="open = true" @mouseleave="open = false">
                        <button type="button" class="hover:text-gray-900 dark:hover:text-gray-300 transition-colors">
                            {{ $crumb['name'] }}
                            @if (!empty($crumb['children']))
                                <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </button>

                        {{-- Main dropdown menu --}}
                        <div x-show="open" x-cloak x-transition
                            class="absolute {{ __('string.lang direction') == 'rtl' ? 'right-0' : 'left-0' }} mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-10">
                            @foreach ($crumb['children'] as $child)
                                <div class="relative" x-data="{ subOpen: false }" @mouseover="subOpen = true"
                                    @mouseleave="subOpen = false">
                                    @if (!empty($child['children']))
                                        {{-- Item with submenu --}}
                                        <div class="flex justify-between items-center">
                                            <span class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">
                                                {{ trans($child['name']) }}
                                            </span>
                                            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>

                                        {{-- Submenu --}}
                                        <div x-show="subOpen" x-cloak x-transition
                                            class="absolute top-0 {{ __('string.lang direction') == 'rtl' ? 'right-full' : 'left-full' }} w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1">
                                            @foreach ($child['children'] as $subChild)
                                                @if (Route::has($subChild['route'] ?? ''))
                                                    <a href="{{ route($subChild['route']) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        {{ trans($subChild['name']) }}
                                                    </a>
                                                @else
                                                    <span
                                                        class="block px-4 py-2 text-sm text-gray-400 dark:text-gray-500">
                                                        {{ trans($subChild['name']) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        {{-- Regular dropdown item --}}
                                        @if (Route::has($child['route'] ?? ''))
                                            <a href="{{ route($child['route']) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                {{ trans($child['name']) }}
                                            </a>
                                        @else
                                            <span class="block px-4 py-2 text-sm text-gray-400 dark:text-gray-500">
                                                {{ trans($child['name']) }}
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($crumb['url'])
                    {{-- Regular Link --}}
                    <a href="{{ $crumb['url'] }}"
                        class="hover:text-gray-900 dark:hover:text-gray-300 transition-colors">
                        {{ $crumb['name'] }}
                    </a>
                @else
                    {{-- Current Page --}}
                    <span class="text-sm font-semibold text-gray-700 truncate dark:text-gray-100">
                        {{ $crumb['name'] }}
                    </span>
                @endif

                {{-- Separator --}}
                @if (!$loop->last)
                    @if (trans('string.lang direction') == 'rtl')
                        <x-svg.arrow-right
                            class="shrink-0 mx-3 overflow-visible size-2.5 text-slate-400 dark:text-slate-500" />
                    @else
                        <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-slate-400 dark:text-slate-500"
                            width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    @endif
                @endif
            </li>
        @endforeach
    </ol>
@endif
