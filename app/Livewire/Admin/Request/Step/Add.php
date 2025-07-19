<?php

namespace App\Livewire\Admin\Request\Step;

use App\Enums\StepRolesEnum;
use App\Models\Department;
use App\Models\RequestTemplates\RequestTemplateStep;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Add extends Component
{

    public $roles;
    public $departments;
    public $name;
    public $description;
    public $role;
    public $department;
    public function mount()
    {
        $this->roles = StepRolesEnum::array();
        $this->departments = Department::all();
    }

    public function save(){
        $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'role' => 'required|string',
            'department' => 'exists:departments,id',
        ]);
        $temp = RequestTemplateStep::create([
            'name' => $this->name,
            'description' => $this->description,
            'role' => $this->roles[$this->role],
            'department_id' => $this->department,
           

        ]);
        if($temp){
            Toaster::success(trans('messages.Item Saved'));
            return redirect()->route('admin.requests.steps.index');
        }else{
            Toaster::error(trans('messages.Faild Add Item' ));
        }
    
    }
    public function render()
    {
        return view('livewire.admin.request.step.add');
    }
}
