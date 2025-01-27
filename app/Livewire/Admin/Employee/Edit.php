<?php

namespace App\Livewire\Admin\Employee;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $ssn;
    public $email;
    public $department;
    public $departments;
    public $current_email;
    public $current_dep;



    public function index()
    {
        $emp = Employee::find($this->ssn);
        if ($emp) {
            $this->email = $emp->user->email;
            $this->current_email = $emp->user->email;
            $this->current_dep = $emp->department_id;
        } else {
            $this->current_email = null;
            $this->current_dep = null;
            $this->current_email = null;
        }
        // dd($this->current_email);
        $this->render();
    }

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function add()
    {
        $this->validate([
            "email" => "required|email|exists:users,email",
        ]);
        $user = User::where("email", $this->email)->first();
        $exists = Employee::where(
            'user_id',
            '=',
            $user->id
        )->first();
        if ($exists) {
            session()->flash("status", [
                "type" => "danger",
                "message" => trans("messages.Employee alrady exists")
            ]);
        } else {
            $dep_id  = $this->department;
            if (! $dep_id > 0) {
                $dep_id = null;
            }
            $emp = Employee::create(
                [
                    'user_id' => $user->id,
                    'department_id' => $dep_id,
                ]
            );
            if ($emp) {
                // update user roles
                try {
                    $user->assignRole('employee');
                } catch (\Throwable $th) {
                    dd($th);
                }
                session()->flash("status", [
                    "type" => "success",
                    "message" => trans("messages.Add Employee")
                ]);
            } else {
                session()->flash("status", [
                    "type" => "danger",
                    "message" => trans("messages.Faild Add Employee")
                ]);
            }
        }

        $this->dispatch("edit_employee");

        $this->render();
    }

    public function edit()
    {
        $dep = ($this->department > 0) ? $this->department : null;
        $emp = Employee::find($this->ssn);
        $emp->department_id = $dep;
        if ($emp->save()) {
            session()->flash("status", [
                "type" => "success",
                "message" => trans("messages.Employee Saved")
            ]);
        } else {
            session()->flash("status", [
                "type" => "danger",
                "message" => trans("messages.Faild Edit Employee")
            ]);
        }
        $this->index();
        $this->dispatch("edit_employee");
    }
    public function render()
    {
        return view('livewire.admin.employee.edit');
    }
}
