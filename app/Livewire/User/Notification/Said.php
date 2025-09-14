<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Said extends Component
{
    public $notify_list = [];
    public $activeTab = 'all';
    public $user_id;
    public function mount()
    {
        $this->user_id = Auth::user()->id;
        $this->loadNotifications();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $query = Notification::where(function ($query) {
            $query->where('user_id', $this->user_id)
                ->orWhere('from_id', $this->user_id);
        })
            ->with(['user', 'from']);

        if ($this->activeTab === 'sent') {
            $query->where('from_id',  $this->user_id);
        } elseif ($this->activeTab === 'received') {
            $query->where('user_id', '=',  $this->user_id);
        }

        $this->notify_list = $query->orderBy('create_at', 'desc')->get();
    }
    public function createNew()
    {

        return redirect()->route('user.notification.create');
    }
    public function show($id)
    {
        if ($id > 0) {
            $notify = Notification::where('id', $id)
                ->where(function ($query) {
                    $query->where('user_id', $this->user_id)
                        ->orWhere('from_id', $this->user_id);
                })
                ->first();

            if ($notify) {
                if ($notify->from_id != $this->user_id) {
                    $notify->mark_read();
                    $this->dispatch('notification_read');
                }
                $this->dispatch('show_notify', id: $id);
            }
        }
    }

    public function render()
    {
        return view('livewire.user.notification.said');
    }
}
