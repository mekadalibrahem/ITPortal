<x-widgets.section title="{{ __('string.Request details') }}">


        <div
            class="p-4 space-y-3 border border-blue-200 rounded-lg shadow-md md:space-y-0 md:space-x-4 md:flex md:items-center md:justify-between bg-blue-50 dark:bg-blue-900">
            <div class="flex flex-col gap-2 text-blue-800 dark:text-blue-100">
                <div class="font-semibold">{{ __('string.current status') }}:</div>
                <div class="text-lg">{{ $req->status }}</div>
            </div>
            <div class="flex flex-col gap-2 text-blue-800 dark:text-blue-100">
                <div class="font-semibold">{{ __('string.current employee') }}:</div>
                @if ($last_log_name)
                <div class="text-lg">{{ $last_log_name }}, {{ $last_log_email }}</div>
                @else
                        {{-- not user work in it  --}}
                @endif
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


        @if ($data)
        <div class="mt-6 space-y-4">

            @foreach ($data as $item)
            @php
            $name = $item->name;

            $model = "request_data.$name";
            @endphp

            <div class="grid gap-4 md:grid-cols-3" wire:key="{{ $item->id }}">
                <x-form.label :for="$item->name">{{ __("string.data.$name") }}</x-form.label>




                @switch($item->type())
                @case('string')
                <x-form.input id="{{ $item->name }}" wire:model="{{ $model }}" name="{{ $item->name }}"
                    value="{{ $item->value }}" />
                <x-paragraphs.p>


                    {{ $item->value }}

                </x-paragraphs.p>
                @break

                @case('image')
                <x-form.input type="file" id="{{ $item->name }}" name="{{ $item->name }}" wire:model="{{ $model }}"
                    value="{{ $item->value }}" />
                <x-paragraphs.p>


                    <img src="{{ asset('uploads/request_photos/' . $item->value) }}" alt="alt_{{ $item->name }}" />

                </x-paragraphs.p>
                @break

                @default
                <x-form.input type="text" id="{{ $item->name }}" name="{{ $item->name }}" wire:model="{{ $model }}"
                    value="{{ $item->value }}" />
                <x-paragraphs.p>


                    {{ $item->value }}

                </x-paragraphs.p>
                @break
                @endswitch


            </div>
            @endforeach




            <div class="grid gap-4 md:grid-cols-4 mt-4">
                <x-button.primary type="button" wire:click="store()">{{ __('string.Save') }}</x-button.primary>
                <x-button.primary type="button" wire:click="store(true)">{{ __('string.Save as draft') }}
                </x-button.primary>
            </div>

        </div>

        @endif


</x-widgets.section>
