<x-widgets.section title="{{ __('string.new User') }}">
    <div class="w-full px-4 py-8 mx-auto">

        <form class="space-y-4 md:space-y-6">

            <div class="grid md:grid-cols-1 lg:grid-cols-3 justify-between gap-2">
                <x-widgets.input id="fname" name="fname" label="{{ __('string.fname') }}" wire:model='fname' />
                <x-widgets.input id="mname" name="mname" label="{{ __('string.mname') }}" wire:model='mname' />
                <x-widgets.input id="lname" name="lname" label="{{ __('string.lname') }}" wire:model='lname' />
            </div>
            <div class=" grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                <div class="sm:col-span-1">
                    <x-widgets.input id="username" name="username" label="{{ __('string.username') }}"
                        wire:model='username' />

                </div>
                <x-widgets.input id="email" name="email" label="{{ __('string.email') }}" wire:model='email' />

            </div>
            <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                <x-widgets.input id="password" name="password" label="{{ __('string.password') }}" type="password"
                    wire:model='password' />
                <x-widgets.input id="confirm_password" name="confirm_password"
                    label="{{ __('string.confirm_password') }}" type="password" wire:model='confirm_password' />

            </div>
            <div class="grid  md:grid-cols-1 lg:grid-cols-2 justify-between gap-2">
                <x-widgets.input id="nid" name="nid" label="{{ __('string.ID number') }}"
                    wire:model='national_id' />



            </div>
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
            <div class="flex gap-4">
                <input type="checkbox" wire:model='isemployee' class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-default-checkbox">
                <x-form.label for="isemployee" value="{{ __('string.add employee') }}" />
                

                <x-form.input-error :message="$errors->get('isemployee')" />
            </div>
            <div class="gird grid-flow-col auto-cols-max">
                @foreach ($user_roles as $i)
                    <span id="badge-dismiss-default"
                        class="inline-flex items-center px-2 py-1 me-2 mt-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                        {{ $i['role']->name }}
                        <button type="button" wire:click="removeRole('{{ $i['id'] }}')"
                            class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300"
                            data-dismiss-target="#badge-dismiss-default" aria-label="Remove">
                            <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Remove badge</span>
                        </button>
                    </span>
                @endforeach
            </div>


            <x-button status="primary" type="button" wire:click='save()'> {{ __('string.Save') }} </x-button>

        </form>
    </div>
</x-widgets.section>
