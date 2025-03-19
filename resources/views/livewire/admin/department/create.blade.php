<x-widgets.section title="{{__('string.Add')}}">
    <div class="p-4 rounded-lg" id="add" role="tabpanel" aria-labelledby="add-tab">

        <div class="sm:col-span-2 mb-3 flex flex-row ">
            <label for="name" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('string.Name') }}
            </label>
            <input type="text" name="name" id="name" wire:model="name"
                class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                required="">
            @error('name')
                <x-alert.alert type="danger" :message="$message" />
            @enderror
        </div>
        <div class="sm:col-span-2 mb-3 flex flex-row ">
            <label for="description" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('string.description') }}
            </label>
            <textarea type="text" name="description" id="description" wire:model="description"
                class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                required=""></textarea>
            @error('description')
                <x-alert.alert type="danger" :message="$message" />
            @enderror
        </div>

        <div class="sm:col-span-2 mb-3 flex flex-row ">
            <label for="dep_manager" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
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

            <button type="button" wire:click="add()"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">

                {{ __('string.Add') }}

            </button>
        </div>




</div>
</x-widgets.section>
