<div class="flex  gap-x-2 items-center">
    <x-button status="primary" wire:click="edit({{ $row->id }})" size='sm'>
        <x-svg.edit />
    </x-button>
    @if ($row->trashed())
        <x-button status="primary" wire:click="restore({{ $row->id }})" size='sm'>
            <x-svg.undo />
        </x-button>
    @else
        <x-button status="danger" wire:click="delete({{ $row->id }})" size='sm'
            wire:confirm="{{ $confirm_delete_message }}">
            <x-svg.trash />
        </x-button>
    @endif
</div>
