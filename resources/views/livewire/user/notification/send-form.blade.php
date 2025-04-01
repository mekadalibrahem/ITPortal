<x-widgets.section title="{{ __('string.send notification') }}">


    <form action="" class="w-full">
        @csrf
        @if ($status !== [])
            <x-alert.alert :type="$status['type']" :message="$status['message']" />
            <?php $status = []; ?>
        @else
        @endif
        <div class="grid grid-cols-1 lg:grid-cols-3 grid-flow-row  gap-3  ">
            <x-widgets.input divstyle="md:col-span-3" id="email" name="email"
            label="{{ __('string.email') }}" wire:model='email' />
          

            <div class="md:col-span-3">
                <x-form.label> {{ __('string.content') }} </x-form.label>
                <textarea type="text" name="content" id="content" wire:model="content"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required=""></textarea>
                @error('content')
                    <x-alert.alert type="danger" :message="$message" />
                @enderror
            </div>
            <x-button status="primary" type="button" class="col-span-1" wire:click="send()">
                {{ __('string.Send') }}
            </x-button>

    </form>
</x-widgets.section>
