<?php

namespace App\Livewire\Admin\Employee;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    public $nid;
    public $department;
    public $departments;





    public function mount()
    {
        $this->departments = Department::all();
    }

    public function add()
    {
        $this->validate([
            "nid" => "required|exists:users,national_id",
        ]);
        try {

            $user = User::where("national_id", $this->nid)->first();
            $exists = Employee::where(
                'user_id',
                '=',
                $user->id
            )->first();
            if ($exists) {
                $this->addError('nid', trans('messages.Employee alrady exists'));
            } else {
                $dep_id  = $this->department;
                if (! $dep_id > 0) {
                    $dep_id = null;
                }
                $emp = Employee::create(
                    [
                        'user_id' => $user->id,
                        'department_id' => $dep_id,
                    ]
                );
                if ($emp) {
                    // update user roles
                    Log::info(__CLASS__ . '@' . __FUNCTION__ . ": add role");
                    try {
                        $s = $user->assignRole('employee');
                        Log::info(__CLASS__ . '@' . __FUNCTION__ . ": has role is ". $s );;
                    } catch (\Throwable $th) {
                        Log::error(__CLASS__ . '@' . __FUNCTION__ . ":" . $th->getMessage());
                    }
                    Toaster::success(trans("messages.Add Employee"));
                } else {
                    Log::error(__CLASS__ . '@' . __FUNCTION__ . ": added empty ");
                    Toaster::error(trans("messages.Faild Add Employee"));
                }
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' . __FUNCTION__ . ":" . $th->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.admin.employee.create');
    }
}
