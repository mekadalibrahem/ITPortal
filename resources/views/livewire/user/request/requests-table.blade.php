<x-widgets.section title="{{ __('string.Current Requests') }}">
    @if ($status !== [])
        <x-alert.alert :type="$status['type']" :message="$status['message']" />
    @endif
    {{-- <div class="bg-white dark:bg-gray-800 relative  overflow-auto">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3  md:space-y-0 md:space-x-4 p-4">

           <form action="" method="GET">
            @csrf
            <x-button status="primary" type="submit">
                {{__("string.New Request")}}
            </x-button>
           </form>

        </div>
        <div class="overflow-x-auto  h-4/5 ">
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


                                <x-button.primary wire:click="index({{ $request->id }})" type="button"
                                    class="w-min">
                                    <x-svg.arrow-up />
                                </x-button.primary>
                                <x-button.danger type="button" class="w-min" wire:click="delete({{ $request->id }})"
                                    wire:confirm="{{ __('messages.confirm delete request') }}">
                                    <x-svg.trash />
                                </x-button.danger>

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
    </div> --}}

</x-widgets.section>
