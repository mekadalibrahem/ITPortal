<x-layouts.dashboard>

    <x-slot:title>
        {{ __('string.Departments') }}
    </x-slot:title>

    <livewire:admin.department.edit  :id="$id" />
    <livewire:admin.department.index  :id="$id" />

</x-layouts.dashboard>
