<div
    class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
    <div class="py-2 md:py-0  flex flex-col md:flex-row md:items-center gap-0.5 md:gap-1">
          {{-- divider --}}
          <div class="my-2 md:my-0 md:mx-2">
            <div class="w-full h-px md:w-px md:h-4 bg-slate-100 md:bg-slate-300 dark:bg-slate-700">

            </div>
        </div>

        <div class="grow">
            <div class="flex flex-col md:flex-row md:justify-start md:items-center gap-0.5 md:gap-1">
              @auth
              <x-layouts.link href="{{ Route('home') }}" >
                  {{__('string.home')}}
              </x-layouts.link>
                <x-layouts.link href="{{ Route('profile.create') }}" >
                    {{__('string.Profile')}}
                </x-layouts.link>
                <x-layouts.link href="{{ Route('user.notification.create') }}" >
                    {{ __('string.notifications') }}
                    <livewire:notification-counter :user_id="Auth::user()->id" />
                </x-layouts.link>
                <x-layouts.link href="{{ Route('user.requests.create') }}" >
                    {{__('string.Requests')}}
                </x-layouts.link>
                @hasanyrole(['admin', 'employee'])
                    <x-layouts.link href="{{ Route('dashboard.index') }}" >
                        {{__('string.Dashboard')}}
                    </x-layouts.link>
                @endhasanyrole
              @endauth
              <x-switch-lang />
            </div>
        </div>


        <!-- Button Group -->
        <div class=" flex flex-wrap items-center gap-x-1.5">
            @auth

                <form action="{{ Route('logout_handler') }}" method="GET" class="w-full">
                    @csrf
                    <x-button.danger type="submit">{{ __('string.logout') }}</x-button.danger>
                </form>




            @endauth

            @guest
                <div class=" flex items-center gap-1 w-full ">

                    <form action="{{ Route('login') }}" method="GET" class="w-full">
                        @csrf
                        <x-button status="default" size="sm" type="submit"> {{ __('string.login') }} </x-button>
                    </form>

                    <form action="{{ Route('register') }}" method="GET">
                        @csrf
                        <x-button status="primary" size="sm" type="submit"> {{ __('string.register') }} </x-button>
                    </form>
                </div>
            @endguest
        </div>
        <!-- End Button Group -->
    </div>
</div>
