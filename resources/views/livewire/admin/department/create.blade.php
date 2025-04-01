<x-widgets.section title="{{ __('string.add Department') }}">
    <div class="p-4 rounded-lg" id="add" role="tabpanel" aria-labelledby="add-tab">


        <x-widgets.input id="name" name="name" label="{{ __('string.Name') }}"
            wire:model='name' />

        <x-widgets.input  id="description" name="description"
            label="{{ __('string.description') }}" wire:model='description' />

        <div class="sm:col-span-2 mb-3 flex flex-row ">
            <label for="dep_manager" class="basis-1/4 block mb-2 text-sm font-medium text-gray-500 dark:text-white">
                {{ __('string.department manager') }}
            </label>
            <select type="text" name="dep_manager" id="dep_manager" wire:model="dep_manager"
                wire:change="select_manager()"
                class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="0">
                    {{ __('string.Select Manager') }}
                </option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->user->fullname() }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="sm:col-span-2 mb-3">

            <x-button status="primary" type="button" wire:click="add()">

                {{ __('string.Add') }}

            </x-button>
        </div>




    </div>
</x-widgets.section>
