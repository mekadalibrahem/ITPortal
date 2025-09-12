<?php

namespace App\Listeners;

use App\Classes\Services\RequestLogNoteBuilder\RequestLogNoteEditedBuilder;
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
                'request_list_id' =>  $event->requestListId,
                'request_tamplates_step_id' =>  $event->current_step_id
            ])->first();

            if (!$currentLog) {
                logger()->warning('No RequestLog found for request_list_id: ' . $event->requestListId .
                    ' and step_id: ' . $event->current_step_id . '. Note not updated.');
                return; 
            }
            $currentLog->note =  RequestLogNoteEditedBuilder::build($event->byUserEmail , $event->dataChanged) . "\n" . $currentLog->note;
            $currentLog->save();
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }
}
