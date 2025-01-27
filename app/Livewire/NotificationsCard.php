<?php

namespace App\Livewire;

use App\Models\Notification;
use Carbon\Carbon;
use Livewire\Component;

class NotificationsCard extends Component
{

    public Notification $notification ;
    public $text = 'read_at ' ;


    public function markread(){

        $this->notification->mark_read();
        $this->text = $this->notification->read_at->format() ;

        $this->dispatch('notification_read');
    }

    public function render()
    {
        return view('livewire.notifications-card');
    }
}
