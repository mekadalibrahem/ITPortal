<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SlutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $json_file_name = "/itportal_db/itportal_db_table_itportal_db_table_custome_blocks.json";

        // if (Storage::disk('local')->get($json_file_name)) {
        //     $data_json = Storage::disk('local')->get($json_file_name);
        //     $json = json_decode($data_json, true);
        //     if (is_null($json)) {
        //         throw new \Exception("dont have any json data");
        //     }
        //     $list = $json['data'];
        //     foreach ($list as $item) {
        //         DB::table('custome_blocks')->insert([
        //             "id" => $item["id"],
        //             "block_data" => $item["block_data"],
        //             "name" => $item["name"],
        //             "created_at" => $item["created_at"],
        //             "updated_at" => $item["updated_at"]

        //         ]);
        //     }
        // } else {
        //     throw new  \Exception("JSON FILE NOT FOUND");
        // }
        $json_file_name = "/itportal_db/itportal_db_table_pages.json";

        if (Storage::disk('local')->get($json_file_name)) {
            $data_json = Storage::disk('local')->get($json_file_name);
            $json = json_decode($data_json, true);
            if (is_null($json)) {
                throw new \Exception("dont have any json data");
            }
            $list = $json['data'];
            foreach ($list as $item) {
                DB::table('pages')->insert([
                    "id" => $item["id"],
                    "page_data" => $item["page_data"],
                    "name" => $item["name"],
                    "slug" => $item["slug"],
                    "created_at" => $item["created_at"],
                    "updated_at" => $item["updated_at"]

                ]);
            }
        } else {
            throw new  \Exception("JSON FILE NOT FOUND");
        }
    }
}
