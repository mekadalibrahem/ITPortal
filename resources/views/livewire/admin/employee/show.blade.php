<div class="  mb-4 m-10 sm:p-1 sm:m-1">
    <section class="pt-4 mb-4 sm:p-1 sm:m-1 ">




        <!-- جدول  الطلبات المتوفرة  -->
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-1 sm:m-1  ">
            <div class="mx-auto max-w-screen-xl  sm:p-1 sm:m-1 ">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-auto">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <!-- search div option -->
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <select type="text"
                                    class="basis-1/2 me-2 px-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="1" selected>
                                        اختر طريقة البحث
                                    </option>
                                    <option value="2">
                                        الرقم الوطني
                                    </option>
                                    <option value="3">
                                        الاسم
                                    </option>


                                </select>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3 "> {{ __('string.SSN') }}</th>

                                    <th scope="col" class="px-4 py-3  ">{{ __('string.Name') }} </th>
                                    <th scope="col" class="px-4 py-3  ">{{ __('string.email') }} </th>
                                    <th scope="col" class="px-4 py-3  "> {{ __('string.Department') }} </th>
                                    <th scope="col" class="px-4 py-3  "> {{ __('string.Options') }} </th>

                                </tr>
                            </thead>
                            <tbody>

                                @if ($employees)
                                    @forelse ($employees as $emp)
                                        <tr class="border-b dark:border-gray-700" wire:key="{{ $emp->id }}">
                                            <td
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $emp->id }}
                                            </td>
                                            <td
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $emp->user->fullname() }}
                                            </td>
                                            <td
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $emp->user->email }}
                                            </td>
                                            <td
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                                {{ $emp->dep_name() ?? __('string.Dont has Department yet') }}

                                            </td>

                                            <td
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                                <button type="button" wire:click="delete({{$emp->id}})"
                                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                                    <x-svg.trash />
                                                </button>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="border-b dark:border-gray-700">
                                            <td colspan="4"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{__("message.Dont have any Employee")}}
                                            </td>
                                    @endforelse
                                @endif





                            </tbody>
                        </table>
                    </div>
                    {{ $employees->links('components.pagination') }}
                </div>
            </div>
        </section>





    </section>

</div>
