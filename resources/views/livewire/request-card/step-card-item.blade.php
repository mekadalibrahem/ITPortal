<div class="flex flex-col items-center px-4 relative">


    <!-- Info content (top) -->
    <div class="mb-2 p-2 flex-row  items-center justify-items-center rounded-lg shadow-xs">
        <h3 class="flex gap-x-1.5 font-semibold text-gray-900 dark:text-white text-sm">

            {{ $title }}
        </h3>
        <div class="mt-1 -ms-1 p-1 inline-flex   items-center gap-x-2 text-xs  text-gray-100   ">

            {{ $note ?? ' ' }}
        </div>
    </div>
    {{-- @if ($connector)
    <!-- Connector line (before each item except the first) -->
    <div class="absolute -start-1/3 top-2/3 h-px w-full bg-gray-200 dark:bg-neutral-500  z-0"></div>
    @endif --}}
    <!-- Dot indicator -->

    @if ($status == 'not_working')
        <div class="size-6 rounded-full bg-gray-400 dark:bg-neutral-600 mb-2">
            <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
              </svg>
              
        </div>
    @elseif ($status == 'working')
        {{-- <div class="size-6 rounded-full bg-yellow-400 dark:bg-yellow-600 mb-2"></div> --}}
        <div class="relative size-6 rounded-full bg-blue-100 dark:bg-blue-900 mb-2">
            <svg class="w-6 h-6 animate-spin border-t-transparent " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z"/>
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
              </svg>
              
          
        </div>
    @elseif ($status == 'done')
        <div class="size-6 rounded-full bg-green-400 dark:bg-green-600 mb-2">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
              </svg>
              
              
           

        </div>
    @elseif ($status == 'rejected')
        <div class="size-6 rounded-full bg-red-400 dark:bg-red-600 mb-2">
            <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
              </svg>
              

        </div>
    @endif

    <!-- Time (bottom) -->
    <div class="text-xs text-gray-500 dark:text-neutral-100">{{ $time }}</div>
</div>
