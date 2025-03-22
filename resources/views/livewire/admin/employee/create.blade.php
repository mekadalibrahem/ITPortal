<x-widgets.section title="{{ __('string.employee') }}">


    <div class="flex flex-col gap-4  p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="add" role="tabpanel"
        aria-labelledby="add-tab">

        <div class="grid grid-cols-4 gap-2 ">
            <x-form.label for="email">
                {{ __('string.ID number') }}
            </x-form.label>
            <x-form.input  name="nid" id="nid" wire:model="nid" />
            @error('nid')
                <x-alert.alert type="danger" :message="$message" />
            @enderror

        </div>

        <div class="grid grid-cols-4 gap-2">
            <x-form.label for="department">
                {{ __('string.Department') }}
            </x-form.label>
            <select type="text" name="department" id="department" wire:model="department"
                class="basis-1/2 bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="0">
                    {{ __('string.Select Department') }}
                </option>
                @foreach ($departments as $dep)

                        <option value="{{ $dep->id }}">
                            {{ $dep->name }}
                        </option>
                   
                @endforeach


            </select>
        </div>

        <div class="grid grid-cols-4 gap-4">

            <x-button status="primary" type="button" wire:click="add()">

                {{ __('string.Add') }}

            </x-button>

        </div>




    </div>


</x-widgets.section>
