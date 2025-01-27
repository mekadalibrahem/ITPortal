<?php

namespace App\Livewire\User\Request;

use App\Enums\DataTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Models\Data;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\RequireData;
use App\Traits\UpdateRequestTransaction;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    use UpdateRequestTransaction;

    public $hidden = true;
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
        $this->request_user = auth()->user();
    }

    public function clear()
    {
        $this->hidden = true;
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

    #[On("show_request_info", 'id')]
    public function show($id)
    {
        $this->clear();
        if ($id > 0) {
            $req = RequestList::where([
                'id' => $id,
                'user_id' => auth()->user()->id,
            ])->first();
            $this->hidden = false;
            $this->req = $req;
            $this->data = $req->data;
            // foreach ($this->data as $it) {
            //     if(
            //         $it->type() == DataTypeEnum::IMAGE->value
            //     ){
            //         $image = file(public_path('uploads/request_photos/' . $it->value));
            //         $this->request_data[$it->name] = $image;
            //     }else{
            //         $this->request_data[$it->name] = $it->value;
            //     }


            // }
            // dd($this);
            $this->last_log = RequestLog::where('request_list_id', $req->id)
                ->orderBy('id', 'desc')->first();
            $this->last_log_name = $this->last_log->employee->user->fullname();
            $this->last_log_email = $this->last_log->employee->user->email;
            $this->require_data = RequireData::where('requests_id', "=", $this->req->request_id)->get();
        } else {
            $this->hidden = true;
        }
        $this->render();
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

    public function rules()
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
                    $this->status = [
                        "type" => "success",
                        "message" => trans("messages.Request successfully updated.")
                    ];
                } else {
                    // Handle failure case
                    $this->status = [
                        "type" => "danger",
                        "message" => trans(
                            "messages.Failed to update request."
                        )
                    ];
                }
            } else {
                $this->status = [
                    "type" => "warning",
                    "message" => trans(
                        "messages.should write last 1 value to edit"
                    )
                ];
            }
        } else {
            $this->status = [
                "type" => "danger",
                "message" => trans(
                    "messages.Can't Edit this Request"
                )
            ];
        }

        $this->show($this->req->id);
    }



    public function render()
    {
        return view('livewire.user.request.edit');
    }
}
