@props(['header' => ' '])

<div class="flex  justify-between items-center  gap-2 mb-2">
    <div class="flex gap-2">

        <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
            {{ $header ?? ' ' }}

        </p>
        @if ($this->hasExport())
            <button class="text-xs " wire:click='export()'>
                <svg class="w-6 h-6 text-blue-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2" />
                </svg>

            </button>
        @endif
    </div>
    @if ($this->hasYearFilter())
        <div class="grid  grid-cols-1 md:grid-cols-2 gap-2">

            <input type="number" id="hs-floating-input-from-year-value" wire:model='from_year'
                wire:change='update_chart()'
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                plasholder ="{{ __('string.data.from_year') }}" />



            <input type="number" id="hs-floating-input-to-year-value" wire:model='to_year' wire:change='update_chart()'
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                plasholder ="{{ __('string.data.to_year') }}" />


        </div>
    @endif


</div>
