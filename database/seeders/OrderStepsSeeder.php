<?php

namespace Database\Seeders;

use App\Models\RequestTemplates\OrderStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class OrderStepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_file_name = "/itportal_db/itportal_db_table_order_steps.json";

        if (Storage::disk('local')->get($json_file_name)) {
            $data_json = Storage::disk('local')->get($json_file_name);
            $json = json_decode($data_json, true);
            if (is_null($json)) {
                throw new \Exception("dont have any json data");
            }
            $list = $json['data'];
            foreach ($list as $item) {
                OrderStep::query()->create([
                    'id' => $item['id'],
                    'request_tamplates_steps_id' => $item['request_tamplates_steps_id'],
                    'request_template_id' => $item['request_template_id'],
                    'order' => $item['order'],
                ]);
            }
        } else {
            throw new  \Exception("JSON FILE NOT FOUND");
        }
    }
}
