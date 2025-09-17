<?php

namespace App\Classes\Services\Actions;

use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

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

    public static function update(User $user, array $data,  bool|Collection $roles = false): bool
    {
        try {

            $updated = $user->update($data);
            if ($roles != false) {
                self::updateUserRoles($user, $roles);
            }
            return true;
        } catch (Exception $e) {
            // return false;
            throw $e;
        }
    }
    public static function updateUserRoles(User $user, Collection $roles): bool
    {
        try {
            $originalRoles = $user->roles;
            $rolesToAdd = $roles->diff($originalRoles);
            $rolesToRemove = $originalRoles->diff($roles);


            foreach ($rolesToRemove as $role) {
                if ($role->name === 'admin' && User::isLastAdmin($user)) {
                    Toaster::error(trans('messages.YOU CANNOT DELETE ROLE ADMIN SHOULD ADD ADMIN ROLE FOR ANOTHER USER BEFOR DELETE THIS ONE'));
                    return false;
                }
            }

            // Proceed with role assignment
            $user->assignRole($rolesToAdd->pluck('name')->toArray());

            foreach ($rolesToRemove as $role) {
                $user->removeRole($role);
            }

            return true;
        } catch (\Throwable $th) {
            Log::error('Failed to update user roles: ' . $th->getMessage());
            throw $th; // Re-throw after logging (return false is unreachable)
        }
    }
    public static function delete(User $user,  $force = false): bool
    {
        try {

            if (Gate::allows('delete', $user)) {
                RoleBackRequests::roleBackAfterEmployeeArchived($user);
                $deleted = false;
                if ($force) {
                    $deleted = $user->forceDelete();
                } else {

                    $deleted = $user->delete();
                }

                return  $deleted;
            } else {
                return false;
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
            if ($user->hasRole('employee_requests')) {
                // do nothing 
            } else {
                $user->assignRole('employee_requests');
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}
