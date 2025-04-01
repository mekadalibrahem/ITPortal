 <!--- delete account section  --->
 <x-widgets.section title="{{ __('string.Delete account') }}">

     <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">

         <div class="sm:col-span-2">
             {{ __('text.Delete Account') }}
         </div>
         <div x-data="{ delete_model: false }">
             <x-button status="danger" type="button" class="flex item-center" x-on:click="delete_model = ! delete_model">
                 <svg class="w-5 h-5 ms-1 me-1" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                         d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                         clip-rule="evenodd"></path>
                 </svg>
                 {{ __('string.Delete') }}
             </x-button>

             <x-model title="{{ __('string.confirm password for delete your Account') }}" show="delete_model"
                 x-on:click="delete_model = ! delete_model">
                 <div class="p-4 md:p-5">
                     <form wire:submit="delete">
                         @csrf
                         <div>
                             @if ($delete_status != [])
                                 <x-alert.alert :type="$delete_status['type']" :message="$delete_status['message']" />
                             @endif
                         </div>
                         <x-widgets.input divstyle="sm:col-span-2" label="{{ __('string.password') }}"
                             type='password' id='password_delete' name='password_delete' wire:model="password_delete" />

                         <x-button status="danger" type="submit" class="mt-4">

                             {{ __('string.Delete') }}
                         </x-button>
                     </form>


                 </div>
             </x-model>
         </div>
         <div>


         </div>
     </div>

 </x-widgets.section>
