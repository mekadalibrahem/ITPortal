<div>

    @switch($type)
        @case('info')
            <div class="p-1  text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                 {{ $message }}
            </div>
        @break

        @case('danger')
            <div class="p-1 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
               {{ $message }}
            </div>
        @break

        @case('success')
            <div class="p-1 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                 {{ $message }}
            </div>
        @break

        @case('warning')
            <div class="p-1  text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
               {{ $message }}
            </div>
        @break

        @case('dark')
            <div class="p-1 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
                {{ $message }}
            </div>
        @break

        @default

    @endswitch






</div>
