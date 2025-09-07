<?php

namespace App\Classes\Services\Actions;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserAction
{
    public static $USER_TYPE_STUDENT = 1;
    public static $USER_TYPE_EMPLOYEE = 2;

    public static function register(array $user_data): bool
    {
        $user = User::create([
            'fname' => $user_data['fname'],
            'mname' => $user_data['mname'],
            'lname' => $user_data['lname'],
            'username' => $user_data['username'],
            'email' => $user_data['email'],
            "national_id" => $user_data['national_id'],
            'password' => Hash::make($user_data['password'])
        ]);
        if ($user) {
            if ($user_data['type'] ==  self::$USER_TYPE_STUDENT) {
                $user->assignRole('student');
            } else  if ($user_data['type'] ==  self::$USER_TYPE_EMPLOYEE) {
                $user->assignRole('employee_requests');
            }
        } else {
            return false;
        }

        return true;
    }

    public static function delete(User $user,  $force = false): bool
    {
        try {
            if ($force) {
                return $user->forceDelete();
            } else {

                return $user->delete();
            }
        } catch (Exception $e) {
            throw $e;
            Log::error($e->getMessage());
            return false;
        }
    }
    public static function restore(User $user): bool
    {
       
        try {
            return $user->restore();
        } catch (Exception $e) {
            throw $e;
            Log::error($e->getMessage());
            return false;
        }
    }
}
