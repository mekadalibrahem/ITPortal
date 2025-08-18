<?php

namespace  App\Traits\Employee\Requests;

use App\Enums\StepRolesEnum;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\RequestTemplates\RequestTemplateStep;
use Illuminate\Database\Eloquent\Collection;

trait EmployeeRequestManagment
{
    protected $allowed_steps = null ;

   
    public function get_requests_ids()
    {
        $steps = $this->get_allowed_steps(true);
    

        if ($steps) {
            $steps_ids = $steps->pluck('id');

            $query = RequestLog::whereIn('request_tamplates_step_id', $steps_ids);
           
            return $query->distinct()->pluck('request_list_id');
        } else {
            return [];
        }
    }
    /**
     * get all steps that can employee work on it
     *
     * @return Collection|null
     */
    public function get_allowed_steps($force = false): ?Collection
    {   
       if(!$this->allowed_steps  || $force){
         $query = RequestTemplateStep::where('department_id', $this->department_id);

        if (!$this->is_manager()) {
            $query->where('role', StepRolesEnum::EMPLOYEE->value);
        }
        $this->allowed_steps = $query->get();
       }
        return $this->allowed_steps;
    }
    public function can_work($request_list , $force= false){
      $steps = $this->get_allowed_steps($force);
      $steps = $steps->pluck('id');
      
      return $steps->contains($request_list->current_step_id);
    }
    public function assign_to($request_list)
    {
      
        
           
       
        $request_logs  = $request_list->requestLog;
        if ($request_logs) {
            $log = $request_logs->where('request_tamplates_step_id', $request_list->current_step_id)->last();
            if ($log) {
                return $log->employee->user ?? null;
            } else {
                return null;
            }
        } else {
            return null;
        }
       
    }
   
}
