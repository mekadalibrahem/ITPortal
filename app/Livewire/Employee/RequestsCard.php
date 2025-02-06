<?php

namespace App\Livewire\Employee;

use App\Classes\ExportPdf;
use App\Enums\RequestStatusEnum;
use App\Models\Data;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\RequestList;
use App\Models\RequestLog;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\RequireData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;

class RequestsCard extends Component
{
    public $id ;
    public $hidden = true;
    public $request;
    public $request_id;
    public $request_data;
    public $status  = [];
    public $employee_id;
    public $employee_list = [];
    public $last_log;
    public $departments = [];
    public $dep_id;
    public $dep_employees = [];
    public $emp_id = 0;
    public $selected_emp_id = 0;
    public $last_log_name;
    public $last_log_email;
    public $current_employee;
    public $cancel_note;
    public $redirect_note  = null;
    public $request_user;


    public  function accept()
    {
        $this->request->status = RequestStatusEnum::END_ACCEPT;
        $this->request->save();

        Notification::create([
            "content" => "تم قبول الطلب بنجاح",
            "user_id" => $this->request->user_id,
            "from_id" => Auth::user()->id,
        ]);
    }
    public function  reject()
    {
        $this->validate([
            "cancel_note" => "required",
        ]);
        $this->request->status = RequestStatusEnum::END_REJECTED;
        $this->request->save();

        Notification::create([
            "content" => $this->cancel_note,
            "user_id" => $this->request->user_id,
            "from_id" => Auth::user()->id,
        ]);
    }

    public function cancel()
    {
        $this->validate([
            "cancel_note" => "required",
        ]);
        $this->request->status = RequestStatusEnum::WATING->value;
        $this->request->save();

        Notification::create([
            "content" => $this->cancel_note,
            "user_id" => $this->request->user_id,
            "from_id" => Auth::user()->id,
        ]);
    }

    public function update_last_log()
    {
        $this->last_log = RequestLog::where('request_list_id', $this->request_id)
            ->orderBy('id', 'desc')->first();
        $this->last_log_name = $this->last_log->employee->user->fullname();
        $this->last_log_email = $this->last_log->employee->user->email;
    }

    public function show()
    {
        if ($this->id > 0) {
            $this->hidden = false;
            $this->request_id = $this->id;

            $this->request = RequestList::where('id', $this->request_id)->first();
            if(!$this->request){abort(404);}else{
                $datas = Data::where("request_list_id", $this->request_id)->get();
                $detiles = [];
                foreach ($datas as $data) {
                    $rd = RequireData::where('name_en', '=', $data->name)->first();
                    $detiles[] = [
                        'name' => $data->name,
                        'type' => $rd->type,
                        'id' => $data->id,
                        'value' => $data->value,
                    ];
                }

                $this->update_last_log();
                $this->request_data = $detiles;
                $this->request_user = User::where("id", "=", $this->request->user_id)->first();
            }

        }else{
            abort(404);
        }

    }



    public function mount()
    {
        $this->departments = Department::all();
        $this->employee_list = Employee::all();
        $this->current_employee = Employee::where('user_id', Auth::id())->first();
        // dd($this->current_employee);
    }


    public function exportToPdf()
    {
       return  ExportPdf::export($this->request ,$this->request_data);
    }

    public function redirect_to($to_emp, $new_status, $notification = null)
    {

        if ($to_emp) {
            RequestLog::create([
                'request_list_id' => $this->request_id,
                'employee_id' => $to_emp->id,
            ]);
            $this->request->status = $new_status;
            $this->request->save();
            Notification::create([
                "content" => $notification ?? 'تم إرسال طلب إليك',
                "user_id" => $to_emp->user_id,
                "from_id" => Auth::user()->id,
            ]);
            $this->status = [
                "type" => "success",
                "message" => trans("messages.Request redirect")
            ];
            $this->update_last_log();
        }
    }
    public function redirect_to_manager()
    {

        $manger = $this->current_employee->manager();
        $this->redirect_to($manger, RequestStatusEnum::WORKING->value, $this->redirect_note);
    }
    public function redirect_to_employee()
    {
        // create new log
        $to_emp = Employee::where("id", "=", $this->selected_emp_id)->first();
        $this->redirect_to($to_emp, RequestStatusEnum::WORKING->value);
    }
    public function select_dep()
    {

        $this->dep_employees = [];
        foreach ($this->employee_list as $e) {
            if ($e->department_id == $this->dep_id) {
                $this->dep_employees[] = $e;
            }
        }
    }

    public function select_emp()
    {
        $this->selected_emp_id = $this->emp_id;
    }
    public function render()
    {
        $this->show();
        return view('livewire.employee.requests-card');
    }
}
