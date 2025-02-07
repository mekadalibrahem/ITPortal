<!-- Buttons with Blade components -->
<div class="flex  gap-x-2 items-center">

    <!-- Edit Button -->
    <x-button
      status="primary"
      wire:click="edit({{ $row->id }})"
        size='sm'

    >
      <x-svg.edit/>
    </x-button>




  <x-button
  status="danger"
  wire:click="delete({{ $row->id }})"
  size='sm'

  wire:confirm="{{$confirm_delete_message}}"
>
<x-svg.trash/>
</x-button>
  </div>
