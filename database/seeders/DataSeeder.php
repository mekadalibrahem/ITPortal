<?php

namespace Database\Seeders;

use App\Models\Data;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_data.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            Data::query()->create([
                'name' => $row['name'],
               'value' =>$row['value'],
               'request_list_id' =>$row['request_list_id']

           ]);
        }

    }
}
