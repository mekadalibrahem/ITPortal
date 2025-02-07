<x-layouts.dashboard>

    <x-slot:title>
        department
    </x-slot:title>

    <div class=" h-screen  overflow-visible  mb-4 m-10">
        <section class="pt-4 mb-4">

            <section class=" bg-white  dark:bg-gray-700 shadow rounded">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="add-tab"
                                data-tabs-target="#add" type="button" role="tab" aria-controls="add"
                                aria-selected="false">
                                {{ __('string.Add') }}
                            </button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="update-tab" data-tabs-target="#update" type="button" role="tab"
                                aria-controls="update" aria-selected="false">
                                {{ __('string.Edite') }}
                            </button>
                        </li>

                    </ul>
                </div>


                <div id="default-tab-content">
                    {{-- add section --}}
                    <livewire:admin.department.create />
                    {{-- edit section --}}
                    <livewire:admin.department.edit />

                </div>
            </section>


            <livewire:admin.department.show />




            <livewire:admin.department.index />
        </section>


        </section>
    </div>
</x-layouts.dashboard>
