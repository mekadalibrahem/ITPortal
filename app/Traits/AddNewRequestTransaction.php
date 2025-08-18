<?php

namespace App\Traits;

use Livewire\WithFileUploads;
use App\Enums\DataTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Models\CollageInformations;
use App\Models\Data;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\Requests;
use App\Models\RequestTemplates\OrderStep;
use App\Models\RequireData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

trait AddNewRequestTransaction
{
    use WithFileUploads;
    public $is_done = false;
    public $image;

    public function add_new_request_transaction($draft, $user_id, $request_id, $request_data,)
    {

        DB::transaction(function () use ($draft, $user_id, $request_id, $request_data) {
            try {
                // setp 1 :  insert request list row
                $status = $draft ? RequestStatusEnum::DRAFT->value : RequestStatusEnum::WATING->value;

                $req = Requests::where('id', '=', $request_id)->first();

                $dean = CollageInformations::where('name', '=', 'DEAN')->first();
                $coor = CollageInformations::where('name', '=', 'COOR_NAME_AR')->first();
                $templateSteps = OrderStep::where('request_template_id', $req->request_template_id)->orderBy('order')->get();
                $firstStep = $templateSteps->first();
                $new_request =  RequestList::create([
                    "user_id" => $user_id,
                    "request_template_id" => $req->request_template_id,
                    "status"  => $status,
                    "current_step_id" => $firstStep->request_tamplates_steps_id,
                    "request_id" => $request_id,
                    "dean" => $dean->value,
                    "coordinator" => $coor->value,
                    'page_id' => $req->page_id

                ]);
                // setp 2 :  store request data

                foreach ($request_data as $key => $value) {

                    $req_data = RequireData::where('name_en', "=", $key)->first();

                    if ($req_data->type == DataTypeEnum::IMAGE->value) {

                        $this->image = $value;

                        $extension = $this->image->getClientOriginalExtension();
                        $time = time();

                        $file_name = $user_id . "_" . $new_request->id . "_" . $key . "_" . $time . "." . $extension;
                        $this->image->storeAs("request_photos", $file_name, 'request');
                        $value = $file_name;
                    }

                    $data = Data::create([
                        'name' => $key,
                        "value" => $value,
                        "request_list_id" => $new_request->id
                    ]);
                }
                // create request log for all steps in request 
                // 1- create array for each step 
                $now = Carbon::now();
                $request_log_steps_array =$templateSteps->map(function ($step)  use($new_request,$now){
                    return [
                        'request_list_id' => $new_request->id ,
                        'request_tamplates_step_id' => $step->request_tamplates_steps_id,
                        'created_at' => $now ,
                        'updated_at' => $now,
                    ];
                })->all();
                // dd($templateSteps , $request_log_steps_array , $templateSteps->pluck('request_tamplates_steps_id'));
                DB::table('request_logs')->insert($request_log_steps_array);
                DB::commit();
                $this->is_done = true;
            } catch (\Throwable $th) {
                DB::rollBack();
                dd("FALID TRANSACTION INSERT REQUEST LIST ITEM : $th");
            }
        });
        return $this->is_done;
    }
}
