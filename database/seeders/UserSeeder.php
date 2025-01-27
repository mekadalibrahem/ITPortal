<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        $password = Hash::make('password');
        if (Storage::disk('local')->get("/itportal_db/itportal_db_table_users.json")) {
            $user_json = Storage::disk('local')->get("/itportal_db/itportal_db_table_users.json");
        $json = json_decode($user_json , true);
        if(is_null($json)){
            throw new \Exception("dont have any json data");
        }
        $users = $json['data'] ;
        foreach ($users as $user ) {
            User::query()->create([
                'fname' => $user['fname'] ,
                'mname' => $user['mname'] ,
                'lname' =>  $user['lname'] ,
                'username' => $user['username'],
                'email' => $user['email'],
                'password' =>$password,
                'national_id' =>  $user['national_id'],
            ]);
        }
        }else{
            throw new  \Exception("JSON FILE NOT FOUND");
        }

    }
}
