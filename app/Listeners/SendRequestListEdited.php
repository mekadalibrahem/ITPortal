<?php

namespace App\Listeners;

use App\Events\RequestListEdited;
use App\Models\RequestLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequestListEdited
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
    public function handle(RequestListEdited $event): void
    {
        try {
            $currentLog = RequestLog::query()->where([
                'request_list_id' =>  $event->requestList->id,
                'request_tamplates_step_id' =>  $event->requestList->current_step_id
            ])->first();

            if (!$currentLog) {
                logger()->warning('No RequestLog found for request_list_id: ' . $event->requestList->id .
                    ' and step_id: ' . $event->requestList->current_step_id . '. Note not updated.');
                return; 
            }

            $note = "Data updated : \n";

            foreach ($event->dataChanged as $item) {
                if (!$item['isImage']) {
                    $note .=  "[ " . $item['key'] . " ] from [" . $item['old'] . '] to [' . $item['new'] . "] \n";
                } else {
                    $note .=  "[ " . $item['key'] . " ] image updated \n";
                }
            }
            $note .= "\nby : " . $event->requestList->user->email . " (" . now()->format('Y-m-d H:i:s') . ")\n";
            $note .= "---------------------------\n";
            $currentLog->note =  $note . "\n" . $currentLog->note;
            $currentLog->save();
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }
}
