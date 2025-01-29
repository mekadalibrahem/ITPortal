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
use App\Models\RequireData;
use Illuminate\Support\Facades\DB;
use Throwable;

trait AddNewRequestTransaction
{
    use WithFileUploads;
    public $is_done = false ;
    public $image ;

    public function add_new_request_transaction($draft , $user_id , $request_id , $request_data)
    {

        DB::transaction(function () use ($draft , $user_id , $request_id, $request_data ) {
            try {
                // setp 1 :  insert request list row
                $status = $draft ? RequestStatusEnum::DRAFT->value : RequestStatusEnum::CHECKING->value ;

                $req = Requests::where('id' , '=' , $request_id)->first();

                $dean = CollageInformations::where('name', '=', 'DEAN')->first();
                $coor = CollageInformations::where('name', '=', 'COOR_NAME_AR')->first();
                $new_request =  RequestList::create([
                    "user_id" => $user_id,
                    "status"  => $status,
                    "request_id" => $request_id,
                    "dean" => $dean->value,
                    "coordinator" => $coor->value

                ]);
                // setp 2 :  store request data

                foreach ($request_data as $key => $value) {

                    $req_data = RequireData::where('name_en', "=", $key)->first();

                    if($req_data->type == DataTypeEnum::IMAGE->value){

                        $this->image = $value;

                       $extension = $this->image->getClientOriginalExtension();
                        $time = time();

                       $file_name = $user_id . "_" . $new_request->id."_".$key."_".$time.".".$extension;
                       $this->image->storeAs("request_photos",$file_name , 'request');
                       $value = $file_name;


                    }

                    $data = Data::create([
                        'name' => $key,
                        "value" => $value,
                        "request_list_id" => $new_request->id
                    ]);
                }
                // step 3 : assing request list item to currect employee (store request list log item)
                // if requst draft to assing to employee
                if ($draft != true) {
                    $re = Requests::where('id', '=', $new_request->request_id)->first();

                    RequestLog::create([
                        'request_list_id' => $new_request->id,
                        'employee_id' => $re->department->manager_id,
                    ]);


                }
                DB::commit();
                $this->is_done = true;
            } catch (\Throwable $th) {
                DB::rollBack();
                dd("FALID TRANSACTION INSERT REQUEST LIST ITEM : $th");
            }
        });
        return $this->is_done ;
    }
}
