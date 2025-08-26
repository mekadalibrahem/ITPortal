<x-widgets.section title="{{ __('string.edit department') }}">
    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">

        <form wire:submit.prevent='edit()'>
            <x-widgets.input id="name" name="name" label="{{ __('string.Name') }}" wire:model='name' />

            <x-widgets.input id="description" name="description" label="{{ __('string.description') }}"
                wire:model='description' />




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
            <x-widgets.input-image id="new_stamp" name="new_stamp" label="{{ __('string.stamp') }}"
                wire:model='new_stamp' accept="image/*" />
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
                <span>Uploading... <span x-text="progress"></span>%</span>
            </div>
            <div clas="grid grid-col-1 md:grid-cols-2">
                <div class="">
                    @if ($new_stamp)
                        <p class="text-sm font-medium text-gray-500 dark:text-white mb-2">
                            {{ __('string.stamp preview') }}:</p>
                        <img src="{{ $new_stamp->temporaryUrl() }}" alt="stamp Preview"
                            class="max-h-32 border rounded bg-white" style="max-width: 200px;">
                    @endif
                </div>
                <div class="">
                    @if ($stamp)
                        <p class="text-sm font-medium text-gray-500 dark:text-white mb-2">
                            {{ __('string.original stamp preview') }}:</p>
                        <img src="{{ asset('/storage/stamps/' . $stamp) }}" alt="stamp Preview"
                            class="max-h-32 border rounded bg-white" style="max-width: 200px;">
                    @endif
                </div>
            </div>
            <div class="sm:col-span-2 mb-3 mt-3">

                <x-button status="primary" type="button" wire:click="edit()">
                    {{ __('string.Save') }}

                </x-button>
            </div>
        </form>
    </div>





</x-widgets.section>
