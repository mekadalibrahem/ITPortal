<div class="p-4 rounded-lg  bg-white dark:bg-gray-800" id="update" role="tabpanel" aria-labelledby="update-tab">

    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="old_name">
            {{ __('string.Old name') }}
        </x-form.label>
        <x-form.input type="text" name="old_name" id="old_name" wire:model="old_name" wire:change="index()" />
        @error('old_name')
            <x-alert.alert type="danger" :message="$message" />
        @enderror

    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="name">
            {{ __('string.Name') }}
        </x-form.label>
        <x-form.input type="text" name="name" id="name" wire:model="name" />
        @error('name')
            <x-alert.alert type="danger" :message="$message" />
        @enderror

    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="type "> {{ __('string.Type') }} </x-form.label>
        <select type="text" name="type" id="type" wire:model="type"
            class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.Select request type') }}
            </option>
            @forelse ($types as $t)
                @if ($req)
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
                @else
                    <option value="{{ $t->id }}">
                        {{ $t->type }}
                    </option>
                @endif

            @empty
            @endforelse

        </select>
        @error('type')
            <x-alert.alert type="danger" :message="$message" />
        @enderror
    </div>
    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="department "> {{ __('string.Department') }} </x-form.label>
        <select type="text" name="department" id="department" wire:model="department"
            class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="0">
                {{ __('string.Department') }}
            </option>
            @forelse ($departments as  $dep)
                @if ($req)
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
                @else
                    <option value="{{ $dep->id }}">
                        {{ $dep->name }}
                    </option>
                @endif
            @empty
            @endforelse
        </select>
        @error('department')
            <x-alert.alert type="danger" :message="$message" />
        @enderror
    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
        <x-form.label for="active">
            {{ __('string.Active') }}
        </x-form.label>
        <input type="checkbox" name="active" id="active" wire:model="active"
            class=" border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        @error('active')
            <x-alert.alert type="danger" :message="$message" />
        @enderror

    </div>

    <div class="sm:col-span-2 mb-3 grid grid-cols-4">
        <x-button.primary type="button" wire:click="edit()">

            {{ __('string.Edite') }}
        </x-button.primary>
    </div>



</div>
