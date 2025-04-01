<!--- show  Roles section  --->
<!-- TODO maybe this page neead to refactoring and improve UI & UX -->
<section class="bg-white container mx-auto md:w-5/5 lg:w-4/5   mt-8 rounded-lg  dark:bg-gray-900">

    <div class="w-full px-4 py-8 mx-auto ">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white"> {{ $user->name ?? ' ' }} <br>
            {{ $user->email ?? ' ' }} </h2>
        @if ($status !== [])
            <x-alert.alert :type="$status['type']" :message="$status['message']" />
        @endif

        <div
            class="grid  grid-cols-2  md:grid-row  gap-4 items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <!--- search --->

            <form class="w-full col-span-2 lg:col-span-2  gap-2" wire:submit='search'>

                <div class="w-full grid grid-cols-1  lg:grid-cols-4  gap-4 justify-between items-center">
                    <x-form.label for="input_search" value="{{__('string.email')}}" />
                    <x-form.input type="text" class="lg:col-span-2" wire:model="input_search"
                        id="input_search" placeholder='{{__("string.Write user email")}}' name="input_search" />
                    <x-button status="primary" type='submit'> {{__("string.Search")}}
                    </x-button>
                </div>
                @error('input_search')
                    <x-alert.alert type="danger" class="w-full col-span-3" :message="$message" />
                @enderror
            </form>
            <form class="w-full col-span-2 lg:col-span-2  gap-2" wire:submit='add_permission'>
                <div class=" w-full grid grid-cols-1  lg:grid-cols-4  gap-4 justify-between items-center">
                    <x-form.label for="new_permission" value="{{__('string.Permission')}}" />
                    <x-form.input type="text" class="lg:col-span-2" wire:model="new_permission"
                        id="new_permission" name="new_permission" />
                    <x-button status="primary" type='submit'> {{__("string.Add")}}
                    </x-button>

                </div>
                @error('new_permission')
                    <x-alert.alert type="danger" class="w-full col-span-3" :message="$message" />
                @enderror
            </form>
            <form class="w-full col-span-2 lg:col-span-2 justify-between gap-2" wire:submit='add_role'>
                <div class="w-full grid grid-cols-1  lg:grid-cols-4  gap-4 justify-between items-center">
                    <x-form.label for="new_role" value="{{__('string.Role')}}" />
                    <x-form.input type="text" class="lg:col-span-2" wire:model="new_role" id="new_role"
                        name="new_role" />
                    <x-button status="primary" type='submit'> {{__("string.Add")}}
                    </x-button>
                </div>
                @error('new_role')
                    <x-alert.alert type="danger" class="w-full col-span-3" :message="$message" />
                @enderror
            </form>


        </div>
        <div class="overflow-x-auto">
            @if ($user != '')
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-4 py-3">#</th>
                            <th scope="col" class="px-4 py-3"> {{__("string.Permission")}} </th>
                            <th scope="col" class="px-4 py-3"> {{__("string.Role")}} </th>
                            <th scope="col" class="px-4 py-3"> {{__("string.Options")}} </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->permissions as $permission)
                            @php
                                $permission_count++;
                            @endphp

                            <tr class="border-b dark:border-gray-700" wire:key="{{ $permission->name }}">
                                <td scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $permission_count }}
                                </td>
                                <td class="px-4 py-3"> {{ $permission->name }} </td>
                                <td class="px-4 py-3"> NONE </td>
                                <td class="px-4 py-3  md:justify-center gap-2">

                                    <x-button.danger type="button"
                                        wire:click="remove_permission('{{ $permission->name }}')"
                                        wire:confirm="are your sure delete this permission" class="w-min">
                                        <x-svg.trash />


                                    </x-button.danger>

                                </td>
                            </tr>
                        @endforeach
                        @foreach ($user->roles as $role)
                            {{-- @dd($role) --}}

                            @forelse ($role->permissions as  $permission)
                                @php
                                    $permission_count++;
                                @endphp
                                @if ($loop->first)
                                    <tr class="border-b dark:border-gray-700" wire:key="{{ $role->name }}">
                                        <td scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $permission_count }}
                                        </td>
                                        <td class="px-4 py-3"> {{ $permission->name }} </td>
                                        <td class="px-4 py-3 dark:border-gray-700  border"
                                            rowspan="{{ $loop->count }}">
                                            {{ $role->name }} </td>

                                        <td class="px-4 py-3   border dark:border-gray-700 flex-row md:justify-center gap-2"
                                            rowspan="{{ $loop->count }}">

                                            <x-button.danger type="button"
                                                wire:click="remove_role('{{ $role->name }}')"
                                                wire:confirm="are your sure delete this role" class="w-min">
                                                <x-svg.trash />

                                            </x-button.danger>

                                        </td>
                                    </tr>
                                @else
                                    <tr class="border-b dark:border-gray-700" wire:key="{{ $permission_count }}">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $permission_count }}
                                        </th>
                                        <td class="px-4 py-3"> {{ $permission->name }} </td>

                                    </tr>
                                @endif
                            @empty
                                <tr class="border-b dark:border-gray-700" wire:key="{{ $role->name }}">
                                    <td scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        #
                                    </td>
                                    <td class="px-4 py-3"> {{__("string.This role don't have any permissions") }} </td>
                                    <td class="px-4 py-3 dark:border-gray-700  border">
                                        {{ $role->name }}
                                    </td>

                                    <td
                                        class="px-4 py-3   border dark:border-gray-700 flex-row md:justify-center gap-2">

                                        <x-button.danger type="button"
                                            wire:click="remove_role('{{ $role->name }}')"
                                            wire:confirm="are your sure delete this role" class="w-min">
                                            <x-svg.trash />

                                        </x-button.danger>

                                    </td>
                                </tr>
                            @endforelse

                        @endforeach

                    </tbody>
                </table>

            @endif
        </div>





    </div>
</section>
