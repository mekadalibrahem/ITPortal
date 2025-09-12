<?php

namespace App\Jobs;

use App\Classes\Services\RequestLogNoteBuilder\RequestLogNoteAskToEdit;
use App\Models\RequestLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ReuqetsListAskToEditJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public  $requestListId;
    public $currentStepId;
    public $userEmail;
    public $message;
    public $ACTION_TYPE = "ASK TO EDIT REQUEST DATA";
    /**
     * Create a new job instance.
     */
    public function __construct(
        int $requestListId,
        int $currentStepId,
        string $userEmail,
        string $message
    ) {
        $this->requestListId = $requestListId;
        $this->userEmail = $userEmail;
        $this->currentStepId = $currentStepId;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $currentLog = RequestLog::query()->where([
                'request_list_id' =>  $this->requestListId,
                'request_tamplates_step_id' =>  $this->currentStepId
            ])->first();

            if (!$currentLog) {
                logger()->warning('No RequestLog found for request_list_id: ' . $this->requestListId .
                    ' and step_id: ' . $this->currentStepId . '. Note not updated.');
                return;
            }
             $currentLog->note =  RequestLogNoteAskToEdit::build($this->userEmail, $this->message) . "\n" . $currentLog->note;
            $currentLog->save();
        } catch (\Throwable $th) {
            logger()->error(
                'Failed to log audit change',
                [
                    'request_list_id' => $this->requestListId,
                    'action' => $this->ACTION_TYPE,
                    'exception' => get_class($th),
                    'message' => $th->getMessage(),
                    'trace' => $th->getTraceAsString(),
                ]
            );
        }
    }
    /**
     * Define how many times the job may be attempted.
     */
    public function tries(): int
    {
        return 3;
    }

    /**
     * Define the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [5, 10, 20]; // Wait 5s, then 10s, then 20s
    }

    /**
     * The job failed to process.
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Audit log job permanently failed', [
            'request_list_id' => $this->requestListId,
            'action' => $this->ACTION_TYPE,
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
        ]);
    }
}
