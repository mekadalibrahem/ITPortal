<section class="pt-10 mb-4">
    <h1 class="mb-5 text-center text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
        {{__("string.notifications")}}
     </h1>

    <div class="grid gap-8 lg:grid-cols-3 ">

        @forelse ($notifications as $notification )

            <livewire:notifications-card :notification="$notification" />

        @empty
         <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-md  text-gray-900 dark:text-white dark:bg-gray-800 dark:border-gray-700">
            <p>
                {{__("string.Empty notifications")}}
            </p>
         </div>
        @endforelse
    </div>
</section>
