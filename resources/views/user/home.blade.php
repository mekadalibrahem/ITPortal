<x-layouts.app >
    <x-slot:title >
        title
    </x-slot:title>
    <main class=" h-screen  dark:bg-gray-700" >
        <section class="pt-10 mb-4">
            <h1 class="mb-5 text-center text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{__("string.Current requests")}}
                </h1>

            <div class="grid gap-8 lg:grid-cols-3 ">

                @forelse ($request_list as $request )

                    <x-cards.request-list-min-card :request="$request" />



                @empty
                 <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-md  text-gray-900 dark:text-white  dark:bg-gray-800 dark:border-gray-700">
                    <p>  {{__("text.Empty request")}}  </p>
                 </div>
                @endforelse
            </div>
        </section>


       <livewire:notifications-cards-min  :user_id="$user_id" />





    </main>

</x-layouts.app>








