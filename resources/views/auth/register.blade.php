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
                    <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        {{ __('string.Create new account') }}
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ Route('register') }}" method="POST">
                        @csrf
                        <div class="grid md:grid-cols-1 lg:grid-cols-3 justify-between gap-2">
                            <div>
                                <x-form.label for="fname" value="{{ __('string.fname') }}" />
                                <x-form.input value="{{old('fname')}}" type="text" name="fname" id="fname" required="" />
                                <x-form.input-error :message="$errors->get('fname')" />
                            </div>
                            <div>
                                <x-form.label for="mname" value="{{ __('string.mname') }}" />
                                <x-form.input type="text " value="{{old('mname')}}" name="mname" id="mname" required="" />
                                <x-form.input-error :message="$errors->get('mname')" />
                            </div>
                            <div>
                                <x-form.label for="lname" value="{{ __('string.lname') }}" />
                                <x-form.input type="text"  value="{{old('lname')}}" name="lname" id="lname" required="" />
                                <x-form.input-error :message="$errors->get('lname')" />
                            </div>
                        </div>
                        <div class=" grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <div class="sm:col-span-1">
                                <x-form.label for="username" value="{{ __('string.username') }}" />
                                <x-form.input type="text" value="{{old('username')}}" name="username" id="username" required="" />
                                <x-form.input-error :message="$errors->get('username')" />
                            </div>
                            <div>
                                <x-form.label for="email" value="{{ __('string.email') }}" />
                                <x-form.input type="email"  value="{{old('email')}}"  name="email" id="email" required="" />
                                <x-form.input-error :message="$errors->get('email')" />
                            </div>
                        </div>
                        <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">

                            <div>
                                <x-form.label for="password"  value="{{ __('string.password') }}" />
                                <x-form.input type="password" name="password" id="password" required="" />
                                <x-form.input-error :message="$errors->get('password')" />
                            </div>
                            <div>
                                <x-form.label for="confirm_password" value="{{ __('string.confirm_password') }}" />
                                <x-form.input type="password" name="confirm_password" id="confirm_password"
                                    required="" />
                                <x-form.input-error :message="$errors->get('confirm_password')" />
                            </div>
                        </div>
                        <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <div>
                                <x-form.label for="nid" value="{{ __('string.ID number') }}" />
                                <x-form.input type="text" value="{{old('nid')}}" name="nid" id="nid" required="" />
                                <x-form.input-error :message="$errors->get('nid')" />
                            </div>

                            <div>
                                <x-form.label for="type" value="{{ __('string.Account Type') }}" />
                                <select name="type" id="type"
                                    class='border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'>
                                    <option value="0" >
                                        {{__("string.select type")}}
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




                        <x-button  status="primary" type="submit"> {{ __('string.register') }} </x-button>
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
