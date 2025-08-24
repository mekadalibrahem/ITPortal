<x-layouts.dashboard>
    <x-slot:title>
        {{ __('string.Staticties') }}
    </x-slot:title>
    <x-widgets.section title="{{ __('string.Staticties') }}">

        <div class="flex  flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <livewire:staticties.request-list-count />
                <livewire:staticties.request-status-count />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <livewire:staticties.department-request-count />
                <livewire:staticties.employee-request-count />

            </div>

        </div>

    </x-widgets.section>

</x-layouts.dashboard>
