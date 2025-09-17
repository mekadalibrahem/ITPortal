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

    public function mount()
    {
        $this->count = Notification::where([
            'user_id' => $this->user_id,
            'read_at' => null
        ])->count();
    }
    #[On('notification_read')]
    public function  d()
    {
        $this->count = Notification::where([
            'user_id' => $this->user_id,
            'read_at' => null
        ])->count();
    }
    public function render()
    {



        return view('livewire.notification-counter');
    }
}
