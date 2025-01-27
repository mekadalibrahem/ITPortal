
    {{--  show numbersss --}}
    @if ($paginator->hasPages())
        <nav role="navigation"
            class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                aria-label="Table navigation">



                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    عرض
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->lastItem() }}</span>
                    من
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
                </span>



            <ul class="inline-flex items-stretch -space-x-px">
                <li>
                    {{-- pervios button --}}

                    @if ($paginator->onFirstPage())
                        <span class="flex items-center justify-center h-full py-1.5 px-3 ml-2 text-gray-500 bg-white  border   rounded-r-lg border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="">السابق</span>



                        </span>
                    @else
                        <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                        class="flex items-center justify-center h-full py-1.5 px-3 ml-2 text-gray-500 bg-white  border  rounded-r-lg border-gray-300 hover:bg-gray-300  dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">

                        <span class="">السابق</span>

                    </button>
                    @endif

                </li>

                @foreach ($elements as  $element)

                    @if (is_string($element))
                        <li>

                                <a wire:click="gotoPage({{$page}})"
                                class="flex items-center justify-center text-sm py-2 px-3  ml-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                {{ $element }}
                            </a>
                        </li>


                    @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page  == $paginator->currentPage())
                                    {{--  current page  --}}
                                    <li>

                                            <a  wire:click="gotoPage({{$page}})"
                                            class="flex items-center justify-center text-sm z-10 py-2  ml-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @else
                                    <li>

                                        <a  wire:click="gotoPage({{$page}})"
                                            class="flex items-center justify-center text-sm py-2 px-3  ml-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                        @endif

                @endforeach


                    {{-- next button --}}
                    @if ($paginator->hasMorePages())

                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                    class="flex items-center justify-center h-full py-1.5 px-3  ml-2 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="">التالي</span>

                    </button>

                @else
                    <button
                    class="flex items-center justify-center h-full py-1.5 px-3   ml-2leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="">التالي</span>
                    </button>

                @endif
                </li>
            </ul>

        </nav>
    @endif




