<x-widgets.section title="{{ __('string.request_template.edit') }}">





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
            <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="description" name="description"
                label="{{ __('string.Description') }}" wire:model='description' />

        </x-widgets.step-section>

        <x-widgets.step-section show="{{ $step == 2 }}">
            <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="selected_step" name="selected_step"
                label="{{ __('string.selected item') }}" wire:model='selected_step' />
            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                <x-form.label for="template_step"> {{ __('string.step.name') }} </x-form.label>
                <select type="text" name="template_step" id="template_step" wire:model="template_step"
                    wire:change="updateDescription"
                    class="bg-cyan-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0">
                        {{ __('string.step.select') }}
                    </option>
                    @forelse ($steps as $i)
                        <option value="{{ $i->id }}">
                            {{ $i->name }}
                        </option>
                    @empty
                    @endforelse
                </select>
                @error('template_step.role')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-2 mb-3 grid grid-cols-3 gap-2">
                @if ($selectedStepDescription)
                    <div class="block text-sm text-gray-500 dark:text-neutral-500">
                        {{ __('string.Description') }}
                    </div>
                    <div class="block text-sm text-gray-500 dark:text-neutral-500">
                        {{ $selectedStepDescription ?? ' ' }}
                    </div>
                @endif
            </div>
            <x-widgets.input divstyle="sm:col-span-2 mb-3 grid grid-cols-3 gap-2 " id="order" name="order"
                label="{{ __('string.order') }}" wire:model='order' />

            <div class="sm:col-span-2 mb-3 grid grid-cols-4 gap-2">
                <x-button status="primary" wire:click='addTemplateStep()' block={{ false }}>
                    {{ __('string.Add') }}
                </x-button>
            </div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr class="text-center">
                        <th scope="col" class="text-center">


                           #

                        </th>

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

                        <th scope="col" class=" text-center">
                            {{ __('string.Options') }}
                        </th>
                        <th scope="col" class=" text-center">
                            {{ __('string.Actions') }}
                        </th>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse ($original_tempalte_steps as $key => $item)
                        <tr wire:key="{{ $key }} " class="text-center cursor-pointer"
                            wire:click="select_row('{{ $key }}')">
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $key }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->description }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['order'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $departments->where('id',$item['step']->department_id)->first()->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->role }}
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
                            <td colspan='4' class="text-center">
                                {{ __('string.Empty') }}
                            </td>
                        </tr>
                    @endforelse


                    @forelse ($template_steps as $item)
                        <tr wire:key="{{ $item['key'] }} " class="text-center">
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    #
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->description }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['order'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $departments->where('id',$item['step']->department_id)->first()->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->role }}
                                </div>
                            </td>
                            
                            <td class="size-px whitespace-nowrap">
                                <button type="button" wire:click="removeTemplaeStep('{{ $item['key'] }}')"
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

            <h3> {{ __('text.Your request info will saved') }} </h3>
            <div class="flex flex-col gap-4">
                <div class="space-y-3">
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">{{ __('string.Name') }}
                                :</span>
                        </dt>
                        <dd>

                            {{ $name }}

                        </dd>
                    </dl>
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                {{ __('string.description') }} :</span>
                        </dt>
                        <dd>

                            {{ $description }}
                        </dd>
                    </dl>



                </div>

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


                            {{ __('string.order') }}

                        </th>
                        <th scope="col" class=" text-center">


                            {{ __('string.Department') }}

                        </th>
                        <th scope="col" class=" text-center">


                            {{ __('string.Role') }}

                        </th>
                        <th scope="col" class=" text-center">
                            {{ __('string.Actions') }}
                        </th>
                    </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse ($original_tempalte_steps as $key => $item)
                    <tr wire:key="{{ $key }} " class="text-center cursor-pointer"
                        wire:click="select_row('{{ $key }}')">
                         <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->description }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['order'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $departments->where('id',$item['step']->department_id)->first()->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->role }}
                                </div>
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
                            <td colspan='4' class="text-center">
                            
                            </td>
                        </tr>
                    @endforelse
                    @forelse ($template_steps as $item)
                        <tr wire:key="{{ $item['key'] }} " class="text-center">
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->description }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['order'] }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $departments->where('id',$item['step']->department_id)->first()->name }}
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div>
                                    {{ $item['step']->role }}
                                </div>
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
