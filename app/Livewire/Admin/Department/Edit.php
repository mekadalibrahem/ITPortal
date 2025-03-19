<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public $department;
    public $id;
    public $departments;
    public $name;
    public $description;
    public $manager_id;
    public $allowed_employees = [];
    public $manager;

    public function mount()
    {

        if ($this->id > 0) {
            $this->department = Department::where("id", "=", $this->id)->first();
            if ($this->department) {
                $this->allowed_employees = Employee::canManager($this->id)->with('user')->get();
                $this->name = $this->department->name;
                $this->description = $this->department->description;
                if ($this->department->manager_id !== null) {
                    $this->manager = Employee::where("id", "=", $this->department->manager_id)->first();
                    $this->manager_id = $this->manager->id;
                    // $this->allowed_employees = Employee::free()->with('user')->get();

                }
            } else {
                abort(404);
            }
        } else {
            abort(400);
        }
    }



    public function edit()
    {
        // dd($this->department);
        //edit department
        $this->validate([
            'name' => "required|min:10|unique:departments,name," . $this->department->id,
            'description' => 'required|min:20',
        ]);

        $new = $this->department;
        $new->name = $this->name;
        $new->manager_id = ($this->manager_id > 0) ? $this->manager_id : null;
        $new->description = $this->description;

        if ($new->isDirty()) {
            if ($new->save()) {
                $emp = Employee::find($this->manager_id) ?? null;
                $this->department->setManager($emp);


                $this->department = $new;
                Toaster::success(trans("messages.Item Saved"));
            } else {
                // falid edit
                Toaster::error(trans("messages.Faild edit Department"));
            }
        } else {
            Toaster::warning(trans("messages.department nothing changed"));
        }
        $this->dispatch('department-editing');
        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.department.edit');
    }
}
