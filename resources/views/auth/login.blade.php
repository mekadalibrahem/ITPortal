<x-layouts.guest>
    <x-slot:title>
        {{ __('string.login') }}
    </x-slot:title>


    <section class="w-full  flex items-center justify-center md:h-screen">
        <div class="flex flex-col md:flex-row items-center justify-between w-full max-w-6xl px-6 py-8 lg:py-0">
            <!-- Image Side -->
            <div class="hidden md:block w-full md:w-1/2 lg:w-2/5">
                <img class="w-full h-auto" src="{{ asset('imgs/ITportal_logo_xl-removebg.png') }}" alt="logo">
            </div>
            <div
                class="w-full  md:w-1/2 lg:w-3/5 bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        {{ __('string.Sign in to your account') }}
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ Route('login_handler') }}" method="GET">
                        @csrf

                        <x-widgets.input id="email" name="email" label="{{ __('string.email') }}" />
                        <x-widgets.input id="password" name="password" label="{{ __('string.password') }}" type="password"/>

                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" name="remmber" aria-describedby="remember" type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                                </div>
                                <div class="ms-3 text-sm">
                                    <label for="remember" class="text-gray-500 dark:text-gray-300">
                                        {{ __('string.Remember me') }}
                                    </label>
                                </div>
                            </div>
                            <a href="{{ Route('password.request') }}"
                                class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                {{ __('string.Forgot password?') }}
                            </a>
                        </div>
                        <x-button status="primary" type="submit">{{ __('string.login') }}</x-button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            {{ __('string.Don’t have an account yet?') }} <a href="{{ route('register') }}"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                                {{ __('string.register') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layouts.guest>
