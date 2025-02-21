<?php

namespace App\Livewire\Request;

use App\Models\Department;
use App\Models\Requests;
use App\Models\RequestType;
use Illuminate\Support\Facades\Log;
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
        $this->index();
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
            'department' => "required|exists:departments,id",
            'active' => 'boolean'
        ]);
        try {
            $this->req->name = $this->name;
            $this->req->type_id = $this->type;
            $this->req->to_department = $this->department;
            $this->req->isActive = $this->active ? 1 : 0;

            if (!$this->req->isDirty()) {

                Toaster::warning(trans('messages.Information Not changed'));
            } else {
                if ($this->req->save()) {
                    Toaster::success(trans("messages.Request Saved"));
                } else {
                    Toaster::danger(trans("messages.Faild Add Request Saved"));
                }
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' . __FUNCTION__ . " : ERROR is ->" . $th->getMessage());
        }
        $this->render();
    }

    public function render()
    {

        return view('livewire.request.edit');
    }
}
