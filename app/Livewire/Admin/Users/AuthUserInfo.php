<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;

use Livewire\Component;



class AuthUserInfo extends Component
{

    public $permission_count = 0;
    public $status = [];
    public User $user ;
    public $email = "";
    public $input_search;

    public $new_permission;
    public $new_role;


    public function add_permission()
    {

        $this->validate([
            'new_permission' => ['required', 'min:4', 'exists:permissions,name']
        ]);
        if ($user = User::where('email', '=', $this->email)->first()) {
            if ($user->hasPermissionTo($this->new_permission)) {
                $this->status = [
                    'type' => 'warning',
                    'message' => "this user '" . $user->name  . "'  alreade have this permission '" . $this->new_permission . "'"
                ];
            } else {
                if ($user->givePermissionTo($this->new_permission)) {
                    $this->status = [
                        'type' => 'success',
                        'message' => " add  '" . $this->new_permission . "' to user '" . $user->name . "' done "
                    ];
                }
            }
        }
        $this->mount();
        $this->render();
    }


    public function add_role()
    {
        $this->validate([
            'new_role' => ['required', 'min:4', 'exists:roles,name']
        ]);
        if ($user = User::where('email', '=', $this->email)->first()) {
            if ($user->hasRole([$this->new_role])) {
                $this->status = [
                    'type' => 'warning',
                    'message' =>  "this user '" . $user->name  . "'  alreade have this role '" . $this->new_role . "'"
                ];
            } else {
                $user->assignRole($this->new_role);
                $this->status = [
                    'type' => 'success',
                    'message' => " add  '" . $this->new_role . "' to user '" . $user->name . "' done "
                ];
            }
        }
        $this->mount();
        $this->render();
    }

    public function remove_role($name)
    {
        if (!empty($name)) {
            try {
                if ($this->user->hasRole($name)) {
                    $this->user->removeRole($name);
                    $this->status = [
                        'type' => 'success',
                        'message' => " remove role '" . $name . "' from user '" . $this->user->name . "' done "
                    ];
                } else {
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            $this->mount();
            $this->render();
        }
    }

    public function remove_permission($name)
    {

        try {
            if (!empty($name)) {
                try {
                    if ($this->user->hasPermissionTo($name)) {
                        $this->user->revokePermissionTo($name);

                        $this->status = [
                            'type' => 'success',
                            'message' => " remove permission '" . $name . "' from user '" . $this->user->name . "' done "
                        ];
                    } else {
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $this->mount();
                $this->render();
            }else{
                dd('mount method empty email');
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function search()
    {
        $this->validate([
            'input_search' => ['required', 'min:4', 'exists:users,email']
        ]);

        $this->email = $this->input_search;

        $this->mount();
        $this->render();
    }
    public function mount()
    {
        if ($this->email != '') {
            try {
                $this->user =  User::where([
                    'email' => $this->email
                ])->with(['roles', 'permissions'])->first();
                // $roles = $this->user->roles ;
                // dd($roles[0]->permissions);

                $this->permission_count = 0;
            } catch (\Throwable $th) {
                dd($th);
            }
        }
    }

    public function render()
    {


        return view('livewire.admin.users.auth-user-info');
    }
}
