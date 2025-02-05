<?php

namespace App\Livewire\User\Request;

use App\Enums\DataTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Models\Data;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\RequireData;
use App\Traits\UpdateRequestTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    use WithFileUploads;

    use UpdateRequestTransaction;

    public $id = 0;

    public $req;
    public $request_user;
    public $last_log_name;
    public $last_log_email;
    public $request_data = [];
    public $last_log;

    public $status  = [];
    public $data = [];
    public  $require_data;
    public $image;
    public $temp_new_value;
    public function mount()
    {
        $this->request_user = Auth::user();
    }

    public function clear()
    {
        $this->id;
        $this->req;
        $this->request_user;
        $this->last_log_name;
        $this->last_log_email;
        $this->request_data = [];
        $this->last_log;
        $this->image = null;
        $this->status  = [];
        $this->data = [];
        $this->require_data;
    }


    /**
     * method to handel RequestList object with RequestListLogs , Data and RequireData
     * if requestList id not set or invalid with Auth::user will abort for status 404
     * @return void
     *
     */
    public function show()
    {

        if ($this->id > 0) {
            $req = RequestList::where([
                'id' => $this->id,
                'user_id' => $this->request_user->id,
            ])->first();

            if ($req) {
                // request found
                $this->req = $req;


                $this->data = $req->data;
                // get request process step
                $this->last_log = RequestLog::where('request_list_id', $req->id)
                    ->orderBy('id', 'desc')->first();
                if ($this->last_log) {
                    $this->last_log_name = $this->last_log->employee->user->fullname();
                    $this->last_log_email = $this->last_log->employee->user->email;
                }
                // get what require data for this request
                $this->require_data = RequireData::where('requests_id', "=", $this->req->request_id)->get();
            } else {
                // request not found
                $this->req = null; // Set to null for invalid IDs
                abort(404);
            }
        } else {
            // request id not set so request not found
            $this->req = null; // Set to null for invalid IDs
            abort(404);
        }
    }



    public function updateStatus($draft)
    {
        if ($draft) {
            $this->req->status = RequestStatusEnum::DRAFT->value;
        } else {
            $this->req->status = RequestStatusEnum::CHECKING->value;
        }
        $this->req->save();
    }


    /**
     * init rules array  for validate  update requestList From
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $data_list = array_filter(
            $this->request_data,
            function ($item) {
                return !empty($item);
            }
        );

        foreach ($data_list as $key => $value) {
            $req_data = RequireData::where('name_en', "=", $key)->first();
            $rules_item = DataTypeEnum::get_role($req_data->type);
            $rules["request_data.{$key}"] = $rules_item;
        }




        return $rules;
    }

    /**
     * store or update new requestLists info in database  and show  Toast message if done or found any error 
     *
     * @param boolean $draft  default value false
     * @return void
     */
    public function store($draft = false)
    {

        if ($this->req->can_edit()) {
            $roles = $this->rules();
            if (!empty($roles)) {

                // edit
                $this->validate($roles);
                $isdone = $this->update_request_trans(
                    $this->req,
                    $this->request_data,
                    $draft
                );

                if ($isdone) {

                    // Handle successful save, e.g., set a success message
                    Toaster::success(trans("messages.Request successfully updated."));
                } else {
                    // Handle failure case
                    Toaster::danger(trans("messages.Failed to update request."));
                }
            } else {

                Toaster::warning(trans("messages.should write last 1 value to edit"));
            }
        } else {
            Toaster::danger(trans("messages.Can't Edit this Request"));
        }

        $this->show($this->req->id);
    }



    public function render()
    {
        $this->show();
        return view('livewire.user.request.edit');
    }
}
