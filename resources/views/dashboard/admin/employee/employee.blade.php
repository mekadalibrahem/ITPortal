<x-layouts.dashboard>

    <x-slot:title >
        {{__("string.employee")}}
    </x-slot:title>
    <div class=" h-screen  overflow-visible  mb-4 m-10">
        <section class="pt-4 mb-4">

            <livewire:admin.employee.edit />
            <livewire:admin.employee.show />

        </section>
    </div>
</x-layouts.dashboard>




