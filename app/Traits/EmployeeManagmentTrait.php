<?php

namespace App\Traits;

use App\Models\Department;
use App\Models\Employee;
use App\Models\RequestLog;

/**
 * this trait for managment Employees
 */
trait EmployeeManagmentTrait
{



    /**
     * update employee information
     * if user is Manager for department will remove manager for this department if employee department changed
     *
     * @param [type] $department_id new employee department
     * @return bool
     */
    public function updateEmployee($department_id)
    {

        $dep = Department::find($department_id);
        if ($this->isDirty('department_id')) {
            if ($this->is_manager()) {
                $dep->removeManager($this);
            }
            $dep->addEmployee($this);
            $this->save();
            return true;
        } else {
            // not changed any thing
        }
    }
    /**
     * return if current employee is manager of any department
     *
     * @return boolean
     */
    public function is_manager(): bool
    {


        $dep  = $this->department;
        return  (bool) ($dep->manager_id == $this->id);
    }
    /**
     * return array of id's for request_logs that will handle it employee
     * if employee is manager of departmetnt will return id's for all emoloyeies in his department
     * if employee not manager  will return just it's id's
     *
     * @return void
     */
    public  function get_request_log_ids()
    {

        if ($this->is_manager()) {
            $dep = $this->department;

            $emps = $dep->get_employees_id();

            $logs = RequestLog::whereIn("employee_id", $emps)->get();

            $logs_id = [];
            foreach ($logs as $log) {
                $logs_id[] = $log->id;
            }
            return array_unique($logs_id);
        } else {

            $logs = RequestLog::where("employee_id", '=', $this->id)->get();
            $logs_id = [];
            foreach ($logs as $log) {
                $logs_id[] = $log->id;
            }
            return array_unique($logs_id);
        }
    }

    /**
     * return employee how manager for department that employee belong to
     *
     * @return void
     */
    public function manager()
    {
        $dep = $this->department;
        $emps = Employee::where("id", "=", $dep->manager_id)->first();
        return $emps;
    }
    public function dep_name()
    {
        $dep = $this->department;
        if ($dep) {
            return $dep->name;
        } else {
            return null;
        }
    }
}
