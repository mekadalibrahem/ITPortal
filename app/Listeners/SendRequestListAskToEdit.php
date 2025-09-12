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
            
            $currentLog = RequestLog::query()->where([
                'request_list_id' =>  $event->requestListId,
                'request_tamplates_step_id' =>  $event->current_step_id
            ])->first();
            if (!$currentLog) {
                logger()->warning('No RequestLog found for request_list_id: ' . $event->requestListId .
                    ' and step_id: ' . $event->current_step_id . '. Note not updated.');
                return; 
            }

            $note = $event->message . "\n";
            $note .= "by : " . $event->byUserEmial . " (" . now()->format('Y-m-d H:i:s') . ")\n";
            $note .= "----------------------\n";
            $currentLog->note =  $note . "\n" . $currentLog->note;
            $currentLog->save();
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }
}
