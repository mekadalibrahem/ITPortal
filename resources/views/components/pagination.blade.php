@if ($paginator->hasPages())
    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
        aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Showing
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
            </span>
            of
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $paginator->total() }}
            </span>
        </span>
        <ul class="inline-flex items-stretch -space-x-px">
            <li>
                {{-- preview button --}}
                @if ($paginator->onFirstPage())
                    <button
                        class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-300 bg-white rounded-l-lg border border-gray-500  dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 ">
                        <span class="sr-only">Previous</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                        class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
            </li>

            @foreach ($elements[0] as $index => $page)
                {{-- {{ dd($page) }} --}}

                @if ($index == $paginator->currentPage())
                    <button type="button" wire:click="goto({{ $index }})"
                        class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-primary-200 border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ">
                        {{ $index }}
                    </button>
                @endif
                @if ($index != $paginator->currentPage())
                    @if ($loop->first || $loop->last)
                        <li>
                            <button type="button" wire:click="gotoPage({{ $index }})"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                {{ $index }}
                            </button>
                        </li>
                    @else
                        @if ($index == $loop->count / 2)
                            <button type="button" wire:click="gotoPage({{ $index }})"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                {{ $index }}
                            </button>
                        @endif
                    @endif
                @endif
            @endforeach
            <li>
                @if ($paginator->onLastPage())
                    <button
                        class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-300 bg-white rounded-r-lg border border-gray-500  dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        <span class="sr-only">Next</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @else
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                        class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Next</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif

            </li>
        </ul>
    </nav>
@endif
