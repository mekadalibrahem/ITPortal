<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    public $name;
    public $description;
    public $dep_manager;
    public $employees;


    public function select_manager()
    {
        if ($this->dep_manager > 0) {
        } else {
            $this->dep_manager = null;
        }
    }

    public function mount()
    {
        $this->employees = Employee::canManager(0)->get();
    }
    public function add()
    {

        $this->validate([
            'name' => 'required|min:10|unique:departments,name',
            'description' => 'required|min:20',
        ]);
        $dep = Department::create([
            "name" => $this->name,
            "description" => $this->description,
            "manager_id" => $this->dep_manager
        ]);
        if ($dep) {
            $dep->setManager($this->dep_manager);
            Toaster::success(trans("messages.Add Department"));
        } else {
            Toaster::error(trans("messages.Faild Add Department"));
        }


        $this->render();
    }

    public function render()
    {
        return view('livewire.admin.department.create');
    }
}
