<x-layouts.guest >
    <x-slot:title >
       forgot password
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
                        {{__('string.Reset Your Password')}}
                    </h1>

                    <form class="space-y-4 md:space-y-6" action="{{Route('password.email')}}" method="POST" >
                        @csrf
                        <div>
                            {{__('text.Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.')}}
                        </div>
                        <div>
                            <x-widgets.input id="email" name="email" label="{{__('string.email')}}"  type="email"/>
                        </div>


                        <x-button status="primary"  type="submit"> {{__('string.Send link')}}</x-button>

                         <!-- Session Status -->
                        <div>
                            @if ($status= session('status'))
                                <x-alert.alert  type="warning" :message="$status"/>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
      </section>

</x-layouts.guest>
