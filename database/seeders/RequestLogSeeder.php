<?php

namespace Database\Seeders;

use App\Models\RequestLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_request_logs.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            RequestLog::query()->create([
                'request_list_id' => $row['request_list_id'],
               'employee_id' =>$row['employee_id'],
               'created_at' => $row['created_at'],
               'updated_at' =>$row['updated_at'],


           ]);
        }
    }
}
