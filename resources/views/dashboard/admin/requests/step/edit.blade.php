<x-layouts.dashboard>

    <x-slot:title>
        {{ __('string.step.edit') }}
    </x-slot:title>
    <livewire:admin.request.step.edit :id="$id" />

</x-layouts.dashboard>
