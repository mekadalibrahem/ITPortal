<?php

namespace Database\Seeders;

use App\Models\RequestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_request_types.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            RequestType::query()->create([
                'type' => $row['type'],
           ]);
        }



    }
}
