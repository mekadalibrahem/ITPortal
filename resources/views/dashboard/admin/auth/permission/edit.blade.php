<x-layouts.dashboard>
    <x-slot:title>
        {{__("string. Permissions")}}
    </x-slot:title>

    <livewire:admin.permissions.edit :id="$id" />

</x-layouts.dashboard>
