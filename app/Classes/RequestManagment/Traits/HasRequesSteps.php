<?php

namespace App\Classes\RequestManagment\Traits;


use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\RequestTemplates\OrderStep;
use Carbon\Carbon;


trait  HasRequesSteps
{




    public function end_step(RequestList $request_list)
    {



        $next_order_step = $this->next_step($request_list);
        $request_log = $this->get_request_log_for_step($request_list->id, $request_list->current_step_id);

        if ($request_log) {
            $request_log->end_at = Carbon::now();
        }
        $request_log->save();
        if ($next_order_step) {
            // updating reuqest_list current_step 
          
            $request_list->current_step_id = $next_order_step->request_tamplates_step_id;
            $request_list->save();
            return true;
        } else {
            // 
        }
        
    }


    public function next_step(RequestList $request_list)
    {
        $request_logs = $request_list->requestLog;
        $current_step = $request_logs->where('request_tamplates_step_id', $request_list->current_step_id)->first();
        $notWorkingSteps = $request_logs->where('id', ">", $current_step->id);

        return $notWorkingSteps->first() ?? null;
    }

    public function is_last_step(RequestList $request_list): bool
    {


        $next_order_step = $this->next_step($request_list);
        if ($next_order_step) {
            return false;
        } else {
            return true;
        }
    }
    public function get_request_log_for_step($request_list_id, $step_id): ?RequestLog
    {
        return RequestLog::where([
            'request_list_id' => $request_list_id,
            'request_tamplates_step_id' => $step_id

        ])->first();
    }
}
