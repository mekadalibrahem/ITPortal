<?php

namespace App\Livewire\Admin\Roles;


use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Termwind\render;

class RoleCard extends Component
{

    public $permissions;
    public $new_name = '';
    public $status = [];
    public $status_permission = [] ;
    public $name = "";
    public $key = 0;
    public $role;
    public $add_permission = 0;
    public $role_permissions = [];

    #[On('show_role_info')]
    public function show($id)
    {

        $this->reset();
        $this->key = $id;
        $this->mount();
        $this->render();
    }

    public function mount()
    {
        if ($this->key > 0) {
            $this->permissions = Permission::all();
            $this->role = Role::findById($this->key);
            $this->role_permissions = $this->role->permissions()->get();
            $this->name = $this->role->name;
        }
    }

    public function new_permission()
    {
        if ($this->add_permission > 0) {

            if ($permission = Permission::findById($this->add_permission)) {
                $this->role->givePermissionTo($permission);
                $this->status_permission = [
                    'type' => 'success',
                    'message' => 'permission [ '. $permission->name .'  ] added  '
                ];
                $this->mount();
                $this->render();
            } else {
                $this->status_permission = [
                    'type' => 'danger',
                    'message' => 'permission not add  error permisions  '
                ];
            }
        }
    }

    public function remove_permission($permission_name){
        if($permission_name != ''){
           try {
                $permission = Permission::findByName($permission_name);
                $this->role->revokePermissionTo($permission);
                $this->status_permission = [
                    'type' => 'success',
                    'message' => 'permission [ '. $permission->name .'  ] removed  '
                ];
                $this->mount();
                $this->render();
           } catch (\Throwable $th) {
            //throw $th;
           }
        }
    }
    public function update()
    {

        $this->validate([
            'new_name' => ['required', 'min:4', 'unique:roles,name']
        ]);
        // dd($this->new_name);
        $this->role->name = $this->new_name;

        if ($this->role->save()) {

            $this->status = [
                'type' => 'success',
                'message' => 'role  updated '
            ];
            $this->mount();
            $this->render();
        }
    }
    public function render()
    {
        return view('livewire.admin.roles.role-card');
    }
}
