<?php

namespace App\Livewire\Admin\Users;

use App\Classes\Services\Actions\UserAction;
use Illuminate\Support\Collection;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;

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
    public $roles;
    public $role;
    public Collection $user_roles;
    public $isemployee;

    public function mount()
    {
        $this->roles = Role::all();
        $this->user_roles = collect();
    }

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

            ]
        );

        $user = UserAction::register([
            'fname' => $this->fname,
            'mname' =>  $this->mname,
            'lname' =>  $this->lname,
            'national_id' =>  $this->national_id,
            "username" =>   $this->username,
            'email' =>  $this->email,
            'password' => $this->password,

        ], $this->user_roles->toArray());

        if ($user) {
            if ($this->isemployee) {
                UserAction::addToEmployee($user);
            }
            Toaster::success(trans('messages.Item Saved'));
            return redirect()->route('admin.auth.user.index');
        } else {
            Toaster::error(trans('messages.Faild Add Item'));
        }
    }
    public function addRole()
    {
        $role = $this->roles->where('id', '=', $this->role)->first();

        $this->user_roles->push([
            'id' => $role->id,
            'role' => $role
        ]);
        $this->reset(['role']);
    }
    public function removeRole($id)
    {
        $this->user_roles = $this->user_roles->reject(fn($item) => $item['id'] == $id);
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
