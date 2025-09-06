<x-widgets.section title="{{ __('string.Backups') }}">




    @if (session()->has('status'))
        @php
            $status = session()->get('status');
        @endphp
        <x-alert.alert :type="$status['type']" :message="$status['message']" />
    @endif

    <!-- Table Container with Overflow-X -->
    <div class="overflow-y-auto">
        <div class="grid grid-cols-6  space-y-3  md:space-y-0 md:space-x-4 p-4 ">
            <x-button status="primary" class="flex flex-row justify-between items-center space-x-2" type="button"
                wire:click="store" wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-wait">

                <span wire:loading.remove>Add new Backup</span>


                <span wire:loading>Saving Backup...</span>


                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                    class="w-5 h-5 text-white animate-spin" wire:loading wire:target="store" style="display: none;">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                </svg>
            </x-button>
        </div>
        <table class="min-w-full overflow-y-auto text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3"> {{ __('string.Name') }}</th>
                    <th scope="col" class="px-6 py-3"> {{ __('string.Options') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($files as $file)
                    <tr wire:key=" {{ $file }}"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->iteration }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $file }}
                        </td>
                        @php
                            $name = $file;
                        @endphp
                        <td class="px-6 py-4 text-center flex flex-row gap-1">
                            <x-button status="primary" type="button" wire:click="download('{{ $file }}')">
                                <x-svg.download />
                            </x-button>
                            <x-button status="danger" type="button" wire:click="delete('{{ $file }}')"
                                wire:confirm="{{ __('messages.confirm delete request') }}">
                                <x-svg.trash />
                            </x-button>

                        </td>
                    </tr>

                @empty
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th colspan="3"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            {{ __('No Backups Available') }}
                        </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-widgets.section>
