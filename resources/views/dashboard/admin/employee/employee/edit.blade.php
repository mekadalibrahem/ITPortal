<x-layouts.dashboard>

    <x-slot:title>
        {{ __('string.employee') }}
    </x-slot:title>

    <livewire:admin.employee.edit :id="$id" />

</x-layouts.dashboard>
