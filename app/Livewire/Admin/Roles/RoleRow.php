<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleRow extends Component
{
    public $role;
    public $name;
    protected $id ;

    public function delete(){
        $role =  Role::findByName($this->name);
        if($role){
            if($role->delete()){
                $this->dispatch('role_deleted');
            }
        }
    }

    public function render()
    {

        return view('livewire.admin.roles.roles-row');
    }
}
