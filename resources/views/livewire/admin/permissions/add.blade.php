<!--- Add new Role section  --->
<section class="bg-white  mx-full  rounded-lg  dark:bg-gray-900">
    <div class="max-w-2xl px-4 py-8 mx-auto ">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __("string.Add new permission") }}</h2>
        @if ($status !== [])
            <x-alert.alert :type="$status['type']" :message="$status['message']" />
        @endif
        <form wire:submit="store">
            @csrf
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <div class="sm:col-span-2">
                    <x-form.label for="name" value='{{__("string.Name")}}' />
                    <x-form.input type='text' wire:model='name' id="name" name='name' required />
                    @error('name')
                        <x-alert.alert type="danger" :message="$message" />
                    @enderror
                </div>

                <div class=" flex  items-center  space-x-4">
                    <x-button.primary type="submit" class="w-auto">
                        {{__("string.Save")}}
                    </x-button.primary>

                </div>
            </div>

        </form>
    </div>
</section>
