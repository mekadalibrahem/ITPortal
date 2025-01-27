<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $notify;
    public $hidden = true;

    #[On('show_notify', 'id')]
    public function index($id)
    {

        if ($id > 1) {
            $this->hidden = false;
            $notify  = Notification::where([
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id],
            ])->first();

            if ($notify) {
                $this->notify = $notify;
            }
        } else {
            $this->hidden = true;
        }

        $this->render();
    }
    public function render()
    {
        return view('livewire.user.notification.show');
    }
}
