<?php

namespace Database\Seeders;

use App\Models\CollageInformations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CollageinformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_collage_informations.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            CollageInformations::query()->create([
                'name' => $row['name'],
               'value' =>$row['value']

           ]);
        }
    }
}
