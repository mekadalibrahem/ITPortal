     <!--- update password section  --->
     <x-widgets.section title="{{__('string.Change password') }}">


             @if ($edit_passowrd != '')
                 <x-alert.alert type='success' message="password updated" />
             @endif

             <form wire:submit="edit">
                 @csrf
                 <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                     <div class="sm:col-span-2">
                         <x-form.label for="password" value='{{__("string.password")}}' />
                         <x-form.input type='password' wire:model="password" id="password" name='password'
                             value="" required />
                         @error('password')
                             <x-alert.alert type="danger" :message="$message" />
                         @enderror
                     </div>
                     <div class="sm:col-span-2">
                         <x-form.label for="new_password" value='{{__("string.New Password")}}' />
                         <x-form.input type='password' wire:model="new_password" id="new_password" name='new_password'
                             value="" />
                         @error('new_password')
                             <x-alert.alert type="danger" :message="$message" />
                         @enderror
                     </div>
                     <div class="sm:col-span-2">
                         <x-form.label for="confirm_password" value='{{__("string.Change password")}}' />
                         <x-form.input type='password' wire:model="confirm_password" id="confirm_password"
                             name='confirm_password' value="" />
                         @error('confirm_password')
                             <x-alert.alert type="danger" :message="$message" />
                         @enderror
                     </div>
                     <div class=" flex  items-center  space-x-4">
                         <x-button status="primary" type="submit" class="w-auto">
                            {{__("string.Change password")}}
                         </x-button>

                     </div>
                 </div>
             </form>

    </x-widgets.section>
