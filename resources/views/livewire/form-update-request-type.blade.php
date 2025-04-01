<x-widgets.section title="{{ __('string.Edit Request Type') }}">
    <form action="#" wire:submit='edit'>
        @csrf
        <x-widgets.input divstyle="sm:col-span-2" id="type" name="type" label="{{ __('string.Request type') }}"
            wire:model='type' required />

        <x-button status="priamry" type="submit">
            {{ __('string.Save') }}
        </x-button>




    </form>

</x-widgets.section>
