<div class="flex flex-col bg-white border border-indigo-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-indigo-700">
    <div class="flex items-center justify-between border-b border-indigo-200 rounded-t-lg py-3 px-4 dark:border-indigo-700">
        <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-100">
            {{ $request->requests->name }}
        </h3>
        <div class="flex items-center gap-2">
            @if ($hasexport)
                <div class="relative group">
                    <button type="button" wire:click="exportToPdf()"
                        class="p-2 rounded-full text-indigo-600 hover:bg-indigo-100 dark:text-indigo-300 dark:hover:bg-indigo-700 transition">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span
                            class="absolute hidden group-hover:block -top-10 left-1/2 -translate-x-1/2 px-2 py-1 bg-indigo-800 text-white text-xs rounded-md">
                            {{ __('string.Export') }}
                        </span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="p-4">
        <div class="flex flex-col gap-4">
            <div class="flex gap-4">
                <div class="flex gap-2 items-center">
                    <span class="font-medium text-indigo-800 dark:text-indigo-200">{{ __('string.current status') }}:</span>
                    <span class="text-base text-indigo-900 dark:text-indigo-100">{{ $request->status }}</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex gap-2 items-center">
                    <span class="font-medium text-indigo-800 dark:text-indigo-200">{{ __('string.request user') }}:</span>
                    <span class="text-base text-indigo-900 dark:text-indigo-100">{{ $request->user->fullname() }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <span class="font-medium text-indigo-800 dark:text-indigo-200">{{ __('string.ID number') }}:</span>
                    <span class="text-base text-indigo-900 dark:text-indigo-100">{{ $request->user->national_id }}</span>
                </div>
                <div class="flex gap-2 items-center">
                    <span class="font-medium text-indigo-800 dark:text-indigo-200">{{ __('string.email') }}:</span>
                    <span class="text-base text-indigo-900 dark:text-indigo-100">{{ $request->user->email }}</span>
                </div>
            </div>
            <h4 class="text-base font-semibold text-indigo-900 dark:text-indigo-100">{{ __('string.request data') }}:</h4>
            <div class="flex flex-col gap-2">
                @forelse ($request->data as $item)
                    <div wire:key="{{ $item->id }}" class="flex gap-2 items-center">
                        <span class="font-medium text-indigo-800 dark:text-indigo-200">{{ __("string.data.$item->name") }}:</span>
                        <div class="text-base text-indigo-900 dark:text-indigo-100">
                            @switch($item->type())
                                @case('string')
                                    {{ $item->value }}
                                @break
                                @case('image')
                                    <img src="{{ asset('/storage/request_photos/' . $item->value) }}"
                                        alt="alt_{{ $item->name }}" class="max-w-xs w-[200px] h-[200px]" />
                                @break
                                @default
                                    {{ $item->value }}
                                @break
                            @endswitch
                        </div>
                    </div>
                @empty
                    <p class="text-indigo-600 dark:text-indigo-400">dont have data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>