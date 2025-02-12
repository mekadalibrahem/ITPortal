<!-- Sidebar -->
<div id="hs-application-sidebar"
    class="top-14 hs-overlay  [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-[260px] h-full hidden fixed inset-y-0 start-0 z-[60] bg-white border-e border-slate-200 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 dark:bg-slate-800 dark:border-slate-700"
    role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">


        <!-- Content -->
        <div
            class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-slate-100 [&::-webkit-scrollbar-thumb]:bg-slate-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">
            <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>

                @hasrole('admin')
                <x-layouts.said-admin-page-link />
                @endhasrole

                @hasrole('employee')
                <x-layouts.said-employee-page-link />
                @endhasrole
            </nav>
        </div>
        <!-- End Content -->
    </div>
</div>
<!-- End Sidebar -->

<!-- Content -->

<div class="sticky top-0 inset-x-0  px-4 sm:px-6 lg:px-8   lg:ps-72">
    <div class="flex items-center py-2  ">
        <!-- Navigation Toggle -->
        <x-button type="button" size="sm" class="lg:hidden" aria-haspopup="dialog" aria-expanded="false"
            aria-controls="hs-application-sidebar" aria-label="Toggle navigation"
            data-hs-overlay="#hs-application-sidebar">
            <span class="sr-only">Toggle Navigation</span>
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="3" rx="2" />
                <path d="M15 3v18" />
                <path d="m8 9 3 3-3 3" />
            </svg>
        </x-button>
        <!-- End Navigation Toggle -->

        <!-- Breadcrumb -->
        <x-widgets.breadcrumb  />
        <!-- End Breadcrumb -->
    </div>
</div>
<div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
    {{$slot}}
</div>
<!-- End Content -->
<!-- ========== END MAIN CONTENT ========== -->
