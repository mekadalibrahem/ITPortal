<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationsCardsMin extends Component
{

    public $user_id;
    public  $notifications;

    public function mount()
    {
        $this->notifications = Notification::query()->where(
            [
                'user_id' => $this->user_id,
                'read_at' => null
            ]
        )->get();
    }

    public function markread($id)
    {

        $notification = $this->notifications->find($id);

        $notification->mark_read();
        $this->dispatch('notification_read');
        $this->mount();
    }



    public function render()
    {


        return view('livewire.notifications-cards-min');
    }
}
