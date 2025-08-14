<?php

namespace App\Livewire\RequestCard;

use App\Enums\RequestStatusEnum;
use App\Models\RequestList;
use App\Models\RequestTemplates\OrderStep;
use Illuminate\Support\Collection;
use Livewire\Component;

class StepsCard extends Component
{
    public $id;
    public $request_list;
    public $all_template_steps;
    public Collection $steps;
    public $end_status;

    public function init_steps()
    {
        if (!$this->request_list || !$this->all_template_steps) {
            return collect();
        }

        $isRejected = $this->request_list->status === 'rejected';
        $rejectedStepId = null;
        $reachedRejectedStep = false;

        // If rejected, find the last logged step
        if ($isRejected) {
            $lastLog = $this->request_list->requestLog->sortByDesc('created_at')->first();
            $rejectedStepId = $lastLog ? $lastLog->request_tamplates_step_id : null;
        }

        return $this->all_template_steps->map(function ($item) use ($isRejected, $rejectedStepId, &$reachedRejectedStep) {
            $logEntry = $this->request_list->requestLog
                ->where('request_tamplates_step_id', $item->request_tamplates_steps_id)
                ->first();

            $status = 'not_working';
            $time = null;
            $employee = null;

            if ($logEntry) {
                if ($isRejected) {
                    // Mark this step as rejected if it's the one that caused rejection
                    if ($item->request_tamplates_steps_id == $rejectedStepId) {
                        $status = 'rejected';
                        $reachedRejectedStep = true;
                    }
                    // Mark as rejected if it's after the rejection point
                    elseif ($reachedRejectedStep) {
                        $status = 'rejected';
                    }
                    // Normal status before rejection point
                    elseif ($logEntry->end_at === null) {
                        $status = 'working';
                        $time = $logEntry->created_at . ' - now';
                    } else {
                        $status = 'done';
                        $time = $logEntry->created_at . ' - ' . $logEntry->end_at;
                    }
                } else {
                    // Normal status when not rejected
                    if ($logEntry->end_at === null) {
                        $status = 'working';
                        $time = $logEntry->created_at . ' - now';
                    } else {
                        $status = 'done';
                        $time = $logEntry->created_at . ' - ' . $logEntry->end_at;
                    }
                }

                $employee = $logEntry->employee->user->fullname() ;
            } elseif ($isRejected && $reachedRejectedStep) {
                // Steps after rejection point with no log entry
                $status = 'rejected';
            }

            return [
                'status' => $status,
                'title' => $item->step->name ?? 'Unknown Step',
                'time' => $time,
                'step_id' => $item->request_tamplates_steps_id,
                'order' => $item->order,
                'note' => $employee ?? "-----" ,
                'is_rejected' => $status === 'rejected'
            ];
        })->sortBy('order')->values();
    }
    public function mount()
    {
        if ($this->id > 0) {
            $this->request_list = RequestList::where('id', $this->id)
                ->with(['requestLog', 'requestLog.employee.user'])->first();
            if ($this->request_list) {
                $this->all_template_steps = OrderStep::where('request_template_id', $this->request_list->request_template_id)
                    ->with('step')
                    ->orderBy('order')->get();

                $this->steps = $this->init_steps();
                $status = $this->request_list->status;
                switch ($status) {
                    case RequestStatusEnum::REJECTED->value :case RequestStatusEnum::END_REJECTED->value :case   RequestStatusEnum::TIMEOUT->value:
                        $this->end_status = "rejected";
                        
                        break;
                    case RequestStatusEnum::END_ACCEPT->value :case  RequestStatusEnum::END_DELEVERED->value :case  RequestStatusEnum::TIMEOUT->value:
                        $this->end_status = "done";
                        break;
                    default:
                        $this->end_status = "not_working";
                        break;
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.request-card.steps-card');
    }
}
