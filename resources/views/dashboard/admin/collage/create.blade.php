<x-layouts.dashboard>

    <x-slot:title>
        {{ __("string.Collage informations")}}
    </x-slot:title>
    <x-widgets.section title="{{__('string.Add')}}">
        <livewire:form-create-collage-information />
    </x-widgets.section>

</x-layouts.dashboard>
