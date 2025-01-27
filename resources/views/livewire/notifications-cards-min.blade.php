<x-widgets.section title="{{ __('string.notifications') }}">
    <div class="grid gap-8 lg:grid-cols-3 ">

        @forelse ($notifications as $notification)
            <livewire:notifications-card :notification="$notification" />

        @empty
            <p>
                {{ __('string.Empty notifications') }}
            </p>
        @endforelse
</x-widgets.section>
