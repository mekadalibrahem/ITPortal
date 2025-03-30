<x-widgets.section title="{{ __('string.Edit  permission') }}">
    <div class="max-w-2xl px-4 py-8 mx-auto ">
        <form wire:submit="update">
            @csrf
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">

                <div class="sm:col-span-2">
                    <x-widgets.input id="name" label="{{ __('string.Name') }}" type="text" wire:model='name' />
                </div>

                <div class=" flex  items-center  space-x-4">
                    <x-button status="primary" type="submit" class="w-auto">
                        {{ __('string.Save') }}
                    </x-button>

                </div>
            </div>

        </form>
    </div>
</x-widgets.section>
