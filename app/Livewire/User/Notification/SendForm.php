<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class SendForm extends Component
{
    public $email;
    public $content;
    public $user_id;
    public $status = [];

    public function mount($email = null)
    {
        if ($email) {
            $this->email = $email;
        }
        $this->user_id = Auth::user()->id;
    }
    public function send()
    {
        $this->validate(
            [
                "email" => "required|email|exists:users,email",
                "content" => "required|min:8",
            ]
        );

        $to_user = User::where("email", "=", $this->email)->first();

        Notification::create([
            "content" => $this->content,
            "user_id" => $to_user->id,
            "from_id" =>  $this->user_id,
            'create_at' => Carbon::now(),
        ]);
        Toaster::success(trans('messages.notify send'));
        return redirect()->route('user.notification.index');
    }
    public function render()
    {

        return view('livewire.user.notification.send-form');
    }
}
