<x-widgets.section title="{{ __('string.New Request') }}">

    <div class="grid  grid-cols-1 md:grid-cols-2 gap-2">
        @if ($user->signature == null)
            {{ __('text.A signature is required before you can submit any requests.') }}
        @else
            <div class="flex flex-row gap-2">


                <select id="select_request" name='select_request' wire:model='select_request' wire:change="change_request()"
                    class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'>
                    <option> {{ __('string.Select request type') }} </option>
                    @foreach ($all_requests as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
    @if ($require_data)

        <div class="flex flex-col gap-2 justify-center mt-4">

            @foreach ($require_data as $item)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-4  " wire:key="{{ $item->id }}">
                    <x-form.label :for="$item->name_en">
                        {{ __("string.data.$item->name_en") }}
                    </x-form.label>
                    @switch($item->type)
                        @case('string')
                            <x-form.input id="{{ $item->name_en }}" name="{{ $item->name_en }}"
                                wire:model="request_data.{{ $item->name_en }}" />
                        @break

                        @case('image')
                            <x-form.input type="file" id="{{ $item->name_en }}" name="{{ $item->name_en }}"
                                wire:model="request_data.{{ $item->name_en }}" />
                        @break

                        @default
                            <x-form.input id="{{ $item->name_en }}" name="{{ $item->name_en }}"
                                wire:model="request_data.{{ $item->name_en }}" />
                        @break
                    @endswitch
                    @error("request_data.$item->name_en")
                        <x-alert.alert type="danger" :message="$message" />
                    @enderror


                </div>
            @endforeach
            <div class="grid grid-cols-1  md:grid-cols-2 gap-4">
                <x-button status="primary" wire:click="store()">
                    {{ __('string.Send') }}
                </x-button>
                <x-button wire:click="store(true)">
                    {{ __('string.Save as draft') }}
                </x-button>
            </div>
        </div>
    @endif

</x-widgets.section>
