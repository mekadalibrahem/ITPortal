<ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">


   @auth
    <div class="me-2  w-full" >
        <x-switch-lang />
    </div>
    <x-layouts.link  :active="(Route::currentRouteName() == 'dashboard') ?? true" href="{{Route('dashboard')}}" >
         {{__('string.Dashboard')}}
        </x-layouts.link>

    <x-layouts.link  :active="(Route::currentRouteName() == 'profile.create') ?? true" href="{{ Route('profile.create') }}" >
        {{__('string.Profile')}}
    </x-layouts.link>

   @endauth

   @guest

   @endguest
</ul>
