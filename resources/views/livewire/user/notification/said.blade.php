<div class="h-screen overflow-auto">

    <!-- Tabs with Create Button -->
    <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <div class="flex">
            <button wire:click="setTab('all')"
                class="px-4 py-2 font-medium text-sm {{ $activeTab === 'all' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                {{ __('string.All notifications') }}
            </button>

            <button wire:click="setTab('sent')"
                class="px-4 py-2 font-medium text-sm {{ $activeTab === 'sent' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                {{ __('string.Sent') }}
            </button>

            <button wire:click="setTab('received')"
                class="px-4 py-2 font-medium text-sm {{ $activeTab === 'received' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                {{ __('string.Received') }}
            </button>
        </div>

      
        <button wire:click="createNew"
            class="flex items-center px-3 py-2 me-4  text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
            </svg>


        </button>
    </div>

    <!-- Notification List -->
    <ul class="max-w-md space-y-1 text-gray-500 list-none list-inside dark:text-gray-400">
        @forelse ($notify_list as $notify)
            <li class="p-4 m-4 border-b bg-white rounded-lg dark:bg-gray-700" wire:key="{{ $notify->id }}">
                <div class="flex justify-between items-center mb-5 text-gray-500">
                    @if (!$notify->is_read() && $notify->from_id != $user_id)
                        <span
                            class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                            {{ __('string.new notify') }}
                        </span>
                    @endif
                    <span class="text-sm">{{ $notify->date() }}</span>
                </div>

                <form action="">
                    @csrf
                    <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        <button type="button" wire:click="show({{ $notify->id }})">
                            {{ Str::limit($notify->content, 15) }}
                        </button>
                    </h2>
                </form>

                <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                    {{ $notify->from->email }}
                </p>
            </li>
        @empty
            <li class="p-4 text-gray-500 dark:text-gray-400">
                {{ __('text.Empty notifications') }}
            </li>
        @endforelse
    </ul>

</div>
