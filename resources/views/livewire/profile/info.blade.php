    <!--- update profile section  --->
    <x-widgets.section title="{{ __('string.Update account') }}">



            @if ($info_status != '')
                <x-alert.alert type='success' :message="$info_status" />
            @endif

            <form wire:submit="edit">
                @csrf
                <div class="grid gap-4 mb-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div>
                        <x-form.label for="fname" value="{{__('string.fname')}}" />
                        <x-form.input type="text" wire:model='fname'  name="fname" id="fname" required=""/>
                        <x-form.input-error  :message="$errors->get('fname')" />
                    </div>
                    <div>
                        <x-form.label for="mname" value="{{__('string.mname')}}" />
                        <x-form.input type="text" wire:model='mname'  name="mname" id="mname" required=""/>
                        <x-form.input-error  :message="$errors->get('mname')" />
                    </div>
                    <div>
                        <x-form.label for="lname" value="{{__('string.lname')}}" />
                        <x-form.input type="text" wire:model='lname' name="lname" id="lname" required=""/>
                        <x-form.input-error  :message="$errors->get('lname')" />
                    </div>
                    <div>
                        <x-form.label for="nid" value="{{__('string.ID number')}}" />
                        <x-form.input type="text" wire:model='nid'  name="nid" id="nid" required=""/>
                        <x-form.input-error  :message="$errors->get('nid')" />
                    </div>
                    <div>
                        <x-form.label for="username" value="{{__('string.username')}}" />
                        <x-form.input type="text" wire:model='username'  name="username" id="username" required=""/>
                        <x-form.input-error  :message="$errors->get('username')" />
                    </div>
                    <div class="sm:col-span-1">
                        <x-form.label for="email" value='{{__("string.email")}}' />
                        <x-form.input type='text' wire:model='email' id="email" name='email' required />
                        <x-form.input-error  :message="$errors->get('email')" />
                    </div>
                    <div class=" flex  items-center  space-x-4">
                        <x-button status='primary' type="submit" class="w-auto">
                            {{ __('string.update') }}
                        </x-button>

                    </div>
                </div>

            </form>
</x-widgets.section>
