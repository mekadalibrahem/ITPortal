<aside
    class=" fixed top-0 md:mt-14 start-0 z-40 w-64 h-screen  transition-transform -translate-y-full bg-white
md:translate-y-0 dark:bg-gray-800 dark:border-gray-700  "
    aria-label="Sidenav" id="default-sidebar">
    <div class="overflow-y-auto py-5 px-3 h-screen bg-white  dark:bg-gray-800 dark:border-gray-700">

        <ul class="space-y-2">
            <li
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <x-switch-lang />


            </li>
            <li>
                <a href="{{ Route('home') }}"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="ml-3">{{ __('string.home') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ Route('profile.create') }}"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="ml-3">
                        {{ __('string.Profile') }}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{Route('user.notification.create')}}"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ml-3 whitespace-nowrap">
                        {{ __('string.notifications') }}
                    </span>
                    <livewire:notification-counter :user_id="Auth::user()->id" />
                </a>
            </li>
            <li>
                <a href="{{ Route('user.requests.create') }}"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="ml-3"> {{ __('string.Requests') }} </span>
                </a>
            </li>

        </ul>


        @hasrole('admin')
            <x-layouts.said-admin-page-link />
        @endhasrole
        @hasrole('employee')
            <x-layouts.said-employee-page-link />
        @endhasrole
    </div>

</aside>
