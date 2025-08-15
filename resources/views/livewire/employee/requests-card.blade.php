<x-widgets.section title="{{__('string.Request details')}}">
            @if ($request_id > 0)
            <livewire:request-card.steps-card  :id="$request_id"/>
                <div
                    class="p-4 space-y-3 border border-blue-200 rounded-lg shadow-md md:space-y-0 md:space-x-4 md:flex md:items-center md:justify-between bg-blue-50 dark:bg-blue-900">
                    <div class="flex flex-col gap-2 text-blue-800 dark:text-blue-100">
                        <div class="font-semibold">{{ __('string.current status') }}:</div>
                        <div class="text-lg">{{ $request->status }}</div>
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
                        
                        @if($can_work)
                        <div class="grid gap-2 md:grid-cols-3">
                            <x-form.label for="cancel_note">{{ __('string.cancel note title') }}</x-form.label>
                            <textarea id="cancel_note" placeholder="{{ __('string.placholder_cancel_note') }}" name="cancel_note"
                                wire:model="cancel_note"
                                class="col-span-2 block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-primary-600 focus:border-primary-600"></textarea>
                            <div>
                                @error('cancel_note')
                                    <x-alert.alert type="danger" :message="$message" />
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="grid gap-4 md:grid-cols-4 mt-4">
                            @if($can_work)
                            <x-button status="success" type="button"  wire:click="accept()">{{ __('string.accept') }}</x-button>
                            <x-button status="primary" type="button"  wire:click="cancel()">{{ __('string.askToedit') }}</x-button>
                            <x-button status="danger " type="button" wire:click="reject()">{{ __('string.reject') }}</x-button>
                            @endif
                            <x-button status="primary" type="button"  wire:click="exportToPdf()">{{ __('string.Export') }}</x-button>
                        </div>
                    </div>
                @endif
            @endif
</x-widgets.section>
