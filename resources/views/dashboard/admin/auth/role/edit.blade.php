<x-layouts.dashboard>
    <x-slot:title>
        {{__("string. Roles")}}
    </x-slot:title>

    {{-- // TODO EDIT PAGE STYLEING --}}

    {{-- <livewire:admin.roles.show-roles-section /> --}}


    <livewire:admin.roles.role-card  :id="$id"/>

</x-layouts.dashboard>
