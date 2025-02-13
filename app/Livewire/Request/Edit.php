<?php

namespace App\Livewire\Request;

use App\Models\Department;
use App\Models\Requests;
use App\Models\RequestType;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public $name;
    public $type;
    public $department;
    public $departments;
    public $types;
    public $active;
    public $req;
    public $id;
    // public
    public function mount()
    {
        $this->departments = Department::all();
        $this->types = RequestType::all();
    }

    public function index()
    {
        $this->req = Requests::find($this->id);
        if ($this->req) {
            $this->name =  $this->req->name;
            $this->type = $this->req->type_id;
            $this->department =  $this->req->to_department;
            $this->active   =  $this->req->isActive ? true : false;
        } else {
            abort(404);
        }
    }
    public function edit()
    {
        $this->validate([
            'name' => [
                'required',
                'min:8',
                Rule::unique('requests', 'name')->ignore($this->req->id)
            ],
            'type' => 'required|exists:request_types,id',
            'department' => "required|exists:departments,id"
        ]);
        $new_req = $this->req;
        $new_req->name = $this->name;
        $new_req->type_id = $this->type;
        $new_req->to_department = $this->department;
        $new_req->isActive = $this->active ? 1 : 0;
        if (!$new_req->isDirty()) {
            Toaster::warning(trans('messages.Information Not changed'));
        } else {
            $saved = $new_req->save();
            if ($saved) {
                Toaster::success(trans("messages.Request Saved"));
            } else {
                Toaster::danger(trans("messages.Faild Add Request Saved"));
            }
        }

        $this->req = $new_req;
        $this->render();
    }

    public function render()
    {
        $this->index();
        return view('livewire.request.edit');
    }
}
