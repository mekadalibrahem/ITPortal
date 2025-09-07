<x-widgets.section title="{{ __('string.new User') }}" >
      <div class="w-full px-4 py-8 mx-auto">
                   
                    <form class="space-y-4 md:space-y-6" >
                       
                        <div class="grid md:grid-cols-1 lg:grid-cols-3 justify-between gap-2">
                            <x-widgets.input id="fname" name="fname" label="{{ __('string.fname') }}"
                              wire:model='fname' />
                            <x-widgets.input id="mname" name="mname" label="{{ __('string.mname') }}"
                               wire:model='mname' />
                            <x-widgets.input id="lname" name="lname" label="{{ __('string.lname') }}"
                               wire:model='lname'/>
                        </div>
                        <div class=" grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <div class="sm:col-span-1">
                                <x-widgets.input id="username" name="username" label="{{ __('string.username') }}"
                                    wire:model='username' />

                            </div>
                            <x-widgets.input id="email" name="email" label="{{ __('string.email') }}"
                                wire:model='email' />

                        </div>
                        <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <x-widgets.input id="password" name="password" label="{{ __('string.password') }}"
                               type="password" wire:model='password' />
                            <x-widgets.input id="confirm_password" name="confirm_password"
                                label="{{ __('string.confirm_password') }}" 
                                type="password"  wire:model='confirm_password'/>
                           
                        </div>
                        <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                            <x-widgets.input id="nid" name="nid" label="{{ __('string.ID number') }}"
                                wire:model='national_id'/>

                            <div>
                                <x-form.label for="type" value="{{ __('string.Account Type') }}" />
                                <select name="type" id="type" wire:model='type'
                                    class='border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'>
                                    <option value="0">
                                        {{ __('string.select type') }}
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




                        <x-button status="primary" type="button" wire:click='save()'> {{ __('string.register') }} </x-button>
                      
                    </form>
                </div>
</x-widgets.section>