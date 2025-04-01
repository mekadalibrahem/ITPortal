<x-layouts.guest>
    <x-slot:title>
        {{ __('string.register') }}
    </x-slot:title>

    <section class="w-full  flex items-center justify-center md:h-screen">
        <div class="flex flex-col md:flex-row items-center justify-between w-full max-w-6xl px-6 py-8 lg:py-0">
            <!-- Image Side -->
            <div class="hidden md:block w-full md:w-1/2 lg:w-2/5">
                <img class="w-full h-auto" src="{{ asset('imgs/ITportal_logo_xl-removebg.png') }}" alt="logo">
            </div>

            <!-- Form Side -->
            <div
                class="w-full  md:w-1/2 lg:w-3/5 bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        {{ __('string.Create new account') }}
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ Route('register') }}" method="POST">
                        @csrf
                        <div class="grid md:grid-cols-1 lg:grid-cols-3 justify-between gap-2">
                            <x-widgets.input id="fname" name="fname" label="{{ __('string.fname') }}"
                                value="{{ old('fname') }}" />
                            <x-widgets.input id="mname" name="mname" label="{{ __('string.mname') }}"
                                value="{{ old('mname') }}" />
                            <x-widgets.input id="lname" name="lname" label="{{ __('string.lname') }}"
                                value="{{ old('lname') }}" />
                        </div>
                        <div class=" grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <div class="sm:col-span-1">
                                <x-widgets.input id="username" name="username" label="{{ __('string.username') }}"
                                    value="{{ old('username') }} " />

                            </div>
                            <x-widgets.input id="email" name="email" label="{{ __('string.email') }}"
                                value="{{ old('email') }}" />

                        </div>
                        <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <x-widgets.input id="password" name="password" label="{{ __('string.password') }}"
                                value="{{ old('password') }}" type="password" />
                            <x-widgets.input id="confirm_password" name="confirm_password"
                                label="{{ __('string.confirm_password') }}" value="{{ old('confirm_password') }}"
                                type="password" />
                            <x-widgets.input id="email" name="email" label="{{ __('string.email') }}"
                                value="{{ old('email') }}" />
                        </div>
                        <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <x-widgets.input id="nid" name="nid" label="{{ __('string.ID number') }}"
                                value="{{ old('nid') }}" />

                            <div>
                                <x-form.label for="type" value="{{ __('string.Account Type') }}" />
                                <select name="type" id="type"
                                    class='border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'>
                                    <option value="0">
                                        {{ __('string.select type') }}
                                    </option>
                                    <option value="1">
                                        {{ __('string.student') }}
                                    </option>
                                    <option value="2">
                                        {{ __('string.employee') }}
                                    </option>
                                </select>

                                <x-form.input-error :message="$errors->get('test')" />

                            </div>

                        </div>




                        <x-button status="primary" type="submit"> {{ __('string.register') }} </x-button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            {{ __('string.Already registered') }}
                            <a href="{{ Route('login') }}"
                                class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                                {{ __('string.login') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.guest>
