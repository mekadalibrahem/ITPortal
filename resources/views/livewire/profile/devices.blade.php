
<x-widgets.section title="{{__('string.Devices')}} ">


    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
        <div class="sm:col-span-2">
            @if (session('status') === 'device-update')
                <x-alert.alert type='info' message="devices updated" />
            @endif
        </div>
        <div class="sm:col-span-2">
            {{ __("text.Device section") }}

        </div>
        <div class="sm:col-span-2">

            @if ($sessions)
                <div class="my-5 space-y-6">
                    <!-- Other Browser Sessions -->
                    @foreach ($sessions as $session)
                        <livewire:profile.device-item
                            :is_desktop="$session['agent']->isDesktop()"
                            :platform="$session['agent']->platform()"
                            :browser="$session['agent']->browser()"
                            :last_active="$session['last_active']"
                            :ip_address="$session['ip_address']"
                            :is_current_device="$session['is_current_device']"

                        />

                    @endforeach
                </div>
            @endif



            <div x-data="{ show: false }">

                <x-button status="primary" type="button" class="w-auto  lg:w-2/5" x-on:click="show = ! show">
                    {{__("string.Log out other devices")}}
                </x-button>
                <x-model title="{{__('string.confirm_password')}}" show="show" x-on:click="show = ! show">
                    <div class="p-4 md:p-5">
                        <form wire:submit="logout_others" method="POST">
                            @csrf
                            <div>
                                @if ($logout_status != [])
                                    <x-alert.alert :type="$logout_status['type']" :message="$logout_status['message']" />
                                @endif
                            </div>
                            <div class="sm:col-span-2 mb-4">
                                <x-form.label for="password" value='{{__("string.password")}}' />
                                <x-form.input type='password' wire:model="password" id="password" name='password'
                                    required fouce />
                                @error('password')
                                    <X-alert.alert type="danger" :message="$message" />
                                @enderror


                            </div>
                            <x-button status="danger" type="submit" class="mt-4">

                                {{__("string.logout")}}
                            </x-button>
                        </form>


                    </div>
                </x-model>
            </div>
        </div>
    </div>
</x-widgets.section>
