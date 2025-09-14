<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $notify;
    public $hidden = true;
    public $user_id;
    public function mount()
    {
        $this->user_id = Auth::user()->id;
    }
    #[On('show_notify', 'id')]
    public function index($id)
    {

        if ($id > 1) {
            $this->hidden = false;
            $notify  = Notification::where('id', $id)
                ->where(function ($query) {
                    $query->where('user_id', $this->user_id)
                        ->orWhere('from_id', $this->user_id);
                })
                ->first();

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
