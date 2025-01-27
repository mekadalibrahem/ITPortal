<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;

class Edit extends Component
{
    public $department;
    public $dep_id;
    public $departments;
    public $name;
    public $description;
    public $manager_id;
    public $allowed_employees = [];
    public $manager;

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function index()
    {
        $this->department = Department::where("id", "=", $this->dep_id)->first();
        if ($this->department) {
            $this->allowed_employees = Employee::free()->get();
            $this->name = $this->department->name;
            $this->description = $this->department->description;
            if ($this->department->manager_id !== null) {
                $this->manager = Employee::where("id", "=", $this->department->manager_id)->first();
                $this->manager_id = $this->manager->id;
                $this->allowed_employees[] = $this->manager;
            }
        }
    }

    public function edit()
    {
        // dd($this->department);
        //edit department
        $this->validate([
            'name' => "required|min:10|unique:departments,name,".$this->department->id,
            'description' => 'required|min:20',
        ]);
        // dd($this->manager_id);
        $new_manager_id = ($this->manager_id >0) ? $this->manager_id : null ;
        $dep = $this->department;
        $dep->name = $this->name;
        $dep->manager_id = $new_manager_id;
        $dep->description = $this->description;
        if ($dep->isDirty()) {

            $edited =  $dep->save();

            if($edited){
                session()->flash("status", [
                    "type" => "success",
                    "message" => trans("messages.Add Department")
                ]);
                $this->dispatch("deps_changed");
                if ($this->manager_id != $this->manager->id) {
                    // can remove manager from this department
                    // $this->manager->department_id = null ;
                    // $this->manager->save();
                }
            }else{
                // falid edit
                session()->flash("status", [
                    "type" => "danger",
                    "message" => trans("messages.Faild edit Department")
                ]);
            }

        } else {
            //
            session()->flash("status", [
                "type" => "warning",
                "message" => trans("messages.department nothing changed")
            ]);
        }
        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.department.edit');
    }
}
