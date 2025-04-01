    <!--- update profile section  --->
    <x-widgets.section title="{{ __('string.Update account') }}">
        <form wire:submit="edit">
            @csrf
            <div class="grid gap-4 mb-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 sm:gap-6 sm:mb-5">
                <x-widgets.input label="{{ __('string.fname') }}" id='fname' name='fname' wire:model="fname" />
                <x-widgets.input label="{{ __('string.mname') }}" id='mname' name='mname' wire:model="mname" />
                <x-widgets.input label="{{ __('string.lname') }}" id='lname' name='lname' wire:model="lname" />
                <x-widgets.input label="{{ __('string.ID number') }}" id='nid' name='nid' wire:model="nid" />
                <x-widgets.input label="{{ __('string.username') }}" id='username' name='username'
                    wire:model="username" />
                <x-widgets.input label="{{ __('string.email') }}" id='email' name='email' wire:model="email"
                    type="email" />
                <div class=" flex  items-center  space-x-4">
                    <x-button status='primary' type="submit" class="w-auto">
                        {{ __('string.update') }}
                    </x-button>

                </div>
            </div>
        </form>
    </x-widgets.section>
