<x-layouts.dashboard>

    <x-slot:title >
      type request
    </x-slot:title>

    <div class=" h-screen  overflow-visible  mb-4 m-10">
        <section class="pt-4 mb-4">
                <section class="bg-white dark:bg-gray-800" >
                    <div class="mb-4 border-b">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="add-tab" data-tabs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="false">إضافة  </button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="update-tab" data-tabs-target="#update" type="button" role="tab" aria-controls="update" aria-selected="false">تعديل</button>
                            </li>

                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <div class="hidden p-4 rounded-lg " id="add" role="tabpanel" aria-labelledby="add-tab">
                         <livewire:form-create-request-type />
                        </div>
                        <div class="hidden p-4 rounded-lg " id="update" role="tabpanel" aria-labelledby="update-tab">
                            <livewire:form-update-request-type />
                        </div>

                    </div>
                </section>
                    <!-- جدول انواع الطلبات المتوفرة  -->
                    <livewire:request-types-table />

        </section>
    </div>
</x-layouts.dashboard>




