     <!--- update password section  --->
     <x-widgets.section title="{{__('string.Change password') }}">
             <form wire:submit="edit">
                 @csrf
                 <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        <x-widgets.input divstyle="sm:col-span-2" label="{{ __('string.password') }}" type='password'
                     id='password' name='password'  wire:model="password" />

                 <x-widgets.input divstyle="sm:col-span-2" label="{{ __('string.New Password') }}" type='password'
                     id='new_password' name='new_password'  wire:model="new_password"/>

                 <x-widgets.input divstyle="sm:col-span-2" label="{{ __('string.Change password') }}" type='password'
                     id='confirm_password' name='confirm_password'  wire:model="confirm_password"/>


                     <div class=" flex  items-center  space-x-4">
                         <x-button status="primary" type="submit" class="w-auto">
                            {{__("string.Change password")}}
                         </x-button>

                     </div>
                 </div>
             </form>

    </x-widgets.section>
