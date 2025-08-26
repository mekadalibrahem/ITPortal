<x-widgets.section title="{{ __('string.add Department') }}">
    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">

        <form wire:submit.prevent='add()'>
            <x-widgets.input id="name" name="name" label="{{ __('string.Name') }}" wire:model='name' />

            <x-widgets.input id="description" name="description" label="{{ __('string.description') }}"
                wire:model='description' />

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
            <x-widgets.input-image id="stamp" name="stamp" label="{{ __('string.stamp') }}"
                wire:model='stamp' accept="image/*" />
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
                <span>Uploading... <span x-text="progress"></span>%</span>
            </div>
            @if ($stamp)
                <div class="sm:col-span-2 mt-2">
                    <p class="text-sm font-medium text-gray-500 dark:text-white mb-2">
                        {{ __('string.stamp preview') }}:</p>
                    <img src="{{ $stamp->temporaryUrl() }}" alt="stamp Preview"
                        class="max-h-32 border rounded bg-white" style="max-width: 200px;">
                </div>
            @endif

            <div class="sm:col-span-2 mb-3 mt-3">

                <x-button status="primary" type="submit" wire:click="add()">

                    {{ __('string.Add') }}

                </x-button>
            </div>


        </form>

    </div>
</x-widgets.section>
