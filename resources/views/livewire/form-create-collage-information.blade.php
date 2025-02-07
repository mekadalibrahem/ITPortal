<form action="#" wire:submit="create">

    <div class="sm:col-span-2 mb-3 flex flex-row ">
        <label for="name" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{__("string.Name")}}
        </label>
        <input type="text" wire:model='name' name="name" id="name"
            class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            required="">

        @error('name')
        <x-alert.alert type="danger" :message='$message' /> @enderror
    </div>

    <div class="sm:col-span-2 mb-3 flex flex-row ">
        <label for="value" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{__("string.Value")}}
        </label>
        <input type="text" wire:model='value' name="value" id="value"
            class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            required="">
        @error('value')
        <x-alert.alert type="danger" :message='$message' /> @enderror

    </div>


    <div class="sm:col-span-2 mb-3">

        <x-button status="primary">
            {{__("string.Add")}}

        </x-button>
    </div>



</form>
