<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Livewire\Component;

class Said extends Component
{

    public $notify_list = [];

    public function show($id)
    {
        if ($id > 0) {
            if ($notify = Notification::where([
                ["id", "=", $id],
                ["user_id", "=", auth()->user()->id],
            ])->first()) {
                $notify->mark_read();
                $this->dispatch('show_notify', id: $id);
                $this->dispatch('notification_read');
            }
        }


    }
    public function mount()
    {
        $this->notify_list = Notification::where('user_id', "=", auth()->user()->id)->orderBy("create_at", "desc")->get();
    }
    public function render()
    {
        return view(
            'livewire.user.notification.said'
        );
    }
}
