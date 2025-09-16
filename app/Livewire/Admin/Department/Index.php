<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public $department;
    public $employees;
    public $id;
    public $allowed_employees;
    public $new_employee;

    public function mount()
    {
        if ($this->id > 0) {
            $dep = Department::where('id', '=', $this->id)->with('employees')->first();
            $this->allowed_employees = Employee::free()->with('user')->get();
            if ($dep) {
                $this->department = $dep;
                $this->update_data();
            } else {
                abort(404);
            }
        } else {
            abort(400);
        }
    }

    #[On('department-editing')]
    public function department_edit()
    {
        $this->mount();
        $this->update_data();
        $this->render();
    }

    public function update_data()
    {
        $this->employees = $this->department->employees;
    }
    /**
     * delete employee form curent department then re render component
     */
    public function delete($id)
    {
        if ($id > 0) {
            $emp = Employee::where('id', '=', $id)->first();
            $this->department->removeEmployee($emp);
            Toaster::success(trans('messages.Deleted Item'));
        }
        $this->dispatch('department-editing');
    }

    public function insert()
    {
        $employee = Employee::find($this->new_employee);
        if ($employee) {
            $this->department->addEmployee($employee);
            Toaster::success(trans("messages.Add Employee"));
        }
        $this->dispatch('department-editing');
    }
    public function render()
    {
        return view('livewire.admin.department.index');
    }
}
