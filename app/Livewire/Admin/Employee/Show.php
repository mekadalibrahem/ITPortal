<?php

namespace App\Livewire\Admin\Employee;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    use WithoutUrlPagination;
    // public $employees;

    public function delete($id)
    {
        try {
            $employee = Employee::where(
                'id',
                '=',
                $id
            )->first();
            if ($employee) {
                if ($employee->is_manager()) {
                    $dep = Department::where(
                        'manager_id',
                        '=',
                        $employee->department_id
                    )->first();
                    $dep->manager_id = null ;
                    $dep->save();
                }
                $employee->delete();
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
    #[On("edit_employee")]
    public function render()
    {
        // $this->employees = Employee::where("id" , '>' , 0)->orderBy('id', 'desc')->paginate(10);
        return view('livewire.admin.employee.show', [
            'employees' => Employee::where("id", '>', 0)->orderBy('id', 'desc')->paginate(10),
        ]);
    }
}
