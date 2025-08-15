<x-layouts.app >
    <x-slot:title >
        Profile
    </x-slot:title>


    <x-widgets.section title=" "  sectionstyle="max-w-7xl bg-slate-50 dark:bg-slate-950" >



        <livewire:profile.info />
        <livewire:profile.signature>
        <livewire:profile.change-password />

        <livewire:profile.devices  />

        <livewire:profile.delete />

    </x-widgets.section>
</x-layouts.app>
