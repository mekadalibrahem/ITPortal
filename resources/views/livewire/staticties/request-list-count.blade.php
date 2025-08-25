<div
    class="p-4 md:p-5 min-h-102.5 flex flex-col text-gray-800 dark:text-neutral-200  bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-slate-900 dark:border-slate-700">
    <x-widgets.chart-header :header="$header" />
    <div class="chart-container">
        <x-chartjs-component :chart="$this->chart" />
    </div>


</div>
