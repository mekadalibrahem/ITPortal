<x-layouts.app>
    <x-slot:title>
        Notification
    </x-slot:title>
    <main class=" h-screen  mt-9 dark:bg-gray-700">

        <livewire:user.notification.send-form />
        <div class="my-4 h-2" > </div>
        <section
            class="pt-4 mx-auto  grid grid-cols-3 mb-4 bg-white  rounded-lg border border-gray-200 shadow-md dark:border-gray-700 dark:bg-gray-800 ">
            <livewire:user.notification.said />
            <livewire:user.notification.show />
        </section>


    </main>

</x-layouts.app>
