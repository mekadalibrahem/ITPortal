<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{

    public $id;
    public $password;
    public $new_password;
    public $confirm_password;
    public $edit_passowrd = '';

    public function mount()
    {

        $this->id = Auth::user()->id;
    }


    public function edit()
    {
        $this->validate([
            'password' => 'required|min:8|string',
            'new_password' => 'required|min:8|string|same:confirm_password'
        ]);
        $user = User::find($this->id);

        if (Hash::check($this->password, $user->password)) {
            $user->password = Hash::make($this->new_password);
            $user->save();
            $this->edit_passowrd = "passowrd updated";
        }
        $this->render();
    }
    public function render()
    {
        return view('livewire.profile.change-password');
    }
}
