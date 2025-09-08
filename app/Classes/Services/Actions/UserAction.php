<?php

namespace App\Classes\Services\Actions;

use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserAction
{
    public static $USER_TYPE_STUDENT = 1;
    public static $USER_TYPE_EMPLOYEE = 2;

    public static function register(array $user_data, array $roles = [])
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
            if (!empty($roles)) {
                $user->assignRole($roles);
            }
        } else {
            return false;
        }

        return $user;
    }

    public static function update(User $user, array $data,  Collection $roles): bool
    {
        try {

            $updated = $user->update($data);
            self::updateUserRoles($user, $roles);
            return true;
        } catch (Exception $e) {
            // return false;
            throw $e;
        }
    }
    public static function updateUserRoles(User $user, Collection $roles): bool
    {
        try {
            $original_roles = $user->roles;
            $roles_2_add = $roles->diff($original_roles);
            $roles_2_remove = $original_roles->diff($roles);
            $user->assignRole($roles_2_add->pluck('name')->toArray());


            foreach ($roles_2_remove as $role) {
                $user->removeRole($role);
            }


            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
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
    public static function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make($user->national_id)
        ]);
        return true;
    }

    public static function addToEmployee(User $user)
    {
        try {
            Employee::create([
                'user_id' => $user->id
            ]);
            if ($user->hasRole('employee')) {
                // do nothing 
            } else {
                $user->assignRole('employee');
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}
