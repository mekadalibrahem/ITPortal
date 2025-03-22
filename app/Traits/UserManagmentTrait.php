<?php

namespace App\Traits;

use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait UserManagmentTrait
{

    public const EMPLOYEE_ROLE_NAME = "employee";

    /**
     * add new Employee
     *
     * @param [type] $department_id
     * @return void
     */
    public function addEmployee($department_id)
    {
        DB::transaction(function () use ($department_id) {
            Log::info(__CLASS__ . "@" . __FUNCTION__ .' -> add employee transaction start'  );
            try {
                Employee::create([
                    'user_id' => $this->id,
                    'department_id' => $department_id ?? null
                ]);
                $this->assignRole(self::EMPLOYEE_ROLE_NAME);
                DB::commit();
                Log::info(__CLASS__ . "@" . __FUNCTION__ .' -> add employee transaction end'  );
            } catch (\Throwable $th) {
                Log::error(__CLASS__ . "@" . __FUNCTION__ .' -> ERROR  is :'  . $th->getMessage() );
                throw $th;
            }
        });
    }

    public function removeEmployee(){
        throw new Exception('NOT SUPPORTED YET');
    }
}
