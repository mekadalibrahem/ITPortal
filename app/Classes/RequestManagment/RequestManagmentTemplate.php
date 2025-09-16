<?php

namespace App\Classes\RequestManagment;

use App\Classes\RequestManagment\Traits\HasRequesSteps;
use App\Classes\Services\MessagesBuilder\RequestMessageBuilder;
use App\Enums\RequestStatusEnum;
use App\Models\RequestLog;
use Carbon\Carbon;

class RequestManagmentTemplate extends AbstractRequestManagment
{

    use HasRequesSteps;
    public function start()
    {
        $log = RequestLog::where([
            'request_tamplates_step_id' => $this->request_list->current_step_id,
            'request_list_id' => $this->request_list->id
        ])->first();
        $log->employee_id = $this->employee->id;
        $log->start_at = Carbon::now();
        $this->request_list->status = RequestStatusEnum::WORKING->value;
        $this->request_list->save();
        if ($log->save()) {
            return true;
        } else {
            return false;
        }
    }
    public function next()
    {
        $this->end_step($this->request_list);
    }
    public function end($new_statues = RequestStatusEnum::END_ACCEPT->value, ?string $message = null)
    {
        $this->end_step($this->request_list);
        $this->request_list->status = $new_statues;
        $this->request_list->end_at = Carbon::now();
        $this->request_list->save();
        // code for sent notification to user 
        $this->sendNotification(RequestMessageBuilder::build($message, $this->request_list->id));
    }
    public function accept(?string $message = null)
    {
        $this->end(RequestStatusEnum::END_ACCEPT->value, $message);
    }
    public function reject(?string $message = null)
    {
        $this->end(RequestStatusEnum::REJECTED->value, $message);
    }


    function hasNext(): bool
    {
        return !$this->is_last_step($this->request_list);
    }
}
