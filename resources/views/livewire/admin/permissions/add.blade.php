<!--- Add new Role section  --->
<x-widgets.section section title="{{ __('string.Add new permission') }}">


        <form wire:submit="store">
            @csrf
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <div class="sm:col-span-2">
                    <x-widgets.input id="name" type="name" label="{{ __('string.Name') }}" wire:model='name' />

                </div>

                <div class=" flex  items-center  space-x-4">
                    <x-button status="primary" type="submit" class="w-auto">
                        {{ __('string.Save') }}
                    </x-button>

                </div>
            </div>

        </form>
    
</x-widgets.section>
