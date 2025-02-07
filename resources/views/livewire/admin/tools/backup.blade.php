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
            <x-button status="primary" class="w-auto" type="buttom" wire:click="store()">
                Add new Backup
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
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
