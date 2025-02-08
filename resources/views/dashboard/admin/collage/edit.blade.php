<x-layouts.dashboard>

    <x-slot:title>
        {{ __("string.Collage informations")}}
    </x-slot:title>
    <x-widgets.section title="{{__('string.Edit Collage Information')}}">
        <livewire:form-update-collage-information  :id="$id"/>
    </x-widgets.section>

</x-layouts.dashboard>
