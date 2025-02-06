<x-layouts.dashboard>

    <x-slot:title >
     requests
    </x-slot:title>
    <x-widgets.section title="{{__('string.Employee Requests')}}">
        <livewire:data-tables.employee-request-table  />
    </x-widgets.section>

    {{-- <div class=" overflow-auto  h-4/5 mb-4 m-10">
        <livewire:employee.requests-table />
    </div>
    <div class=" overflow-auto  mb-4 m-10">
        <livewire:employee.requests-card />
    </div> --}}



</x-layouts.dashboa>




