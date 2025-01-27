<x-layouts.guest >
    <x-slot:title >
       Reset Passowrd
    </x-slot:title>


    <section class="">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-20 h-12 mr-2" src="./images/toolkit_logo_dark.png" alt="logo">
                ITPortal
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Reset Your Password
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{Route('password.update')}}" method="POST" >
                        @csrf
                        <div>

                            <input type="hidden" name="token" id="token" value="{{$token}}"   required=""/>
                            <x-form.input-error  :message="$errors->get('token')" />
                        </div>
                        <div>
                            <x-form.label for="email" value="email" />
                            <x-form.input type="email" name="email" id="email"  required=""/>
                            <x-form.input-error  :message="$errors->get('email')" />
                        </div>
                        <div>
                            <x-form.label for="password" value="password" />
                            <x-form.input type="password" name="password" id="password" required=""/>
                            <x-form.input-error  :message="$errors->get('password')" />
                        </div>
                        <div>
                            <x-form.label for="confirm_password" value="confirm password" />
                            <x-form.input type="password" name="confirm_password" id="confirm_password" required=""/>
                            <x-form.input-error  :message="$errors->get('confirm_password')" />
                        </div>


                        <x-button.primary type="submit">Reset password</x-button.primary>

                    </form>
                </div>
            </div>
        </div>
      </section>

</x-layouts.guest>
