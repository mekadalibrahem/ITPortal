<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Said extends Component
{
    public $notify_list;
    public $activeTab = 'all';
    public $user_id;
    public $all;
    public $sent;
    public $received;
    public $notifications;
    public $notification;
    public $hidden = true;
    public function mount()
    {
        $this->user_id = Auth::id();
        $this->loadNotifications();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->notifications = $this->notify_list;
        if ($this->activeTab == 'sent') {
            $this->notifications = $this->sent;
        } elseif ($this->activeTab == 'received') {
            $this->notifications = $this->received;
        }
    }

    public function loadNotifications()
    {
        $this->notify_list  = Notification::where(function ($query) {
            $query->where('user_id', $this->user_id)
                ->orWhere('from_id', $this->user_id);
        })->with(['from:id,email'])
            ->orderBy('id', 'desc')->get();


        $this->received = $this->notify_list->filter(function ($item) {
            return $item->user_id == $this->user_id;
        });

        $this->sent = $this->notify_list->filter(function ($item) {
            return $item->from_id == $this->user_id;
        });




        $this->notifications = $this->notify_list;
    }
    public function createNew()
    {

        return redirect()->route('user.notification.create');
    }
    public function show($id)
    {
        if ($id > 0) {

            $notify = $this->notifications->firstWhere('id', $id);


            if ($notify && ($notify->user_id == $this->user_id || $notify->from_id == $this->user_id)) {
                $this->hidden = false;
                $this->notification = $notify;

                if ($notify->from_id != $this->user_id) {
                    $notify->mark_read();
                    $this->dispatch('notification_read');
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.user.notification.said');
    }
}
