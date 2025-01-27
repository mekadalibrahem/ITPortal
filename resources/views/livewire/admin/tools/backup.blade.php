<section class="bg-white container shadow-md mx-auto md:w-5/5 lg:w-4/5 mt-8 rounded-lg dark:bg-gray-900">
    <div class="max-w-2xl px-4 py-8 mx-auto">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white"> {{ __('string.Backups') }} </h2>

        @if (session()->has('status'))
            @php
                $status = session()->get('status');
            @endphp
            <x-alert.alert :type="$status['type']" :message="$status['message']" />
        @endif

        <!-- Table Container with Overflow-X -->
        <div class="overflow-y-auto">
            {{-- <div class="grid grid-cols-3  space-y-3  md:space-y-0 md:space-x-4 p-4 "  >
                <x-button.primary class="w-auto"
                    type="buttom" wire:click="store()"
                >
                Add new Backup
                </x-button.primary>
            </div> --}}
            <table
                class="min-w-full overflow-y-auto text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
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
                                <x-button.primary type="button" class="w-min "
                                    wire:click="download('{{ $file }}')">
                                    <x-svg.download class="" />
                                </x-button.primary>
                                <x-button.danger type="button" class="w-min"
                                    wire:click="delete('{{ $file }}')"
                                    wire:confirm="{{ __('messages.confirm delete request') }}">
                                    <x-svg.trash />
                                </x-button.danger>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <th colspan="3"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                {{ __('No Backups Available') }}
                            </th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>
