<x-widgets.section title="{{ __('string.edit department') }}">
    <x-widgets.input id="name" name="name" label="{{ __('string.Name') }}" wire:model='name' />

    <x-widgets.input id="description" name="description" label="{{ __('string.description') }}" wire:model='description' />




    <div class="sm:col-span-2 mb-3 flex flex-row ">
        <label for="manager_id" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('string.department manager') }}
        </label>
        <select type="text" name="manager_id" id="manager_id" wire:model="manager_id"
            class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.Select Manager') }}
            </option>
            @forelse ($allowed_employees as $emp)
                @if ($emp->id == $manager_id)
                    <option value="{{ $emp->id }}" selected>
                        {{ $emp->user->fullname() }}
                    </option>
                @else
                    <option value="{{ $emp->id }}">
                        {{ $emp->user->fullname() }}
                    </option>
                @endif

            @empty
            @endforelse
        </select>
    </div>

    <div class="sm:col-span-2 mb-3">

        <x-button status="primary" type="button" wire:click="edit()">
            {{ __('string.Save') }}

        </x-button>
    </div>





</x-widgets.section>
