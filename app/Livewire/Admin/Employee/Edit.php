<?php

namespace App\Livewire\Admin\Employee;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public $department;
    public $departments;
    public $nid;
    public $current_dep;
    public $id;
    public $employee;



    public function mount()
    {
        if ($this->id > 0) {
            $this->departments = Department::all();
            $this->employee  =  Employee::find($this->id);

            if ($this->employee) {
                $this->nid = $this->employee->user->national_id;
                $this->current_dep = $this->employee->department_id;
                $this->department = $this->employee->department_id;
            } else {
                abort(404);
            }
        } else {
            abort(400);
        }
    }



    public function edit()
    {
        $this->validate([
            'nid' => "required|exists:users,national_id",
            'department' =>'nullable|exists:departments,id'
        ]);
        $dep = ($this->department > 0) ? $this->department : null;
        $emp = $this->employee;
        $emp->department_id = $dep;
        if ($emp->updateEmployee($dep)) {
            $this->employee = $emp;

            Toaster::success(trans("messages.Employee Saved"));
        } else {
            Toaster::error(trans("messages.Faild Edit Employee"));
        }
    }
    public function render()
    {
        return view('livewire.admin.employee.edit');
    }
}
