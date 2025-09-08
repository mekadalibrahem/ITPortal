<?php

namespace App\Livewire\Admin\Users;

use App\Classes\Services\Actions\UserAction;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public $id;
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
    public $user;
    public Collection $user_roles;

    public function index()
    {
        $user = User::where('id', $this->id)->with('roles')->first();
        if ($user) {
            $this->user = $user;
            $this->fname = $user->fname;
            $this->mname = $user->mname;
            $this->lname = $user->lname;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->national_id  = $user->national_id;
            $this->user_roles = $user->roles;
        } else {
            abort(404);
        }
    }
    public function mount()
    {
        $this->index();
        $this->roles = Role::all();
    }

    public function save()
    {
        $this->validate(
            [
                'fname' => ['required', 'string', 'max:255'],
                'mname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'national_id' => ['required', 'string', 'max:255'],
                "username" =>  ['required', 'string', 'max:255', 'unique:users,username,' . $this->user->id],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],


            ]
        );

        $registerd = UserAction::update($this->user, [
            'fname' => $this->fname,
            'mname' =>  $this->mname,
            'lname' =>  $this->lname,
            'national_id' =>  $this->national_id,
            "username" =>   $this->username,
            'email' =>  $this->email,

        ], $this->user_roles);
        if ($registerd) {
            Toaster::success(trans('messages.Item Saved'));
            return redirect()->route('admin.auth.user.index');
        } else {
            Toaster::error(trans('messages.Faild save item'));
        }
    }
    public function addRole()
    {
        $role = $this->roles->where('id', '=', $this->role)->first();

        $this->user_roles->push($role);
        $this->reset(['role']);
    }
    public function removeRole($id)
    {
        $this->user_roles = $this->user_roles->reject(fn($item) => $item->id == $id);
    }

    public function resetPassword()
    {
        try {
            UserAction::resetPassword($this->user);
            Toaster::success(trans('messages.Item Saved'));
            return redirect()->route('admin.auth.user.index');
        } catch (Exception $e) {
            Toaster::error(trans('messages.Faild save item'));
        }
    }
    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
