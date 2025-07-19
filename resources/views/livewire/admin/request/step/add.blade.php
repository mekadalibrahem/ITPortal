<x-widgets.section title="{{ __('string.step.new') }}">
    <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="name"
        name="name" label="{{ __('string.Name') }}" wire:model='name' />
    <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="description"
        name="description" label="{{ __('string.Description') }}" wire:model='description' />
  
    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="department "> {{ __('string.Department') }} </x-form.label>
        <select type="text" name="department" id="department"
            wire:model="department"
            class="  bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.Select Department') }}
            </option>
            @forelse ($departments as $dep)
                <option value="{{ $dep->id }}">
                    {{ $dep->name }}
                </option>
            @empty
            @endforelse
        </select>
        @error('department')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="role "> {{ __('string.Role') }} </x-form.label>
        <select type="text" name="role" id="role" wire:model="role"
            class="  bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.select role') }}
            </option>
            @forelse ($roles as $key => $value)
                <option value="{{ $key }}">
                    {{ $value }}
                </option>
            @empty
            @endforelse
        </select>
        @error('role')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="sm:col-span-2 mb-3 grid grid-cols-4 gap-2">
        <x-button status="primary" wire:click='save()' block={{ false }}>
            {{ __('string.Add') }}
        </x-button>
    </div>
</x-widgets.section>
