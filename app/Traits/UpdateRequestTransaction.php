<?php

namespace App\Traits;

use App\Enums\DataTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Events\RequestListEdited;
use App\Models\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Masmerise\Toaster\Toaster;

trait UpdateRequestTransaction
{
    public $images_for_deleted = [];
    public $image;
    public $old_image_path;
    public $is_done = false;
    public $data_changed = [];
    public function update_request_trans($req,  $new_data, $draft)
    {

        DB::transaction(function ()  use ($req, $new_data, $draft) {

            try {
                $updated = [];

                if ($draft) {
                    $req->status = RequestStatusEnum::DRAFT->value;
                } else {
                    if ($req->status == RequestStatusEnum::WATING->value) {
                        // don't change request status
                    } elseif ($req->status == RequestStatusEnum::WATING_EDIT->value) {
                        $req->status = RequestStatusEnum::WORKING->value;
                    }
                }
                $req->save();



                foreach ($new_data as $key => $value) {

                    $edited_data = Data::where('request_list_id', '=', $req->id)
                        ->where("name", '=', $key)
                        ->first();

                    $item  = [
                        'key' => $key,
                        'isImage' => 0,
                        'old' => $edited_data->value,
                        "new" => $value,
                    ];


                    if ($edited_data->type() == DataTypeEnum::IMAGE->value) {
                        $this->image = $value;

                        $extension =  $this->image->getClientOriginalExtension();
                        $time = time();

                        $file_name = $req->user_id . "_" . $req->id . "_" . $edited_data->name . "_" . $time . "." . $extension;
                        $this->image->storeAs("request_photos", $file_name, 'request');;
                        $value = $file_name;
                        $item['isImage'] = 1;
                    }
                    if ($value) {
                        $edited_data->value = $value;
                        if ($edited_data->isDirty()) {
                            $this->data_changed[]  = $item;
                        }
                    } 

                    $edited_data->save();
                }


                DB::commit();
                event(new RequestListEdited($req->id, $req->user->email, $req->current_step_id, $this->data_changed));
                // self::delete_old_image($this->images_for_deleted);
                $this->is_done = true;
            } catch (\Throwable $th) {
                DB::rollBack();
                // // throw new \Exception("Error Processing Request" . $th, 1);
                logger()->error("FALID TRANSACTION UPDATE REQUEST LIST ITEM : $th->getMessage()");
                // dd("FALID TRANSACTION UPDATE REQUEST LIST ITEM : $th");
            }
        });
        return $this->is_done;
    }

    public static function delete_old_image($images)
    {
        try {
            foreach ($images as $image) {

                Storage::delete("uploads/request_photos/" . $image);
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
