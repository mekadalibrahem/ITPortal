<section
    class="pt-4 mx-auto max-w-2xl mb-4 bg-white  rounded-lg border border-gray-200 shadow-md dark:border-gray-700 dark:bg-gray-800 ">
    <div class="py-4 px-4 mx-auto max-w-2xl lg:py-4">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
            {{ __('string.send notification') }}
        </h2>

            @csrf
            @if ($status !== [])
                <x-alert.alert :type="$status['type']" :message="$status['message']" />
                <?php $status = [] ; ?>
            @else

            @endif
            <div class="grid grid-cols-1 lg:grid-cols-3 grid-flow-row  gap-3  ">
                <div class="md:col-span-3">
                    <x-form.label>{{ __('string.email') }}</x-form.label>
                    <x-form.input type="email" name="email" id="email" wire:model="email" />
                    @error('email')
                        <x-alert.alert type="danger" :message="$message" />
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <x-form.label> {{ __('string.content') }} </x-form.label>
                    <textarea type="text" name="content" id="content" wire:model="content"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required=""></textarea>
                        @error('content')
                        <x-alert.alert type="danger" :message="$message" />
                    @enderror
                </div>
                <x-button.primary type="button" class="col-span-1" wire:click="send()">
                    {{ __('string.Send') }}
                </x-button.primary>


    </div>
</section>
