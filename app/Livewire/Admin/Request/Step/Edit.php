<?php

namespace App\Livewire\Admin\Request\Step;

use App\Enums\StepRolesEnum;
use App\Models\Department;
use App\Models\RequestTemplates\RequestTemplateStep;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public $roles;
    public $departments;
    public $name;
    public $description;
    public $role;
    public $department;
    public $id;
    public $step;
    public $roles_key;
    public function mount()
    {
        $this->roles = StepRolesEnum::array();
        $this->roles_key = StepRolesEnum::arrayre();
        $this->departments = Department::all();
        $this->index();
    }

    public function index()
    {
        if ($this->id > 0) {
            $this->step = RequestTemplateStep::find($this->id);
            if ($this->step) {
                $this->name = $this->step->name;
                $this->description = $this->step->description;
                $this->role = $this->roles_key[$this->step->role];
                $this->department = $this->step->department_id;
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'role' => 'required|string',
            'department' => 'exists:departments,id',
        ]);
        $temp = $this->step;
        $temp->name = $this->name;
        $temp->description = $this->description;
        $temp->role = $this->roles[$this->role];
        $temp->department_id = $this->department;
        $edit  = $temp->save();


        if ($edit) {
            Toaster::success(trans('messages.Item Saved'));
            return redirect()->route('admin.requests.steps.index');
        } else {
            Toaster::error(trans('messages.Faild save item'));
        }
    }

    public function render()
    {
        return view('livewire.admin.request.step.edit');
    }
}
