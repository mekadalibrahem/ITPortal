<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class=" max-w-screen-xl ">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-auto">
            <div class=" p-4 rounded-lg " id="update" role="tabpanel" aria-labelledby="update-tab">

                @if (session()->has('status'))
                    @php
                        $status = session()->get('status');
                    @endphp
                    <x-alert.alert :type="$status['type']" :message="$status['message']" />
                @endif
                <div class="sm:col-span-2 mb-3 flex flex-row ">
                    <label for="edit_old_department_name"
                        class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('string.old department name') }}
                    </label>
                    <select type="text" name="dep_id" id="dep_id" wire:model="dep_id" wire:change="index()"
                        class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        <option value="0" class="p-2">
                            {{ __('string.Select Department') }}
                        </option>
                        @foreach ($departments as $dep)
                            <option value="{{ $dep->id }}" class=" m-2 p-4">
                                {{ $dep->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2 mb-3 flex flex-row ">
                    <label for="name" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('string.New Name') }}
                    </label>
                    <input type="text" name="name" id="name" value="{{$name??''}}" wire:model="name"
                        class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                    @error('name')
                        <x-alert.alert type="danger" :message="$message" />
                    @enderror
                </div>
                <div class="sm:col-span-2 mb-3 flex flex-row ">
                    <label for="description" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('string.description') }}
                    </label>
                    <textarea type="text" name="description" id="description" wire:model="description"
                        class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">{{$description ?? ''}}</textarea>
                    @error('description')
                        <x-alert.alert type="danger" :message="$message" />
                    @enderror
                </div>

                <div class="sm:col-span-2 mb-3 flex flex-row ">
                    <label for="manager_id" class="basis-1/4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('string.department manager') }}
                    </label>
                    <select type="text" name="manager_id" id="manager_id" wire:model="manager_id"
                        class="basis-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="0">
                            {{ __('string.Select Manager') }}
                        </option>
                        @forelse ($allowed_employees as $emp)
                            @if ($emp->id == $manager_id)
                                <option value="{{ $emp->id }}" selected>
                                    {{ $emp->user->fullname() }}
                                </option>
                            @else
                            <option value="{{ $emp->id }}">
                                {{ $emp->user->fullname() }}
                            </option>
                            @endif

                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="sm:col-span-2 mb-3">

                    <button type="button" wire:click="edit()"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">

                        {{ __('string.Edite') }}

                    </button>
                </div>




            </div>

        </div>
    </div>
</section>


