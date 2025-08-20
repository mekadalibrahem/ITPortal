<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmployeeRequestCount extends Component
{
    use WithChart;
    public function mount()
    {
        $employees = Employee::with('user')->orderBy('employees.id')->get();
        $names = $employees->map->user->map(function ($user) {
            return $user ? $user->fullname() : null;
        })->toArray();
        
        $this->setChartLabels($names);
        $this->setChartName('employeerequestcount');
        $this->setChartType('bar');
    }

    public function data(): array
    {


        return [
            DB::table('employees as emp')
                ->leftJoin('request_logs as rl', 'emp.id', '=', 'rl.employee_id')

                ->select(
                    'emp.id',

                    DB::raw('COUNT(rl.request_list_id) as request_count')
                )
                ->groupBy('emp.id')
                ->orderBy('emp.id') // Order by department ID
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
            Dataset::make("Employees request count", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }
    public function render()
    {
        return view('livewire.staticties.employee-request-count', [
            'chart' => $this->chart()
        ]);
    }
}
