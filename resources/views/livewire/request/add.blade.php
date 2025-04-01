<x-widgets.section title="{{ __('string.New Request') }}">


    <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="name" name="name"
        label="{{ __('string.Name') }}" wire:model='name' />



    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="type "> {{ __('string.Type') }} </x-form.label>
        <select type="text" name="type" id="type" wire:model="type"
            class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.Select request type') }}
            </option>
            @forelse ($types as $t)
                <option value="{{ $t->id }}">
                    {{ $t->type }}
                </option>
            @empty
            @endforelse

        </select>
        @error('type')
            <x-alert.alert type="danger" :message="$message" />
        @enderror
    </div>
    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="department "> {{ __('string.Department') }} </x-form.label>
        <select type="text" name="department" id="department" wire:model="department"
            class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.Department') }}
            </option>
            @forelse ($departments as $dep)
                <option value="{{ $dep->id }}">
                    {{ $dep->name }}
                </option>
            @empty
            @endforelse
        </select>
        @error('department')
            <x-alert.alert type="danger" :message="$message" />
        @enderror
    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2  ">
        <x-form.label for="active">
            {{ __('string.Active') }}
        </x-form.label>
        <input type="checkbox" name="active" id="active" wire:model="active"
            class=" border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        @error('active')
            <x-alert.alert type="danger" :message="$message" />
        @enderror

    </div>



    <div class="sm:col-span-2 mb-3 grid grid-cols-4">

        <x-button status="primary" type="button" wire:click="add()">
            {{ __('string.Add') }}

        </x-button>
    </div>




</x-widgets.section>
