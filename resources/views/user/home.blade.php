<x-layouts.app >
    <x-slot:title >
        title
    </x-slot:title>
    <main class=" h-screen  dark:bg-gray-700" >

        <x-widgets.section title="{{__('string.Current requests')}}">
            <div class="grid gap-8 lg:grid-cols-3 ">

                @forelse ($request_list as $request )

                    <x-cards.request-list-min-card :request="$request" />



                @empty

                    <p>  {{__("text.Empty request")}}  </p>

                @endforelse
            </div>
        </x-widgets.section>


        
       <livewire:notifications-cards-min  :user_id="$user_id" />





    </main>

</x-layouts.app>








