<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationCounter extends Component
{

    public $user_id;

    public $count;



    #[On('notification_read')]
    public function render()
    {

        $this->count = Cache::remember($this->user_id . '-notifications-unread-count', 1800, function () {
            return Notification::where([
                'user_id' => $this->user_id,
                'read_at' => null
            ])->count();;
        });
        return view('livewire.notification-counter');
    }
}
