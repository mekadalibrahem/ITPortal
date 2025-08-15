<x-widgets.section title="{{ __('string.Change Signature') }}" >
    <form wire:submit.prevent="edit">
        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
            <x-widgets.input 
                divstyle="sm:col-span-2" 
                label="{{ __('string.password') }}" 
                type="password" 
                id="spassword"
                name="spassword" 
                wire:model="spassword" 
            />

            <x-widgets.input 
                divstyle="sm:col-span-2" 
                label="{{ __('string.signature') }}" 
                type="file"
                accept="image/*" 
                id="signature" 
                name="signature" 
                wire:model="signature" 
            />

            <!-- Preview uploaded file -->
            @if ($signature)
                <div class="sm:col-span-2 mt-2">
                    <p class="text-sm text-gray-600">{{ __('string.New Signature Preview') }}:</p>
                    <img src="{{ $signature->temporaryUrl() }}" 
                         alt="Signature Preview" 
                         class="max-h-32 border rounded" style="max-width: 200px;">
                </div>
            @endif

            <!-- Current Signature -->
            @if ($suser->signature )
                <div class="sm:col-span-2 mt-2">
                    <p class="text-sm text-gray-600">{{ __('string.Current Signature') }}:</p>
                    <img src="{{ $suser->signature }}" 
                         alt="Current Signature" 
                         class="max-h-32 border rounded" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <div class="flex items-center space-x-4">
            <x-button status="primary" type="submit" class="w-auto">
                {{ __('string.Change Signature') }}
            </x-button>
        </div>
    </form>
</x-widgets.section>