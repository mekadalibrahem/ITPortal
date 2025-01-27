<?php

namespace Database\Seeders;

use App\Models\RequireData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequiredSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_requier_data.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            RequireData::query()->create([
                'name' => $row['name'],
               'name_en' =>$row['name_en'],
               'type' => $row['type'],
               'requests_id' => $row['requests_id']


           ]);
        }

    }
}
