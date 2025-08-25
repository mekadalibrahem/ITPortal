<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Livewire\Staticties\Traits\HasOptions;
use App\Models\Department;
use App\Models\RequestTemplates\RequestTemplateStep;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AvarageTimeStep extends Component
{
    use WithChart;
    use HasOptions;
    public function mount()
    {
        $this->setChartLabels(RequestTemplateStep::select('name', 'id')->orderBy('id')->pluck('name')->toArray());
        $this->setChartName('request_step_avg_time');
        $this->setChartType('horizontalBar');
        $this->setHeader(trans('string.step_performance_avg_time'));
        $this->setExportHeadings(['step', 'average duration (hours)']);
    }

    public function data(): array
    {

        // Get all departments first to ensure we have all of them
        $allDepartments = RequestTemplateStep::select('id', 'name')->orderBy('id')->get();

        $query = RequestTemplateStep::leftJoin('request_logs', function ($join) {
            $join->on('request_tamplates_steps.id', '=', 'request_logs.request_tamplates_step_id')
                ->whereNotNull('request_logs.end_at');
        })
            ->select(
                'request_tamplates_steps.id',
                DB::raw('COALESCE(AVG(TIMESTAMPDIFF(SECOND, request_logs.start_at, request_logs.end_at) / 3600), 0) as avg_duration_hours')
            );

       
        if ($this->hasYearFilter()) {
            if (!empty($this->from_year)) {
                 $query->whereYear('request_logs.created_at' , '>=' , $this->from_year);
            }
            if (!empty($this->to_year)) {
                $query->whereYear('request_logs.created_at' , '<=' , $this->to_year);
            }
        }
       

        $results = $query
            ->groupBy('request_tamplates_steps.id')
            ->orderBy('request_tamplates_steps.id')
            ->get();

        // Create a map of department IDs to their average duration
        $departmentAverages = $results->pluck('avg_duration_hours', 'id')->toArray();

        // Build the final data array ensuring all departments are included
        $finalData = [];
        foreach ($allDepartments as $department) {
            $finalData[] = $departmentAverages[$department->id] ?? 0;
        }

        return [$finalData];
    }
    public function getDatasets(): array
    {

        $data =  $this->data();

        $colors = $this->getColorsInstance(count($this->getChartLabels()), count($data));

        return [
            Dataset::make("Average Processing Time (hours)", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }
    public function render()
    {
        $this->getData();
        return view('livewire.staticties.avarage-time-step');
    }
}
