<x-layouts.guest >
    <x-slot:title >
       verify email
    </x-slot:title>
    <section class="">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full lg:p-10 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>
                    @if (session('status') == 'verification-link-sent')
                        <div class="p-1  text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif
                    <div class="mt-4 flex items-center justify-between">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf

                            <div>
                                <x-button status="primary">
                                    {{ __('Resend Verification Email') }}
                                </x-button>
                            </div>
                        </form>

                        <form action="{{Route('logout_handler')}}" method="GET">
                            @csrf
                            <x-button status="danger" type="submit" >logout</x-button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </section>




</x-layouts.guest >
