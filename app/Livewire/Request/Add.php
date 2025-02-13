<?php

namespace App\Livewire\Request;

use App\Models\Department;
use App\Models\Requests;
use App\Models\RequestType;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Add extends Component
{
    public $name;
    public $type;
    public $department;
    public $departments;
    public $types;
    public $active;


    public function mount()
    {
        $this->departments = Department::all();
        $this->types = RequestType::all();
    }


    public function add()
    {
        $this->validate([
            'name' => "required|min:8|unique:requests,name",
            'type' => 'required|exists:request_types,id',
            'department' => "required|exists:departments,id"
        ]);

        $re = Requests::create([
            'name' => $this->name,
            "type_id" => $this->type,
            "to_department" => $this->department,
            "isActive" => $this->active ?? 0,
        ]);
        if ($re) {
            Toaster::success(trans("messages.Request Saved"));
        } else {
            Toaster::danger(trans("messages.Faild Add Request"));
        }
    }
    public function render()
    {
        return view('livewire.request.add');
    }
}
