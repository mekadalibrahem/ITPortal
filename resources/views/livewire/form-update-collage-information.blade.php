<form action="#" wire:submit='edit'>
    <x-widgets.input id="new_name" label="{{ __('string.Name') }}" wire:model='new_name' />
    <x-widgets.input id="new_value" label="{{ __('string.Value') }}" wire:model='new_value' />


        <x-button status="primary">
            {{__("string.Edite")}}
        </x-button>
    
</form>
