<?php

namespace Database\Seeders;

use App\Models\Requests;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_requests.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            Requests::query()->create([
                'name' => $row['name'],
               'isActive' =>$row['isActive'],
               'type_id' =>$row['type_id'],
               'to_department' => $row['to_department']


           ]);
        }

    }
}
