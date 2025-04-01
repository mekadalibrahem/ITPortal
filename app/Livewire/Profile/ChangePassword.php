<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ChangePassword extends Component
{

    public $id;
    public $password;
    public $new_password;
    public $confirm_password;
    public $user ;

    public function mount()
    {

        $this->user = Auth::user();
    }


    public function edit()
    {
        $this->validate([
            'password' => 'required|min:8|string',
            'new_password' => 'required|min:8|string|same:confirm_password',
            'confirm_password' =>'required|min:8|string|same:new_password'
        ]);
        $user = $this->user;

        if (Hash::check($this->password, $user->password)) {
            $user->password = Hash::make($this->new_password);
            $user->save();
            Toaster::success("passowrd updated");
        }else{
            $this->addError('password' , trans('validation.current_password'));
        }
        $this->render();
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.profile.change-password');
    }
}
