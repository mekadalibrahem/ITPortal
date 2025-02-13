<x-layouts.dashboard>

    <x-slot:title>
        {{ __('string.Requests') }}
    </x-slot:title>
    <livewire:request.edit :id="$id" />

</x-layouts.dashboard>
