<?php

namespace Database\Seeders;

use App\Models\Department;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Storage;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_departments.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            Department::query()->create([
                'name' => $row['name'],
               'description' =>$row['description']
           ]);
        }


    }
}
