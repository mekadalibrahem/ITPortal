<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use App\Models\User;
use Livewire\Component;

class SendForm extends Component
{
    public $email;
    public $content;

    public $status = [];
    public function send()
    {
        $this->validate(
            [
                "email" => "required|email|exists:users,email",
                "content" => "required|min:8",
            ]
        );

        $to_user = User::where("email" , "=" , $this->email)->first();
       
        Notification::create([
            "content" => $this->content,
            "user_id" => $to_user->id,
            "from_id" => auth()->user()->id,
        ]);
        $this->status = [
            "type"=> "success",
            "message"=> trans("messages.notify send"),
        ] ;


    }


    public function mount()
    {

    }
    public function render()
    {

        return view('livewire.user.notification.send-form');
    }
}
