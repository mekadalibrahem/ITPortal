<x-widgets.section title="{{ __('string.New Request') }}">





    <div class="mt-5 sm:mt-8">
        <div class="px-6 py-3">
            <div class="flex items-center gap-x-3">
                <span class="text-xs text-gray-500 dark:text-neutral-500">{{ $step }}/{{ $max_step }}</span>
                <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
                    <div class="flex flex-col justify-center overflow-hidden bg-gray-800 dark:bg-neutral-200"
                        role="progressbar" style="width: {{ ($step / $max_step) * 100 }}%"
                        aria-valuenow="{{ ($step / $max_step) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <x-widgets.step-section show="{{ $step == 1 }}">

            <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="name" name="name"
                label="{{ __('string.Name') }}" wire:model='name' />
            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                <x-form.label for="type "> {{ __('string.Type') }} </x-form.label>
                <select type="text" name="type" id="type" wire:model="type"
                    class=" bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0">
                        {{ __('string.Select request type') }}
                    </option>
                    @forelse ($types as $t)
                        <option value="{{ $t->id }}">
                            {{ $t->type }}
                        </option>
                    @empty
                    @endforelse

                </select>
                @error('type')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                <x-form.label for="page "> {{ __('string.slut.name') }} </x-form.label>
                <select type="text" name="page" id="page" wire:model="page"
                    class="  bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0">
                        {{ __('string.slut.select') }}
                    </option>
                    @forelse ($pages as $t)
                        <option value="{{ $t->id }}">
                            {{ $t->name }}
                        </option>
                    @empty
                    @endforelse
                </select>
                @error('page')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2  ">
                <x-form.label for="active">
                    {{ __('string.Active') }}
                </x-form.label>
                <input type="checkbox" name="active" id="active" wire:model="active"
                    class=" border border-gray-300 text-gray-900 sm:text-sm rounded-lg bg-cyan-50 focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 bg-red dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                @error('active')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

            </div>
            <div class="sm:col-span-2 mb-3 grid grid-cols-4 gap-2">

                <x-button status="primary" wire:click='resetData(1)' block={{ false }}>
                    {{ __('string.reset') }}
                </x-button>
            </div>
        </x-widgets.step-section>

        <x-widgets.step-section show="{{ $step == 2 }}">
            <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="data_name" name="data_name"
                label="{{ __('string.Name') }}" wire:model='data_name' />
            <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="data_name_en" name="data_name_en"
                label="{{ __('string.name_en') }}" wire:model='data_name_en' />
            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                <x-form.label for="datatype "> {{ __('string.Type') }} </x-form.label>
                <select type="text" name="datatype" id="datatype" wire:model="datatype"
                    class="  bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0">
                        {{ __('string.Type') }}
                    </option>
                    @forelse ($dataTypes as $key =>$value)
                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @empty
                    @endforelse
                </select>
                @error('datatype')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-2 mb-3 grid grid-cols-4 gap-2">
                <x-button status="primary" wire:click='addData()' block={{ false }}>
                    {{ __('string.Add') }}

                </x-button>
                <x-button status="primary" wire:click='resetData(2)' block={{ false }}>
                    {{ __('string.reset') }}
                </x-button>
            </div>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr class="text-center">


                        <th scope="col" class="text-center">


                            {{ __('string.Name') }}

                        </th>

                        <th scope="col" class=" text-center">


                            {{ __('string.name_en') }}

                        </th>

                        <th scope="col" class=" text-center">


                            {{ __('string.Type') }}

                        </th>
                        <th scope="col" class=" text-center">
                            {{ __('string.Options') }}
                        </th>
                        <th scope="col" class=" text-center">
                            {{ __('string.Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse ($requiredDataOriginal as $key =>$item)
                        <tr wire:key="{{ $key }} " class="text-center">
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['name'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['name_en'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['type'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                @if ($item['delete'] == '0')
                                    <button type="button" wire:click="removeOrginalData('{{ $key }}')"
                                        class=" text-red-400 hover:text-red-200 shrink-0 size-4 inline-flex items-center justify-center rounded-full ">

                                        <x-svg.trash />
                                    </button>
                                @endif
                                @if ($item['delete'] == '1' || $item['changed'] == '1')
                                    <button type="button" wire:click="restorOrginalData('{{ $key }}')"
                                        class=" text-sky-400 hover:text-sky-200 shrink-0 size-4 inline-flex items-center justify-center rounded-full ">

                                        <x-svg.undo />
                                    </button>
                                @endif

                            </td>
                            <td class="size-px whitespace-nowrap">
                                @if ($item['delete'] == '1')
                                    {{ __('string.Delete') }}
                                @elseif ($item['changed'] == '1')
                                    {{ __('string.Edite') }}
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>

                        </tr>
                    @endforelse
                    @forelse ($dataRequired as $item)
                        <tr wire:key="{{ $loop->index }} " class="text-center">
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['name'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['name_en'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['type'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <button type="button" wire:click="removeData('{{ $item['name'] }}')"
                                    class=" text-red-400 hover:text-red-200 shrink-0 size-4 inline-flex items-center justify-center rounded-full ">

                                    <x-svg.trash />
                                </button>
                            </td>
                            <td class="size-px whitespace-nowrap">

                                {{ __('string.Add') }}

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan='4' class="text-center">
                                {{ __('string.Empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </x-widgets.step-section>

        <x-widgets.step-section show="{{ $step == 3 }}">
            <div class="sm:col-span-2 mb-3 grid grid-cols-4 gap-2">
                <x-form.label for="template">{{ __('string.request_template.name') }}</x-form.label>
                <select name="template_id" id="template_id" wire:model.live="template_id"
                    class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    wire:loading.attr="disabled">
                    <option value="0">{{ __('string.request_template.create or select one') }}</option>
                    @forelse ($templates as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('template_id')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            @if ($template_id == 0)
                <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-4 gap-2" id="template_name"
                    name="template_name" label="{{ __('string.Name') }}" wire:model='template_name' />
                <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-4 gap-2" id="template_disc"
                    name="template_disc" label="{{ __('string.Description') }}" wire:model='template_disc' />
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50 dark:bg-neutral-800">
                        <tr class="text-center">


                            <th scope="col" class="text-center">


                                {{ __('string.Name') }}

                            </th>

                            <th scope="col" class=" text-center">


                                {{ __('string.Description') }}

                            </th>

                            <th scope="col" class=" text-center">


                                {{ __('string.order') }}

                            </th>
                            <th scope="col" class=" text-center">


                                {{ __('string.Department') }}

                            </th>
                            <th scope="col" class=" text-center">


                                {{ __('string.Role') }}

                            </th>

                          
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @php
                            $template_item = $templates->find($template_id);

                        @endphp

                        @forelse ($template_item->order_steps as $item)
                            <tr wire:key="{{ $item['id'] }} " class="text-center">
                                <td class="size-px whitespace-nowrap">
                                    <div>
                                        {{ $item->step->name }}
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div>
                                        {{ $item->step->description }}

                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div>

                                        {{ $item->order }}
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div>

                                        {{ $item->step->department->name }}
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div>
                                        {{ $item->step->role }}

                                    </div>
                                </td>
                              
                        @empty
                            <tr>
                                <td colspan='6' class="text-center">
                                    {{ __('string.Empty') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

        </x-widgets.step-section>

        <x-widgets.step-section show="{{ $step == 4 }}">
            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                <x-form.label for="template_step">{{ __('string.step.name') }}</x-form.label>
                <select name="template_step" id="template_step" wire:model.live="template_step"
                    class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    wire:loading.attr="disabled">
                    <option value="0">{{ __('string.request_template.create or select one') }}</option>
                    @forelse ($template_steps as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('template_step')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

            </div>

            @if ($template_step == 0)
                <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="step_name"
                    name="step_name" label="{{ __('string.Name') }}" wire:model='step_name' />
                <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="step_description"
                    name="step_description" label="{{ __('string.Description') }}" wire:model='step_description' />

                <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                    <x-form.label for="step_department "> {{ __('string.Department') }} </x-form.label>
                    <select type="text" name="step_department" id="step_department" wire:model="step_department"
                        class="  bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="0">
                            {{ __('string.Select Department') }}
                        </option>
                        @forelse ($departments as $dep)
                            <option value="{{ $dep->id }}">
                                {{ $dep->name }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                    @error('step_department')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                    <x-form.label for="step_role "> {{ __('string.Role') }} </x-form.label>
                    <select type="text" name="step_role" id="step_role" wire:model="step_role"
                        class="  bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="0">
                            {{ __('string.select role') }}
                        </option>
                        @forelse ($roles as $key => $value)
                            <option value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                    @error('step_role')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            @endif
            <div>
                <x-button wire:click='addStep()'>
                    {{ __('string.Add') }}
                </x-button>
            </div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr class="text-center">


                        <th scope="col" class="text-center">


                            {{ __('string.Name') }}

                        </th>

                        <th scope="col" class=" text-center">


                            {{ __('string.Description') }}

                        </th>


                        <th scope="col" class=" text-center">


                            {{ __('string.Department') }}

                        </th>
                        <th scope="col" class=" text-center">


                            {{ __('string.Role') }}

                        </th>

                        <th scope="col" class=" text-center">
                            {{ __('string.Delete') }}
                        </th>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">


                    @forelse ($template_steps_list as $key => $i)
                        @php
                            $item = $i['step'];

                        @endphp

                        <tr wire:key="{{ $key }} " class="text-center">
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['name'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['description'] }}

                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>

                                    {{ $departments->find($item['department_id'])->name }}

                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['role'] }}

                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <button type="button" wire:click="removeStep({{ $key }})"
                                    class=" text-red-400 hover:text-red-200 shrink-0 size-4 inline-flex items-center justify-center rounded-full ">

                                    <x-svg.trash />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan='6' class="text-center">
                                {{ __('string.Empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-widgets.step-section>

        <x-widgets.step-section show="{{ $step == 5 }}">
            @if ($step == 5)
                <h3> {{ __('text.Your request info will saved') }} </h3>
                <div class="flex flex-col gap-4">
                    <div class="space-y-3">
                        <dl class="flex flex-col sm:flex-row gap-1">
                            <dt class="min-w-40">
                                <span
                                    class="block text-sm text-gray-500 dark:text-neutral-500">{{ __('string.Name') }}
                                    :</span>
                            </dt>
                            <dd>

                                {{ $name }}

                            </dd>
                        </dl>
                        <dl class="flex flex-col sm:flex-row gap-1">
                            <dt class="min-w-40">
                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                    {{ __('string.Type') }} :</span>
                            </dt>
                            <dd>

                                {{ $types[$type - 1]->type }}

                            </dd>
                        </dl>
                        <dl class="flex flex-col sm:flex-row gap-1">
                            <dt class="min-w-40">
                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                    {{ __('string.Active') }}:</span>
                            </dt>
                            <dd>

                                @if ($active > 0)
                                    <span
                                        class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                        <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                        {{ __('string.Active') }}
                                    </span>
                                @else
                                    <span
                                        class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full dark:bg-yellow-500/10 dark:text-yellow-500">
                                        <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </svg>
                                        {{ __('string.UnActive') }}
                                    </span>
                                @endif

                            </dd>
                        </dl>

                    </div>

                </div>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50 dark:bg-neutral-800">
                        <tr>


                            <th scope="col" class="text-start">

                                {{ __('string.Name') }}

                            </th>

                            <th scope="col" class="text-start">

                                {{ __('string.name_en') }}

                            </th>

                            <th scope="col" class="text-start">

                                {{ __('string.Type') }}

                            </th>
                            <th scope="col" class=" text-center">
                                {{ __('string.Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @forelse ($requiredDataOriginal as $key => $item)
                            <tr wire:key="{{ $key }} " class="text-center">
                                <td class="size-px whitespace-nowrap">

                                    {{ $item['name'] }}

                                </td>
                                <td class="size-px whitespace-nowrap">

                                    {{ $item['name_en'] }}

                                </td>
                                <td class="size-px whitespace-nowrap">

                                    {{ $item['type'] }}

                                </td>
                                <td class="size-px whitespace-nowrap">
                                    @if ($item['delete'] == '1')
                                        {{ __('string.Delete') }}
                                    @elseif ($item['changed'] == '1')
                                        {{ __('string.Edite') }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        @forelse ($dataRequired as $item)
                            <tr wire:key="{{ $loop->index }} " class="text-center">
                                <td class="size-px whitespace-nowrap">

                                    {{ $item['name'] }}

                                </td>
                                <td class="size-px whitespace-nowrap">

                                    {{ $item['name_en'] }}

                                </td>
                                <td class="size-px whitespace-nowrap">

                                    {{ $item['type'] }}

                                </td>
                                <td class="size-px whitespace-nowrap">


                                    {{ __('string.Add') }}

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan='3'>
                                    {{ __('string.Empty') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                  <div>
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                {{ __('string.request_template.name') }} :</span>
                        </dt>
                        <dd>

                            @if ($template_id)
                                {{ $templates->find($template_id)->name }}
                            @else
                                {{ $template_name }}
                            @endif
                        </dd>
                    </dl>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-800">
                            <tr class="text-center">


                                <th scope="col" class="text-center">


                                    {{ __('string.Name') }}

                                </th>

                                <th scope="col" class=" text-center">


                                    {{ __('string.Description') }}

                                </th>


                                <th scope="col" class=" text-center">


                                    {{ __('string.Department') }}

                                </th>
                                <th scope="col" class=" text-center">


                                    {{ __('string.Role') }}

                                </th>


                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">


                            @forelse ($template_steps_list as $key => $i)
                                @php
                                    $item = $i['step'];

                                @endphp

                                <tr wire:key="{{ $key }} " class="text-center">
                                    <td class="size-px whitespace-nowrap">
                                        <div>
                                            {{ $item['name'] }}
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div>
                                            {{ $item['description'] }}

                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div>

                                            {{ $departments->find($item['department_id'])->name }}

                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div>
                                            {{ $item['role'] }}

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan='6' class="text-center">
                                        {{ __('string.Empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </x-widgets.step-section>
    </div>









    <!-- Button Group -->
    <div class="mt-5 flex justify-between items-center gap-x-2">
        <button type="button"
            class=" py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            {{ $step == 1 ? 'disabled' : '' }} wire:click="back()">

            {{ __('string.back') }}
        </button>
        <button type="button"
            class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none {{ $isFinishStep ? 'hidden' : '' }}"
            wire:click="next()">
            {{ __('string.next') }}

        </button>
        <button type="button"
            class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
            style="display: none;">
            Finish
        </button>
        <x-button status="primary" wire:click='save()' class="{{ $isFinishStep ? '' : 'hidden' }}">
            {{ __('string.Save') }}
        </x-button>
    </div>

    </div>

    </div>


</x-widgets.section>
