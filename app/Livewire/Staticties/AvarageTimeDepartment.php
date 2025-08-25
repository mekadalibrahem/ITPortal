<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Livewire\Staticties\Traits\HasOptions;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AvarageTimeDepartment extends Component
{
    use WithChart;
    use HasOptions;
    public function mount()
    {
        $this->setChartLabels(Department::select('name', 'id')->orderBy('id')->pluck('name')->toArray());

        $this->setChartName('department_avg_time');
        $this->setChartType('bar');
        $this->setHeader(trans('string.department_performance_avg_time'));
        $this->setExportHeadings(['department', 'average duration (hours)']);
    }

    public function data(): array
    {
        
        $allDepartments = Department::select('id', 'name')->orderBy('id')->get();

        $query = Department::leftJoin('request_tamplates_steps', 'departments.id', '=', 'request_tamplates_steps.department_id')
            ->leftJoin('request_logs', function ($join) {
                $join->on('request_tamplates_steps.id', '=', 'request_logs.request_tamplates_step_id')
                    ->whereNotNull('request_logs.end_at');
            })
            ->select(
                'departments.id',
                DB::raw('COALESCE(AVG(TIMESTAMPDIFF(SECOND, request_logs.start_at, request_logs.end_at) / 3600), 0) as avg_duration_hours')
            );

        if ($this->hasYearFilter()) {
            if (!empty($this->from_year)) {
                $query->whereYear('request_logs.created_at', '>=', $this->from_year);
            }
            if (!empty($this->to_year)) {
                $query->whereYear('request_logs.created_at', '<=', $this->to_year);
            }
        }

        $results = $query
            ->groupBy('departments.id')
            ->orderBy('departments.id')
            ->get();

       
        $departmentAverages = $results->pluck('avg_duration_hours', 'id')->toArray();

        
        $finalData = [];
        foreach ($allDepartments as $department) {
            $finalData[] = $departmentAverages[$department->id] ?? 0;
        }

        return [$finalData];
    }

    public function getDatasets(): array
    {
        $data = $this->data();
        $labels = $this->getChartLabels();

        $colors = $this->getColorsInstance(count($labels), count($data));

        return [
            Dataset::make(
                "Average Processing Time (hours)",
                $colors['colors'][0],
                $colors['hovers'][0],
                $data[0]
            )
        ];
    }
    public function render()
    {
        $this->getData();
        return view('livewire.staticties.avarage-time-department');
    }
}
