<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Traits\HasCopyFiles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    use HasCopyFiles;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // init folder to save user singature 
        $sourcePath = storage_path('app/private/itportal_db/signatures/signature.png');
        $destinationPath =  storage_path('app/private/signature');
        if (!File::exists($sourcePath)) {
            $this->command->error("Source directory does not exist: {$sourcePath}");
            return;
        }
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
            $this->command->info("Created destination directory: {$destinationPath}");
        }
        // Clear the destination directory first
        $this->clearDirectory($destinationPath);
        $default_signature_file = File::get($sourcePath);
        $json_file = "/itportal_db/itportal_db_table_users.json";

        $password = Hash::make('password');
        if (Storage::disk('local')->get($json_file)) {
            $user_json = Storage::disk('local')->get($json_file);
            $json = json_decode($user_json, true);
            if (is_null($json)) {
                throw new \Exception("dont have any json data");
            }
            $users = $json['data'];
            foreach ($users as $user) {
                User::query()->create([
                    'fname' => $user['fname'],
                    'mname' => $user['mname'],
                    'lname' =>  $user['lname'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'password' => $password,
                    'signature' => $user['signature'],
                    'national_id' =>  $user['national_id'],
                ]);
                File::copy($sourcePath, $destinationPath . "/" . $user['signature']);
            }
        } else {
            throw new  \Exception("JSON FILE NOT FOUND");
        }
    }
}
