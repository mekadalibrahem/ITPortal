<?php

namespace App\Listeners;

use App\Events\RequestListAskToEdit;
use App\Models\RequestList;
use App\Models\RequestLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequestListAskToEdit
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RequestListAskToEdit $event): void
    {
        try {
            $requestList =  $event->requestList;
            $currentLog = RequestLog::query()->where([
                'request_list_id' =>  $event->requestList->id,
                'request_tamplates_step_id' =>  $event->requestList->current_step_id
            ])->first();
            $note = $event->message . "\n";
            $note .= "by : " . $currentLog->employee->user->email . " (" . now()->format('Y-m-d H:i:s') . ")\n";
            $note .= "----------------------\n";
            $currentLog->note =  $note . "\n" . $currentLog->note;
            $currentLog->save();
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }
}
