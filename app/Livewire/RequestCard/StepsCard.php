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
    public $hasnote = true;

    public function init_steps()
    {
        if (!$this->request_list) {
            return collect();
        }
        $isRejected = $this->request_list->isRejected();

        $rejectedStepId = null;
        $reachedRejectedStep = false;
        $lastLog = $this->request_list->requestLog->where('employee_id', '!=', null)->sortByDesc('id')->first();

        // If rejected, find the last logged step
        if ($isRejected) {
            $lastLog = $this->request_list->requestLog->where('employee_id', '!=', null)->sortByDesc('id')->first();
            $rejectedStepId = $lastLog ? $lastLog->request_tamplates_step_id : null;
        }
        return $this->request_list->requestLog->map(function ($log) use ($isRejected, $rejectedStepId, &$reachedRejectedStep) {
            $status = 'not_working';
            $time = null;
            $employee = null;
            if ($log->start_at != null) {
                $time = $log->start_at;
                $employee = $log->employee->user->fullname() ?? null;
                if ($log->end_at != null) {
                    $time .= " - " . $log->end_at;
                } else {
                    $time .= " - now";
                }
            }
            if ($isRejected) {
                // Mark this step as rejected if it's the one that caused rejection
                if ($log->request_tamplates_step_id == $rejectedStepId) {
                    $status = 'rejected';
                    $reachedRejectedStep = true;
                }
                // Mark as rejected if it's after the rejection point
                elseif ($reachedRejectedStep) {
                    $status = 'rejected';
                }
                // Normal status before rejection point
                elseif ($log->start_at != null && $log->end_at === null) {
                    $status = 'working';
                } elseif ($log->start_at != null && $log->end_at != null) {
                    $status = 'done';
                }
            } else {

                // Normal status when not rejected
                if ($log->start_at != null && $log->end_at === null) {
                    $status = 'working';
                } elseif ($log->start_at != null && $log->end_at != null) {
                    $status = 'done';
                }
            }

            return [
                'id' => $log->id,
                'status' => $status,
                'title' => $log->step->name ?? 'Unknown Step',
                'time' => $time,
                'step_id' => $log->step->id,
                'note' => $employee ?? "-----",
                'is_rejected' => $status === 'rejected'
            ];
        })->sortBy('id')->values();
    }
    public function mount()
    {
        if ($this->id > 0) {
            $this->request_list = RequestList::where('id', $this->id)
                ->with(['requestLog', 'requestLog.employee.user', 'requestLog.step'])->first();

            if ($this->request_list) {

                $this->steps = $this->init_steps();

                $status = $this->request_list->status;
                switch ($status) {
                    case RequestStatusEnum::REJECTED->value:
                        $this->end_status = "rejected";

                        break;
                    case RequestStatusEnum::END_ACCEPT->value:
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
