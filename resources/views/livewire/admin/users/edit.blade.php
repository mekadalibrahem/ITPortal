<x-widgets.section title="{{ __('string.Edit user') }}">
    <div class="border-b border-gray-200 dark:border-neutral-700 ">
        <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            <!-- Tab 1 -->
            <button type="button"
                class="me-2 hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500 {{ $selected_tap === 1 ? 'border-blue-600 text-blue-600 font-semibold' : '' }}"
                wire:click='selectTab(1)'>
                {{ __('string.user information') }}
            </button>

            <!-- Tab 2 -->
            <button type="button"
                class="me-2 hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500 {{ $selected_tap === 2 ? 'border-blue-600 text-blue-600 font-semibold' : '' }}"
                wire:click='selectTab(2)'>
                {{ __('string.Security') }}
            </button>

            <!-- Tab 3 -->
            <button type="button"
                class="me-2 hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-blue-500 {{ $selected_tap === 3 ? 'border-blue-600 text-blue-600 font-semibold' : '' }}"
                wire:click='selectTab(3)'>
                {{ __('string.Authorization') }}
            </button>
        </nav>
    </div>

    <div class="mt-3">
        @if ($selected_tap === 1)
            <div id="tabs-with-icons-1" role="tabpanel" aria-labelledby="tabs-with-icons-item-1">
                <div class="grid md:grid-cols-1 lg:grid-cols-3 justify-between gap-2">
                    <x-widgets.input id="fname" name="fname" label="{{ __('string.fname') }}"
                        wire:model='fname' />
                    <x-widgets.input id="mname" name="mname" label="{{ __('string.mname') }}"
                        wire:model='mname' />
                    <x-widgets.input id="lname" name="lname" label="{{ __('string.lname') }}"
                        wire:model='lname' />
                </div>
                <div class=" grid  md:grid-cols-1 lg:grid-cols-3 justify-between gap-2">
                    <div class="sm:col-span-1">
                        <x-widgets.input id="username" name="username" label="{{ __('string.username') }}"
                            wire:model='username' />

                    </div>
                    <x-widgets.input id="email" name="email" label="{{ __('string.email') }}"
                        wire:model='email' />
                    <div class="sm:col-span-1">
                        <x-widgets.input id="nid" name="nid" label="{{ __('string.ID number') }}"
                            wire:model='national_id' />
                    </div>

                </div>
                <x-button status="primary" type="button" wire:click='saveInfo()'> {{ __('string.Save') }} </x-button>
            </div>
        @endif

        @if ($selected_tap === 2)
            <div id="tabs-with-icons-2" role="tabpanel" aria-labelledby="tabs-with-icons-item-2">
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="sm:col-span-2">


                        <div class="my-5 space-y-6">
                            <!-- Other Browser Sessions -->
                            @forelse ($user_sessions as $session)
                                <livewire:profile.device-item :is_desktop="$session['agent']->isDesktop()" :platform="$session['agent']->platform()" :browser="$session['agent']->browser()"
                                    :last_active="$session['last_active']" :ip_address="$session['ip_address']" :is_current_device="$session['is_current_device']" />

                            @empty
                              {{ __('text.Empty session') }}
                            @endforelse 

                        </div>


                    </div>
                </div>

                <x-button status="primary" type="button" wire:click='resetPassword()'>
                    {{ __('string.reset password') }} </x-button>

                <x-button status="warning" type="button" wire:click='forceLogout()'>
                    {{ __('string.force logout') }} </x-button>
            </div>
        @endif
        @if ($selected_tap === 3)
            <div id="tabs-with-icons-3" role="tabpanel" aria-labelledby="tabs-with-icons-item-3">
                <div class="grid  md:grid-cols-1 lg:grid-cols-4 justify-between gap-2">
                    <x-form.label for="role" value="  {{ __('string.select role') }}" />
                    <select name="role" id="role" wire:model='role'
                        class='border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'>
                        <option value="0">
                            {{ __('string.select role') }}
                        </option>
                        @forelse ($roles as  $r)
                            <option wire:key='{{ $r->id }}' value="{{ $r->id }}">
                                {{ $r->name }}
                            </option>
                        @empty
                        @endforelse
                    </select>

                    <x-form.input-error :message="$errors->get('role')" />
                    <div>
                        <x-button type="button" wire:click='addRole()'> + </x-button>
                    </div>

                </div>
                <div class="gird grid-flow-col auto-cols-max mb-4">
                    @foreach ($user_roles as $i)
                        <span id="badge-dismiss-default"
                            class="inline-flex items-center px-2 py-1 me-2 mt-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{ $i->name }}
                            <button type="button" wire:click="removeRole('{{ $i->id }}')"
                                class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300"
                                data-dismiss-target="#badge-dismiss-default" aria-label="Remove">
                                <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Remove badge</span>
                            </button>
                        </span>
                    @endforeach
                </div>
                <div>
                    <x-button status="primary" type="button" wire:click='saveRoles()'>
                        {{ __('string.Save') }} </x-button>
                    <x-button status="primary" type="button" wire:click='addEmployee()'>
                        {{ __('string.add employee') }} </x-button>
                </div>
            </div>
        @endif
    </div>


</x-widgets.section>
