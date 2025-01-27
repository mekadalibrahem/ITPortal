<form action="#"
wire:submit='edit'
>

@if ($msg = session()->get('update_collage_info_done'))
<div class="text-center">
    <x-alert.alert type='success' :message="$msg"  />
</div>
@endif
    <div class="sm:col-span-2 mb-3 flex flex-row">
        <label for="old_name" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          {{__("string.Name")}}
        </label>
        <input type="text" wire:model='old_name'  placeholder="اسم الحقل المراد تعديله"
            name="old_name" id="old_name" class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"  required="">

            @error('old_name')  <x-alert.alert type="danger"  :message='$message' />  @enderror
    </div>
    <div class="sm:col-span-2 mb-3 flex flex-row ">
        <label for="new_name" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{__("string.New Name")}}
        </label>
        <input type="text" wire:model='new_name'
            name="new_name" id="new_name" class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"  >

            @if ($msg = session()->get('name_exists'))
                <div class="text-center">
                    <x-alert.alert type='danger' :message="$msg"  />
                </div>
            @endif
            @error('new_name')  <x-alert.alert type="danger"  :message='$message' />  @enderror
    </div>

    <div class="sm:col-span-2 mb-3 flex flex-row ">
        <label for="new_value" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{__("string.Value")}}
        </label>
        <input type="text" wire:model='new_value'
            name="new_value" id="new_value" class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"  >
            @error('new_value')  <x-alert.alert type="danger"  :message='$message' />  @enderror

    </div>



    <div class="sm:col-span-2 mb-3">
        <button type="submit"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">

       {{__("string.Edite")}}
    </button>
    </div>



</form>
