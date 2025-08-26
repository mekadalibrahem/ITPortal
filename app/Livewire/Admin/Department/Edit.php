<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\Employee;
use App\Traits\HasConvertImageToBase64;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    use WithFileUploads;
    use HasConvertImageToBase64;

    public $department;
    public $id;
    public $departments;
    public $name;
    public $description;
    public $manager_id;
    public $allowed_employees = [];
    public $manager;
    public $stamp;
    public $stamp_name;
    public $new_stamp;

    public function mount()
    {

        if ($this->id > 0) {
            $this->department = Department::where("id", "=", $this->id)->first();
            if ($this->department) {
                $this->allowed_employees = Employee::canManager($this->id)->with('user')->get();
                $this->name = $this->department->name;
                $this->description = $this->department->description;
                $this->stamp = $this->storage2base64(Storage::disk('stamps')->get($this->department->stamp), $this->department->stamp);
                $this->stamp_name = $this->department->stamp;
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
            'new_stamp' => 'nullable|image|max:2024'

        ]);

        $new = $this->department;
        $new->name = $this->name;
        $new->manager_id = ($this->manager_id > 0) ? $this->manager_id : null;
        $new->description = $this->description;
        if ($this->new_stamp) {
            $extension = $this->new_stamp->getClientOriginalExtension();
            $file_name = $this->name . "_" . time() . "." . $extension;
            $this->new_stamp->storeAs("", $file_name, 'stamps');
            $new->stamp = $file_name;
        }

        if ($new->isDirty()) {
            if ($new->save()) {
                if (Storage::disk('stamps')->exists($this->stamp_name)) {

                    Storage::disk('stamps')->delete($this->stamp_name);
                }
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
