<x-widgets.section title=" ">

    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-auto mb-8">
        <div
            class="overflow-x-auto  space-y-3 md:space-y-0 md:space-x-4 p-4">

            <div class="sm:col-span-2 mb-3 flex flex-row ">
                <label for="new_employee" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('string.Employees') }}
                </label>
                <select type="text" name="new_employee" id="new_employee" wire:model="new_employee"
                    class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0">
                        {{ __('string.Select Employee') }}
                    </option>
                    @forelse ($allowed_employees as $emp)
                        <option value="{{ $emp->id }}">
                            {{ $emp->user->fullname() }}
                        </option>


                    @empty
                    @endforelse
                </select>
            </div>

            <div class="sm:col-span-2 mb-3">

                <x-button status="primary" type="button" wire:click="insert()">
                    {{ __('string.Add') }}

                </x-button>
            </div>

        </div>
    </div>


    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-auto">



        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

            <div class="flex items-center flex-1 space-x-4">
                <h5>
                    <span class="text-gray-500 me-8"> {{ __('string.Department') }} </span>
                    <span class="dark:text-white"> {{ $this->department->name ?? '' }}</span>
                </h5>

            </div>


        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 ">

                            {{ __('string.employee') }}
                        </th>
                        <th scope="col" class="px-4 py-3 "> {{ __('string.Role') }}</th>

                        <th scope="col" class="px-4 py-3  "> {{ __('string.Options') }}</th>

                    </tr>
                </thead>
                <tbody>

                    @if ($employees)
                        @forelse ($employees as $emp)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $emp->user->fullname() }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                    @if ($emp->is_manager())
                                        {{ __('string.Manager') }}
                                    @else
                                        {{ __('string.employee') }}
                                    @endif


                                </td>

                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                    <button type="button" wire:click="delete({{ $emp->id }})"
                                        wire:confirm="{{ __('messages.confirm delete employee form department') }}"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        <x-svg.trash />
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="3"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ __('string.dont have any employee in department') }}

                                </td>
                            </tr>
                        @endforelse
                    @endif




                </tbody>
            </table>
        </div>

    </div>

</x-widgets.section>
