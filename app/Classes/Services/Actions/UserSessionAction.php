<?php

namespace App\Classes\Services\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserSessionAction
{

    /**
     * force logout to user and clear sessions 
     *
     * @param User $user user will clear his sessions 
     * @param boolean $all_devices  by deafult clear just from other devices but if set true clear all  even current divice
     * @return boolean
     */
    public static function forcLogout(User $user, $all_devices = false): bool
    {
        try {
            if ($all_devices) {
                self::ForceLogoutAllDevices($user);
            } else {
                self::forcLogoutFromOtherDevices($user);
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
    }

    private  static function forcLogoutFromOtherDevices(User $user)
    {
        $ids = DB::table('sessions')
            ->where('user_id', '=', $user->id)
            ->where('id', '!=', session()->getId())
            ->pluck('id');


        if ($ids->isNotEmpty()) {
            DB::table('sessions')->whereIn('id', $ids)->delete();
        }
    }

    private static function forceLogoutAllDevices(User $user)
    {
        $ids = DB::table('sessions')
            ->where('user_id', '=', $user->id)
            ->pluck('id');

        
        if ($ids->isNotEmpty()) {
            DB::table('sessions')->whereIn('id', $ids)->delete();
        }
    }
}
