<?php

namespace Database\Seeders;

use App\Models\RequestTemplates\RequestTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RequestTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_file_name = "/itportal_db/itportal_db_table_request_templates.json";

        if (Storage::disk('local')->get($json_file_name)) {
            $data_json = Storage::disk('local')->get($json_file_name);
            $json = json_decode($data_json, true);
            if (is_null($json)) {
                throw new \Exception("dont have any json data");
            }
            $list = $json['data'];
            foreach ($list as $item) {
                RequestTemplate::query()->create([
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                ]);
            }
        } else {
            throw new  \Exception("JSON FILE NOT FOUND");
        }
    }
}
