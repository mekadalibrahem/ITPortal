<?php

namespace App\Traits;

use App\Enums\DataTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Models\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait UpdateRequestTransaction
{
    public $images_for_deleted = [];
    public $image;
    public $old_image_path;
    public $is_done = false;

    public function update_request_trans($req,  $new_data, $draft)
    {

        DB::transaction(function ()  use ($req, $new_data, $draft) {
              
            try {
                $updated = [];

                if ($draft) {
                    $req->status = RequestStatusEnum::DRAFT->value;
                } else {
                    $req->status = RequestStatusEnum::CHECKING->value;
                }
                $req->save();



                foreach ($new_data as $key => $value) {


                    $edited_data = Data::where('request_list_id', '=', $req->id)
                        ->where("name", '=', $key)
                        ->first();

                    if ($edited_data->type() == DataTypeEnum::IMAGE->value) {
                        $this->image = $value;

                        $extension =  $this->image->getClientOriginalExtension();
                        $time = time();

                        $file_name = $req->user_id . "_" . $req->id . "_" . $edited_data->name . "_" . $time . "." . $extension;
                        $this->image->storeAs("request_photos", $file_name, 'request');;
                        $value = $file_name;
                    }

                    $edited_data->value = $value;
                    $edited_data->save();
                }


                DB::commit();
                // self::delete_old_image($this->images_for_deleted);
                $this->is_done = true;
            } catch (\Throwable $th) {
                DB::rollBack();
                // throw new \Exception("Error Processing Request" . $th, 1);

                dd("FALID TRANSACTION UPDATE REQUEST LIST ITEM : $th");

            }

        });
        return $this->is_done;
    }

    public static function delete_old_image($images){
        try {
            foreach ($images as $image) {

              Storage::delete("uploads/request_photos/".$image);
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
