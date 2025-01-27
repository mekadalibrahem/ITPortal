<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add permissions data

        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_permissions.json');
        $json = json_decode($json_file, true);
        foreach ($json['data'] as $row) {
            DB::table('permissions')->insert([
                'name' => $row['name'],
                'guard_name' => $row["guard_name"],
                'created_at' => $row['created_at'],
                "updated_at" => $row['updated_at']
            ]);
        }


        // add roles data
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_roles.json');
        $json = json_decode($json_file, true);
        foreach ($json['data'] as $row) {
            DB::table('roles')->insert([
                'name' => $row['name'],
                'guard_name' => $row["guard_name"],
                'created_at' => $row['created_at'],
                "updated_at" => $row['updated_at']
            ]);
        }


        // add role_has_permissions data
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_role_has_permissions.json');
        $json = json_decode($json_file, true);
        foreach ($json['data'] as $row) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $row['role_id'],
                'permission_id' => $row['permission_id']
            ]);
        }

        // add model_has_roles data
        $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_model_has_roles.json');
        $json = json_decode($json_file, true);
        foreach ($json['data'] as $row) {
            DB::table('model_has_roles')->insert([
                'role_id' => $row['role_id'],
                'model_type' => $row["model_type"],
                'model_id' => $row['model_id']

            ]);

        }
        // add model_has_permissions data

         $json_file = Storage::disk('local')->get('/itportal_db/itportal_db_table_model_has_permissions.json');
         $json = json_decode($json_file, true);
         foreach ($json['data'] as $row) {
             DB::table('model_has_permissions')->insert([
                 'permission_id' => $row['permission_id'],
                 'model_type' => $row["model_type"],
                 'model_id' => $row['model_id']

             ]);

         }
    }
}
