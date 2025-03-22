<x-layouts.dashboard>

    <x-slot:title>
        {{ __('string.employee') }}
    </x-slot:title>
    <x-widgets.section title="{{ __('string.Employees') }}">
        <livewire:data-tables.employees-table >
    </x-widgets.section>
</x-layouts.dashboard>
