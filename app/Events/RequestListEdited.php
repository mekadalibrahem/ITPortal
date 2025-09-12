<?php

namespace App\Events;

use App\Models\RequestList;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use App\Jobs\ReuqetsListEdited as JobRequestListEdited ;
use Illuminate\Queue\SerializesModels;

class RequestListEdited implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public  $requestListId,  public $byUserEmail, public $current_step_id, public array $dataChanged)
    {
            JobRequestListEdited::dispatch(
            $requestListId,
            $byUserEmail,
            $current_step_id,
            $dataChanged,
            "REQUEST LIST UPDATED"
        );
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('request.' . $this->requestListId),
        ];
    }
}
