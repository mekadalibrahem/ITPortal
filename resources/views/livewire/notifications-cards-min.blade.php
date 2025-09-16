<x-widgets.section title="{{ __('string.notifications') }}">
    <div class="grid gap-8 lg:grid-cols-3 ">

        @forelse ($notifications as $notification)
            <article wire:key="{{ $notification->id }}"
                class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between items-center mb-5 text-gray-500">
                    <button wire:click='markread({{ $notification->id }})'
                        class="bg-green-200 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-800">
                        {{ __('string.Mark as read') }}
                    </button>
                    <span class="text-sm">{{ $notification->date() }}</span>
                </div>
                {{-- <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">
        </a></h2> --}}
                <p class="mb-5   text-xl  font-light text-gray-900 dark:text-white">
                    {!! $notification->content ?? ' ' !!}
                </p>
                <div class="flex justify-between items-center">

                    <a href="{{ route('user.notification.index') }}"
                        class="inline-flex items-center font-medium text-blue-600 dark:text-primary-500 hover:underline">
                        {{ __('string.Show notifications') }}
                    </a>
                </div>
            </article>


        @empty
            <p>
                {{ __('string.Empty notifications') }}
            </p>
        @endforelse
</x-widgets.section>
