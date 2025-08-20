<x-layouts.dashboard>
    <x-slot:title>
       {{__("string.Staticties")}}
    </x-slot:title>

    {{__("string.Staticties")}}
    <div class="grid grid-cols-1 md:grid-cols-2">
        <livewire:staticties.request-list-count />
        <livewire:staticties.request-status-count />
    </div>
    <livewire:staticties.department-request-count />
    <livewire:staticties.employee-request-count />
    
</x-layouts.dashboard>
