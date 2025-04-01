

<x-widgets.section title="{{ __('string.Edit Role') }}">
    <form wire:submit="update">
        @csrf
        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
            <div class="sm:col-span-2">
                <x-widgets.input label="{{ __('string.Name') }}" type='text' id='name' wire:model='name' />
            </div>

            <div class=" flex  items-center  space-x-4">
                <x-button status='primary' type="submit" class="w-auto">
                    {{ __('string.Save') }}
                </x-button>

            </div>
        </div>

    </form>
    @if ($status_permission !== [])
        <x-alert.alert :type="$status_permission['type']" :message="$status_permission['message']" />
    @endif
    <form wire:submit="new_permission">
        @csrf
        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
            <div class="sm:col-span-2">

                <x-form.label for="add_permission" value='{{ __('string.Add permission for this role') }}' />
                <select type='text' id="add_permission" name='add_permission' wire:model='add_permission'
                    class = 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'>
                    <option value=""> {{ __('string.Select permission') }} </option>
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->id }}">
                            {{ $permission->name }}
                        </option>
                    @endforeach

                </select>
                @error('add_permission')
                    <x-alert.alert type="danger" :message="$message" />
                @enderror
            </div>

            <div class=" flex align-middle items-center  space-x-4">
                <x-button status="primary" type="submit" class="w-auto">

                    {{ __('string.Save') }}
                </x-button>

            </div>
        </div>

                </form>
                <div class="gird grid-flow-col auto-cols-max">
                    @foreach ($role_permissions as $role_permission)
                        <span id="badge-dismiss-default"
                            class="inline-flex items-center px-2 py-1 me-2 mt-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{ $role_permission->name }}
                            <button type="button" wire:click="remove_permission('{{ $role_permission->name }}')"
                                class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300"
                                data-dismiss-target="#badge-dismiss-default" aria-label="Remove">
                                <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Remove badge</span>
                            </button>
                        </span>
                    @endforeach

    </div>

</x-widgets.section>
