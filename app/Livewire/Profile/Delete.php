<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Delete extends Component
{
    public $delete_status = [];

    public $password_delete = '';




    public function delete(){
        $this->validate([
            'password_delete' => 'required|min:8'
        ]);
        if (Hash::check($this->password_delete, Auth::user()->password)) {
            $user = User::find(Auth::user()->id);


            Auth::logout();

            $user->delete();

            session()->invalidate();
            session()->regenerateToken();

            return Redirect::to('/');
        } else {
            $this->delete_status = [
                'type' => 'danger' ,
                'message' =>"wrong password"
            ];
            $this->render();
        }
    }

    public function render()
    {
        return view('livewire.profile.delete');
    }
}
