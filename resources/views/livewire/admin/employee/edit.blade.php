<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class=" max-w-screen-xl ">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-auto">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="add-tab" data-tabs-target="#add"
                            type="button" role="tab" aria-controls="add" aria-selected="false">
                            {{ __('string.Add or Edit') }}
                        </button>
                    </li>
                    <!-- <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="update-tab" data-tabs-target="#update" type="button" role="tab" aria-controls="update" aria-selected="false">تعديل</button>
                    </li> -->

                </ul>
            </div>
            <div id="default-tab-content">
                <div class="flex flex-col gap-4  p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="add"
                    role="tabpanel" aria-labelledby="add-tab">

                    @if (session()->has('status'))
                        @php
                            $status = session()->get('status');
                        @endphp
                        <x-alert.alert :type="$status['type']" :message="$status['message']" />
                    @endif

                    <div class="grid grid-cols-4 gap-2 ">
                        <x-form.label for="ssn">
                            {{ __('string.SSN') }}
                        </x-form.label>
                        <x-form.input type="text" name="ssn" id="ssn" wire:model="ssn"
                            wire:change="index()" />
                        @error('ssn')
                            <x-alert.alert type="danger" :message="$message" />
                        @enderror
                    </div>
                    <div class="grid grid-cols-4 gap-2 ">
                        <x-form.label for="email">
                            {{ __('string.email') }}
                        </x-form.label>
                        <x-form.input type="email" name="email" id="email" wire:model="email"   />
                        @error('email')
                            <x-alert.alert type="danger" :message="$message" />
                        @enderror

                    </div>

                    <div class="grid grid-cols-4 gap-2">
                        <x-form.label for="department">
                            {{ __('string.Department') }}
                        </x-form.label>
                        <select type="text" name="department" id="department" wire:model="department"
                            class="basis-1/2 bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="0">
                                {{ __('string.Select Department') }}
                            </option>
                            @foreach ($departments as $dep)
                                @if ($dep->id == $current_dep)
                                    <option value="{{ $dep->id }}" selected>
                                        {{ $dep->name }}
                                    </option>
                                @else
                                    <option value="{{ $dep->id }}">
                                        {{ $dep->name }}
                                    </option>
                                @endif
                            @endforeach


                        </select>
                    </div>

                    <div class="grid grid-cols-4 gap-4">

                        <x-button.primary type="button" wire:click="add()">

                            {{ __('string.Add') }}

                        </x-button.primary>
                        <x-button.primary type="button" wire:click="edit()">

                            {{ __('string.Edite') }}

                        </x-button.primary>
                    </div>




                </div>

            </div>
        </div>
    </div>
</section>
