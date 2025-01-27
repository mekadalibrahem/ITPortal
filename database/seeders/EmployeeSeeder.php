<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_employees.json');
        $json = json_decode($json_file , true);
        foreach ($json['data'] as $row) {
            Employee::query()->create([
                'user_id' => $row['user_id'],
               'department_id' =>$row['department_id']


           ]);
        }

    }
}
