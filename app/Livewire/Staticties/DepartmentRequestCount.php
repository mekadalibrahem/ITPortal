<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use Livewire\Component;
use App\Classes\Chart\Traits\WithChart;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\RequestList;
use App\Models\Requests;

class DepartmentRequestCount extends Component
{
    use WithChart;
    public function mount()
    {
        $this->setChartLabels(Department::select('name', 'id')->orderBy('id')->pluck('name')->toArray());
        $this->setChartName('departmentrequestcount');
        $this->setChartType('bar');
    }

    public function data(): array
    {


        return [
            DB::table('departments as d')
                ->leftJoin('employees as emp', 'd.id', '=', 'emp.department_id')
                ->leftJoin('request_logs as rl', 'emp.id', '=', 'rl.employee_id')

                ->select(
                    'd.id',

                    DB::raw('COUNT(DISTINCT rl.request_list_id) as request_count')
                )
                ->groupBy('d.id')
                ->orderBy('d.id') // Order by department ID
                ->get()
                ->pluck('request_count')
                ->toArray()
        ];
        
    }
    public function datasets(): array
    {

        $data =  $this->data();
        // dd(count($this->getChartLabels()), count($data[0]));
        $colors = $this->getColorsInstance(count($this->getChartLabels()), count($data));

        return [
            Dataset::make("Department request", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }
    public function render()
    {
        return view('livewire.staticties.department-request-count', [
            'chartd' => $this->chart()
        ]);
    }
}
