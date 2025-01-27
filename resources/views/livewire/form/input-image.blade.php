<x-paragraphs.p class="grid grid-cols-2">

    <x-form.input type="file" id="{{ $item->name }}"
        name="{{ $item->name }}" wire:model="request_data.{{ $item['name'] }}"
        value="{{ $item['value'] }}" />

    @if (isset($request_data[$item['name']]))
        <img src="{{ $request_data[$item['name']]->temporaryUrl() }}"
            alt="alt_{{ $item['name'] }}" class="rounded-lg" />
    @elseif($item['value'])
        <img src="{{ asset('uploads/request_photos/' . $item['value']) }}"
            alt="alt_{{ $item['name'] }}" class="rounded-lg" />
    @endif
</x-paragraphs.p>
