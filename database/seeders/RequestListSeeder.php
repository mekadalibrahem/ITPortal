<?php

namespace Database\Seeders;

use App\Models\RequestList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_request_lists.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            RequestList::query()->create([
                'user_id' => $row['user_id'],
               'request_id' =>$row['request_id'],
               'status' => $row['status'],
               'dean' => $row['dean'],
               'coordinator' => $row['coordinator'] ,
               'created_at' => $row['created_at'],
               'updated_at' =>$row['updated_at']


           ]);
        }

    }
}
