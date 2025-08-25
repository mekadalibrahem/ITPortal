<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use Livewire\Component;
use App\Classes\Chart\Traits\WithChart;
use App\Livewire\Staticties\Traits\HasOptions;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentRequestCount extends Component
{
    use WithChart;
    use HasOptions;
    public function mount()
    {
        $this->setChartLabels(Department::select('name', 'id')->orderBy('id')->pluck('name')->toArray());
        $this->setChartName('department_request_count');
        $this->setChartType('doughnut');
        $this->setHeader(trans('string.request_department_count'));
        $this->setExportHeadings(['department', 'request count']);
    }

    public function data(): array
    {

        $query = Department::leftJoin('employees', 'departments.id', '=', 'employees.department_id')
            ->leftJoin('request_logs', 'employees.id', '=', 'request_logs.employee_id')

            ->select(
                'departments.id',

                DB::raw('COUNT(DISTINCT request_logs.request_list_id) as request_count')
            );

        return [
             $query
                ->groupBy('departments.id')
                ->orderBy('departments.id') // Order by department ID
                ->get()
                ->pluck('request_count')
                ->toArray()
        ];
    }
    public function getDatasets(): array
    {

        $data =  $this->data();

        $colors = $this->getColorsInstance(count($this->getChartLabels()), count($data));

        return [
            Dataset::make("Department request", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }
    public function render()
    {
        $this->getData();
        return view('livewire.staticties.department-request-count');
    }
}
