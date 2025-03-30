<!--- Add new Role section  --->
<x-widgets.section title="{{ __('string.Add new Role') }}">
    <form wire:submit="store">
        @csrf
        <x-widgets.input label="{{ __('string.New Name') }}" id="name" type="text" wire:model='name' />

        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
            <div class=" flex  items-center  space-x-4 mt-3">
                <x-button status="primary" type="submit" class="w-auto">
                    {{ __('string.Save') }}
                </x-button>

            </div>
        </div>
    </form>
</x-widgets.section>
