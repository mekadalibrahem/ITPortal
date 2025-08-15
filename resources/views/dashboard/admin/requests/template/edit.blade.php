<x-layouts.dashboard>

    <x-slot:title>
        {{ __('string.request_template.name') }}
    </x-slot:title>
    <livewire:admin.request.template.edit :id="$id" />

</x-layouts.dashboard>
