<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationsCardsMin extends Component
{

    public $user_id ;
    public  $notifications ;




    #[On('notification_read')]
    public function render()
    {

        $this->notifications = Notification::query()->where(
            [
                'user_id' =>$this->user_id  ,
                'read_at'=> null
            ]
        )->get();
        return view('livewire.notifications-cards-min');
    }
}
