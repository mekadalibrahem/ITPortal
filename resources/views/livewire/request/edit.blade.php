<x-widgets.section title="{{ __('string.Edit Request Information') }}">



    <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="name" name="name"
        label="{{ __('string.Name') }}" wire:model='name' />
    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="type "> {{ __('string.Type') }} </x-form.label>
        <select type="text" name="type" id="type" wire:model="type"
            class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

            @foreach ($types as $t)
                @php
                    $selected = 'selected';
                    if ($t->id == $req->type_id) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }

                @endphp
                <option value="{{ $t->id }}" {{ $selected }}>
                    {{ $t->type }}
                </option>
            @endforeach

        </select>
        @error('type')
            <x-alert.alert type="danger" :message="$message" />
        @enderror
    </div>
    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="department "> {{ __('string.Department') }} </x-form.label>
        <select type="text" name="department" id="department" wire:model="department"
            class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

            @foreach ($departments as $dep)
                @php
                    $sele_dep = 'selected';
                    if ($dep->id == $req->to_department) {
                        $sele_dep = 'selected';
                    } else {
                        $sele_dep = '';
                    }

                @endphp
                <option value="{{ $dep->id }}" {{ $sele_dep }}>
                    {{ $dep->name }}
                </option>
            @endforeach
        </select>
        @error('department')
            <x-alert.alert type="danger" :message="$message" />
        @enderror
    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="active">
            {{ __('string.Active') }}
        </x-form.label>

        <input type="checkbox" name="active" id="active" wire:model="active" {{ $active ?? 'checked' }}
            class="border border-salte-300 text-salte-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-blue-600 focus:border-blue-600 block  p-2.5 dark:bg-salte-700 bg-red dark:border-salte-600 dark:placeholder-salte-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        @error('active')
            <x-alert.alert type="danger" :message="$message" />
        @enderror

    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-4">
        <x-button status="primary" type="button" wire:click="edit()">

            {{ __('string.Edite') }}
        </x-button>
    </div>



</x-widgets.section>
