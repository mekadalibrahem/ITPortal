<?php

namespace App\Classes\Services\Actions;

use App\Models\RequestLog;

class RoleBackRequests
{


    public static function roleBackAfterEmployeeArchived($user)
    {
        $employee = $user->employee;
        if ($employee) {
            // check if any log not  end 
            $logs  = RequestLog::query()
                ->where('start_at', '!=', null)
                ->where('end_at', '=', null)
                ->where('employee_id', '=', $employee->id)
                ->get();
            foreach ($logs as $log) {
                $log->employee_id = null;
                $deleted_employee = "current employee  with email ( $user->email ) archive \n removed form this request by ADMIN " . now()->format('Y-m-d H:i:s');
                $log->note  = $deleted_employee . "---------------------\n\n" . $log->note;
                $log->save();
            }
        }
    }
}
