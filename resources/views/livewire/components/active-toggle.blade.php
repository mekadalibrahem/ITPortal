@props(['id', 'isActive'])

<div class="flex items-center space-x-2 gap-1 ">
    <!-- Active Icon -->
    @if($isActive)
    
        <button
            wire:click="deactivate({{ $id }})"
            class="text-green-600 hover:text-green-800 transition-colors"
            title="{{ __('Disable') }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 101.414-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    @else
        <button
            wire:click="activate({{ $id }})"
            class="text-red-600 hover:text-red-800 transition-colors"
            title="{{ __('Enable') }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif

    <span class="text-sm font-medium text-gray-700">
        {{ $isActive ? __('string.Active') : __('string.UnActive') }}
    </span>
</div>