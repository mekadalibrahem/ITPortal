<?php

namespace App\Livewire\Request;

use App\Models\Department;
use App\Models\Requests;
use App\Models\RequestType;
use Livewire\Component;

class Edit extends Component
{
    public $name;
    public $type;
    public $department;
    public $departments;
    public $types;
    public $active;
    public $old_name;
    public $req;
    // public
    public function mount()
    {
        $this->departments = Department::all();
        $this->types = RequestType::all();
    }

    public function index()
    {
        $this->req = Requests::where('name', "=", $this->old_name)->first();
        if ($this->req) {
            $this->name =  $this->req->name;
            $this->type = $this->req->type;
            $this->department =  $this->req->department;
            $this->active   =  $this->req->active;
        } else {
            $this->name = null;
            $this->type = null;
            $this->department = null;
            $this->active   = null;
        }
        // dd($this->req);
        $this->render();
    }
    public function edit()
    {
        $this->validate([
            'name' => "required|min:8|unique:requests,name",
            'type' => 'required|exists:request_types,id',
            'department' => "required|exists:departments,id"
        ]);
        $new_req = $this->req;
        $new_req->name = $this->name;
        $new_req->type_id = $this->type;
        $new_req->to_department = $this->department;
        $new_req->isActive = $this->active;
        if ($new_req->isDirty()) {
            session()->flash("status", [
                "type" => "warning",
                "message" => trans("messages.")
            ]);
        } else {
            $saved = $new_req->save();
            if ($saved) {
                session()->flash("status", [
                    "type" => "success",
                    "message" => trans("messages.Request Saved")
                ]);
            } else {
                session()->flash("status", [
                    "type" => "danger",
                    "message" => trans("messages.Faild Add Request Saved")
                ]);
            }
        }

        $this->req = $new_req;
        $this->old_name = $new_req->name;
        $this->index();
    }

    public function render()
    {
        return view('livewire.request.edit');
    }
}
