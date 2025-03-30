<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;

class AddRoleSection extends Component
{

    public $name  = '';
    public $guard;


    public function store()
    {
        $this->validate([
            'name' => ['required', 'min:4', 'unique:roles,name']
        ]);

        $role = Role::create([
            'name' => $this->name ,
            'guard' => $this->guard ?? null
        ]);
        if($role){
           Toaster::success(trans('messages.Item Saved'));
        }else{
            Toaster::error(trans('messages.Faild Add Item'));
        }

        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.roles.add-role-section');
    }
}
