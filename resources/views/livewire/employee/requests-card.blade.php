<x-widgets.section title="{{__('string.Request details')}}">
            @if ($request_id > 0)
                <div
                    class="p-4 space-y-3 border border-blue-200 rounded-lg shadow-md md:space-y-0 md:space-x-4 md:flex md:items-center md:justify-between bg-blue-50 dark:bg-blue-900">
                    <div class="flex flex-col gap-2 text-blue-800 dark:text-blue-100">
                        <div class="font-semibold">{{ __('string.current status') }}:</div>
                        <div class="text-lg">{{ $request->status }}</div>
                    </div>
                    <div class="flex flex-col gap-2 text-blue-800 dark:text-blue-100">
                        <div class="font-semibold">{{ __('string.current employee') }}:</div>
                        <div class="text-lg">{{ $last_log_name }}, {{ $last_log_email }}</div>
                    </div>
                </div>

                <div
                    class="p-4 mt-4 space-y-3 border border-green-200 rounded-lg shadow-md md:space-y-0 md:space-x-4 md:flex md:items-center md:justify-between bg-green-50 dark:bg-green-900">
                    <div class="flex flex-col gap-2 text-green-800 dark:text-green-100">
                        <div class="font-semibold">{{ __('string.request user') }}:</div>
                        <div class="text-lg">{{ $request_user->fullname() }}</div>
                    </div>
                    <div class="flex flex-col gap-2 text-green-800 dark:text-green-100">
                        <div class="font-semibold">{{ __('string.ID number') }}:</div>
                        <div class="text-lg">{{ $request_user->national_id }}</div>
                    </div>
                </div>


                @if ($request_data)
                    <div class="mt-6 space-y-4">

                        @foreach ($request_data as $item)
                            <?php $name = $item['name']; ?>
                            <div class="grid gap-4 md:grid-cols-3" wire:key="{{ $item['id'] }}">
                                <x-form.label :for="$item['name']">{{ __("string.data.$name") }}</x-form.label>
                                <div class="col-span-2">
                                    @switch($item['type'])
                                        @case('string')
                                            <x-paragraphs.p
                                                class="text-gray-800 dark:text-gray-200">{{ $item['value'] }}</x-paragraphs.p>
                                        @break

                                        @case('image')
                                            <x-paragraphs.p>
                                                <img src="{{ asset('uploads/request_photos/' . $item['value']) }}"
                                                    alt="alt_{{ $item['name'] }}" class="rounded-lg" />
                                            </x-paragraphs.p>
                                        @break

                                        @default
                                            <x-paragraphs.p>{{ $item['value'] }}</x-paragraphs.p>
                                    @endswitch
                                </div>

                            </div>
                        @endforeach

                        @if ($current_employee->is_manager())
                            <div class="grid gap-6 md:grid-cols-3">
                                <div>
                                    <select id="dep_id" name="dep_id" wire:model="dep_id" wire:change="select_dep()"
                                        class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-primary-600 focus:border-primary-600">
                                        <option value="">{{ __('string.Select Department') }}</option>
                                        @forelse ($departments as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @empty
                                            <option value="">
                                                {{ __('string.dont have any employee in department') }}</option>
                                        @endforelse
                                    </select>
                                    @error('cancel_note')
                                        <x-alert.alert type="danger" :message="$message" />
                                    @enderror
                                </div>
                                <div class="col-span-1">
                                    <select id="emp_id" name="emp_id" wire:model="emp_id" wire:change="select_emp()"
                                        class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-primary-600 focus:border-primary-600">
                                        <option value="">{{ __('string.Select Employee') }}</option>
                                        @forelse ($dep_employees as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->user->fullname() }}</option>
                                        @empty
                                            <option value="">
                                                {{ __('string.dont have any employee in department') }}</option>
                                        @endforelse
                                    </select>
                                    @error('cancel_note')
                                        <x-alert.alert type="danger" :message="$message" />
                                    @enderror
                                </div>
                                <div class="col-span-1">
                                    <x-button  status="primary" type="button" wire:click="redirect_to_employee()">
                                        {{ __('string.Send To Employee') }}
                                    </x-button>
                                </div>

                            </div>
                        @else
                            <div class="grid gap-6 md:grid-cols-3">
                                <div class="col-span-2">
                                    <textarea name="redirect_note" id="redirect_note" wire:model="redirect_note"
                                        placeholder="{{ __('string.redirect notify') }}"
                                        class="col-span-2 block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-primary-600 focus:border-primary-600"></textarea>

                                </div>
                                <div class="col-span-1">
                                    <x-button status="primary" type="button"  wire:click="redirect_to_manager()">
                                        {{ __('string.Send To Manager') }}
                                    </x-button>
                                </div>

                            </div>
                        @endif

                        <div class="grid gap-2 md:grid-cols-3">
                            {{-- <x-form.label for="cancel_note">{{ __('string.cancel note title') }}</x-form.label> --}}
                            <textarea id="cancel_note" placeholder="{{ __('string.placholder_cancel_note') }}" name="cancel_note"
                                wire:model="cancel_note"
                                class="col-span-2 block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-primary-600 focus:border-primary-600"></textarea>
                            <div>
                                @error('cancel_note')
                                    <x-alert.alert type="danger" :message="$message" />
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-4 mt-4">
                            <x-button status="success" type="button"  wire:click="accept()">{{ __('string.accept') }}</x-button>
                            <x-button status="primary" type="button"  wire:click="cancel()">{{ __('string.cancel') }}</x-button>
                            <x-button status="danger " type="button" wire:click="reject()">{{ __('string.reject') }}</x-button>
                            <x-button status="primary" type="button"  wire:click="exportToPdf()">{{ __('string.Export') }}</x-button>
                        </div>
                    </div>
                @endif
            @endif
</x-widgets.section>
