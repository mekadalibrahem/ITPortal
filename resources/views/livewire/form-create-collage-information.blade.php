<form action="#" wire:submit="create">

    <x-widgets.input id="name" name="name" label="{{ __('string.Name') }}" wire:model='name' />
    <x-widgets.input id="value" name="value" label="{{ __('string.Value') }}" wire:model='value' />


    <x-button status="primary">
        {{ __('string.Add') }}

    </x-button>




</form>
