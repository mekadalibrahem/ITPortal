<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Livewire\Staticties\Traits\HasOptions;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmployeeRequestCount extends Component
{
    use WithChart;
    use HasOptions;
    public function mount()
    {
        $employees = Employee::with('user')->orderBy('employees.id')->get();
        $names = $employees->map->user->map(function ($user) {
            return $user ? $user->fullname() : null;
        })->toArray();

        $this->setChartLabels($names);
        $this->setChartName('employee_request_count');
        $this->setChartType('bar');
        $this->setHeader(trans('string.request_employee_count'));
        $this->setExportHeadings(['employee', 'request count']);
    }

    public function data(): array
    {

        $query = Employee::leftJoin('request_logs', 'employees.id', '=', 'request_logs.employee_id')
            ->select(
                'employees.id',
                DB::raw('COUNT(request_logs.request_list_id) as request_count')
            );

        if ($this->hasYearFilter()) {
            if (!empty($this->from_year)) {
                $query->whereYear('created_at', '>=', $this->from_year);
            }
            if (!empty($this->to_year)) {
                $query->whereYear('created_at', '<=', $this->to_year);
            }
        }
      
        return [
              $query->groupBy('employees.id')
            ->orderBy('employees.id') // Order by department ID
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
            Dataset::make("Employees request count", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }
    public function render()
    {
        $this->getData();
        return view('livewire.staticties.employee-request-count');
    }
}
