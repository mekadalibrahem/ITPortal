<?php

namespace App\Livewire\Admin\Users;

use App\Classes\Services\Actions\UserAction;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{

    public $fname;
    public $lname;
    public $mname;
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $national_id;
    public $type;

    public function save()
    {
        $this->validate(
            [
                'fname' => ['required', 'string', 'max:255'],
                'mname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'national_id' => ['required', 'string', 'max:255'],
                "username" =>  ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],

                'password' => ['required', 'min:8', 'same:confirm_password'],
                "type" => ['required'],
            ]
        );
        $registerd = UserAction::register([
            'fname' => $this->fname,
            'mname' =>  $this->mname,
            'lname' =>  $this->lname,
            'national_id' =>  $this->national_id,
            "username" =>   $this->username,
            'email' =>  $this->email,
            'password' => $this->password,
            "type" => $this->type,
        ]);
        if ($registerd) {
            Toaster::success(trans('messages.Item Saved'));
            return redirect()->route('admin.auth.user.index');
        } else {
            Toaster::error(trans('messages.Faild Add Item'));
        }
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
