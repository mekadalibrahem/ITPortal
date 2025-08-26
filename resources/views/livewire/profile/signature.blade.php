<x-widgets.section title="{{ __('string.Change Signature') }}">
    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">
        <form wire:submit.prevent="edit">
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <x-widgets.input divstyle="sm:col-span-2" label="{{ __('string.password') }}" type="password"
                    id="spassword" name="spassword" wire:model="spassword" />

                <x-widgets.input-image divstyle="sm:col-span-2" label="{{ __('string.signature') }}" type="file"
                    accept="image/*" id="signature" name="signature" wire:model="signature" />
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                    <span>Uploading... <span x-text="progress"></span>%</span>
                </div>
                <!-- Preview uploaded file -->
                @if ($signature)
                    <div class="sm:col-span-2 mt-2">
                        <p class="text-sm font-medium text-gray-500 dark:text-white mb-2">
                            {{ __('string.New Signature Preview') }}:</p>
                        <img src="{{ $signature->temporaryUrl() }}" alt="Signature Preview"
                            class="max-h-32 border rounded bg-white" style="max-width: 200px;">
                    </div>
                @endif

                <!-- Current Signature -->
                @if ($current_signature)
                    <div class="sm:col-span-2 mt-2">
                        <p class="text-sm font-medium text-gray-500 dark:text-white mb-2">
                            {{ __('string.Current Signature') }}:</p>
                        <img src="{{ $current_signature }}" alt="Current Signature"
                            class="max-h-32 border rounded bg-white" style="max-width: 200px;">
                    </div>
                @endif
            </div>

            <div class="flex items-center space-x-4">
                <x-button status="primary" type="submit" class="w-auto">
                    {{ __('string.Change Signature') }}
                </x-button>
            </div>
        </form>
    </div>
</x-widgets.section>
