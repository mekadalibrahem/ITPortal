<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ManagerDepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_departments.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            Department::query()->where([
                'name' => $row['name']
                ])->update([
               'manager_id' =>$row['manager_id']
           ]);
        }

    }
}
