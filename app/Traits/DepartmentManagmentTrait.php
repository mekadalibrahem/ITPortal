<?php

namespace App\Traits;

use App\Models\Employee;

/**
 * this trait for managment Department Employees and Mnagers
 */
trait DepartmentManagmentTrait
{


    /**
     * add new Employee for Department
     *
     * @param Employee $e
     * @return void
     */
    public function  addEmployee(Employee $e)
    {


        $e->department_id = $this->id;
        $e->save();
    }
    /**
     * add new Employees for Department
     *
     * @param Employee ...$es
     * @return void
     */
    public function addEmployees(Employee ...$es)
    {
        foreach ($es as $em) {
            $this->addEmployee($em);
        }
    }

    /**
     * remove Employee from department
     * Note:  if this employee is Manager for department will remove Manager for this department
     *
     * @param Employee $e
     * @return void
     */
    public function removeEmployee(Employee $e)
    {
        if ($this->manager_id == $e->id) {
            $this->reomveManager();
        }
        $e->department_id = null;
        $e->save();
    }

    /**
     * remove Employees from department
     *
     * @param Employee $e
     * @return void
     */
    public function removeEmployees(Employee ...$es)
    {
        foreach ($es as $e) {
            $this->removeEmployee($e);
        }
    }
    /**
     * add Manager for department
     * Note  :  if Employee who will be manager for department it's not in this department so automaticaly will add for deaprtemtn
     *
     * @param Employee $e
     * @return void
     */
    public function addManager(Employee $e)
    {
        $this->addEmployee($e);
        $this->manager_id = $e->id;
        $this->save();
    }

    /**
     * remove manager form department
     * Note: Employee will not removed from department if you wont remove it set parameter to true
     *
     * @param boolean $is_delete_employee_from_department
     * @return void
     */
    public function reomveManager(bool $is_delete_employee_from_department = false)
    {
        if($is_delete_employee_from_department && $this->manager_id > 0){
            $e = Employee::find($this->manager_id);
            $this->removeEmployee($e);
        }
        $this->manager_id = null;
        $this->save();
    }

    /**
     * set value for department manager
     *
     * @param Employee|null $e set new manager if (employee ) or remove manager if it's null
     * @param boolean $is_delete_employee_from_department remove manager employee from this department
     * @return void
     */
    public function setManager(Employee|null $e ,  bool $is_delete_employee_from_department = false){
        if($e==null){
            $this->reomveManager($is_delete_employee_from_department);
        }else{
            $this->addManager($e);
        }
    }
}
