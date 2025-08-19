<x-widgets.section title="{{ __('string.Request details') }}">
    <livewire:request-card.steps-card :id="$id" hasnote="{{ false }}"/>



    <livewire:request-card.info-card hasexport="{{ false }}" :request="$req" />


    <div class="m-4">
        @if (!$req->is_end())
            @if ($data)
                <div class="mt-6 space-y-4 p-2">

                    @foreach ($data as $item)
                        @php
                            $name = $item->name;

                            $model = "request_data.$name";
                        @endphp

                        <div class="grid gap-4 md:grid-cols-3" wire:key="{{ $item->id }}">
                            <x-form.label :for="$item->name">{{ __("string.data.$name") }}</x-form.label>
                            @switch($item->type())
                                @case('string')
                                    <x-form.input id="{{ $item->name }}" wire:model="{{ $model }}"
                                        name="{{ $item->name }}" value="{{ $item->value }}" />
                                @break

                                @case('image')
                                    <x-form.input type="file" id="{{ $item->name }}" name="{{ $item->name }}"
                                        wire:model="{{ $model }}" value="{{ $item->value }}" />
                                @break

                                @default
                                    <x-form.input type="text" id="{{ $item->name }}" name="{{ $item->name }}"
                                        wire:model="{{ $model }}" value="{{ $item->value }}" />
                                @break
                            @endswitch


                        </div>
                    @endforeach








                </div>

            @endif

            <div class="grid gap-4 md:grid-cols-4 m-4">
                <x-button.primary type="button" wire:click="store()">{{ __('string.Save') }}</x-button.primary>
                @if ($req->is_draft())
                    <x-button.primary type="button" wire:click="store(true)">{{ __('string.Save as draft') }}
                    </x-button.primary>
                @endif
            </div>
        @else
            <div class="m-2 bg-blue-100 border border-blue-200 text-md text-blue-800 rounded-lg p-4 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500 font-bold">
              <span class="m-4" >  {{ __('messages.your request finished  , your can not edit it now') }}</span>
            </div>
        @endif

    </div>
  

</x-widgets.section>
