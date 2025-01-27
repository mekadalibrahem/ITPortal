<section class="bg-white  h-full  rounded-lg overflow-auto  dark:bg-gray-900">
    <div class=" px-4 py-8 mx-auto  md:mx-0 md:w-full">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __('string.Current Requests') }}</h2>
        @if ($status !== [])
            <x-alert.alert :type="$status['type']" :message="$status['message']" />
        @endif
        <div class="bg-white  dark:bg-gray-800 relative  overflow-auto">
            <div class="flex h-full flex-col md:flex-row items-center justify-between space-y-3  md:space-y-0 md:space-x-4 p-4">
                {{-- search div option --}}

                {{-- <div class="w-full md:w-1/2">
                    <x-search wire="#" />
                </div> --}}

                <x-dropdown id="filtter_status_dropdown" text="{{__('string.Status')}}">
                    <x-dropdown-item>
                        <x-form.checkbox id="status_all" name="status_all" value="all" wire:change="status_fillter()"
                            wire:model="request_status_fillter" />
                        <x-form.label for="status_all" class="ms-2 mb-0">
                            {{__("string.Sellect all")}}
                        </x-form.label>
                    </x-dropdown-item>
                    @foreach ($all_request_status as $status)
                        {{-- @dd($status->value) --}}
                        <x-dropdown-item>
                            <x-form.checkbox id="{{ $status->value }}" name="{{ $status->value }}"
                                value="{{ $status->value }}" wire:change="status_fillter()"
                                wire:model="request_status_fillter" />
                            <x-form.label for="{{ $status->value }}" class="ms-2 mb-0">
                                @php
                                    $va = $status->value;
                                @endphp
                                {{ __("request_status.$va") }}
                            </x-form.label>
                        </x-dropdown-item>
                    @endforeach
                </x-dropdown>

            </div>
            <div class="overflow-x-auto">
                <table class="w-full  text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3 ">
                                {{ __('string.Name') }}
                            </th>
                            <th scope="col" class="px-4 py-3 ">
                                {{ __('string.Type') }}
                            </th>

                            <th scope="col" class="px-4 py-3 ">
                                {{ __('string.Status') }}
                            </th>
                            <th scope="col" class="px-4 py-3  ">
                                {{ __('string.Options') }}
                            </th>



                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($requests as $request)

                            <tr class="border-b dark:border-gray-700" wire:key="{{ $request->id }}">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $request->requests->name }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $request->requests->type->type }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ __("request_status.$request->status") }}
                                </td>

                                <td class="px-4 py-3 flex flex-row md:justify-center gap-2">
                                    {{--
                                        <button type="button"
                                        class="inline-flex items-center px-5 py-2.5  text-sm font-medium  text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800"
                                        onclick="showDocument()">
                                        عرض
                                        </button>
                                            <button type="button"
                                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900"
                                                onclick="togglePopup()">
                                                توجيه
                                        </button>
                                --}}
                                    <x-button.primary wire:click="index({{ $request->id }})" type="button"
                                        class="w-min">
                                        <x-svg.arrow-up />
                                    </x-button.primary>


                                </td>

                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    colspan="4">

                                    {{ __('text.Empty request list') }}
                                </td>
                            </tr>
                        @endforelse




                    </tbody>
                </table>
            </div>

            {{ $requests->links('components.pagination') }}
        </div>
    </div>
</section>
