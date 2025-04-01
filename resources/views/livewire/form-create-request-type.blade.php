<x-widgets.section title="{{ __('string.Request type') }}">
    <form action="#" wire:submit ='create'>
        @csrf
        <x-widgets.input divstyle="sm:col-span-2" id="type" name="type" label="{{ __('string.Name') }}"
            wire:model='type' required />



        <x-button status="primary" type="submit">
            {{ __('string.Add') }}

        </x-button>



    </form>

</x-widgets.section>
