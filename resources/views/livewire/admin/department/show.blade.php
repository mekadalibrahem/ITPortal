<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class=" max-w-screen-xl ">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-auto">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <!-- search div option -->
                {{-- <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search" required="">
                        </div>
                    </form>
                </div> --}}
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3 ">
                                {{ __('string.Name') }}
                            </th>
                            <th scope="col" class="px-4 py-3 ">
                                {{ __('string.description') }}
                            </th>
                            <th scope="col" class="px-4 py-3  ">
                                {{ __('string.department manager') }}
                            </th>
                            <th scope="col" class="px-4 py-3  "> {{ __('string.Options') }} </th>

                        </tr>
                    </thead>
                    <tbody>


                        {{-- @dd($departments) --}}
                        @forelse ($departments as $dep)
                            <tr class="border-b dark:border-gray-700" wire:key="{{ $dep->id }}">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $dep->name }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $dep->description }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $dep->get_user_manager() ?  $dep->get_user_manager()->fullname() : __('string.Dont has Manager') }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <button type="button" wire:click="index({{$dep->id}})"
                                        class="inline-flex items-center px-5 py-2.5  text-sm font-medium  text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                        <x-svg.arrow-up />
                                    </button>
                                    <button type="button" wire:click="delete({{$dep->id}})" wire:confirm="{{__('messages.confirm delete department')}}"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        <x-svg.trash />
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ __('string.Dont have any Department') }}
                                </td>
                            </tr>
                        @endforelse



                    </tbody>
                </table>
            </div>
            {{ $departments->links('components.pagination') }}
        </div>
    </div>
</section>
