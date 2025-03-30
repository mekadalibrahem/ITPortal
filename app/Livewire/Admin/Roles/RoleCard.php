<?php

namespace App\Livewire\Admin\Roles;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Termwind\render;

class RoleCard extends Component
{

    public $id;
    public $role;
    public $permissions;
    public $role_permissions = [];

    public $new_name = '';
    public $status = [];
    public $status_permission = [];
    public $name = "";

    public $add_permission = 0;

    public function show()
    {
        if ($this->id) {
            $this->role = Role::where('id', '=', $this->id)->with('permissions')->first();
            if ($this->role) {
                $this->role_permissions = $this->role->permissions;
                $this->name = $this->role->name;
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function mount()
    {
        $this->show();
        $this->permissions = Permission::all();
    }

    public function new_permission()
    {
        if ($this->add_permission > 0) {

            if ($permission = Permission::findById($this->add_permission)) {
                $this->role->givePermissionTo($permission);
                Toaster::success('permission [ ' . $permission->name . '  ] added  ');
                $this->show();
                $this->render();
            } else {
                Toaster::error('permission not add  error permisions  ');
            }
        }
    }

    public function remove_permission($permission_name)
    {
        if ($permission_name != '') {
            try {
                $permission = Permission::findByName($permission_name);
                $this->role->revokePermissionTo($permission);
                Toaster::success('permission [ ' . $permission->name . '  ] removed  ');
                $this->show();
                $this->render();
            } catch (\Throwable $th) {
              Log::error(__CLASS__ .'@' . __FUNCTION__ . " : Error is => " . $th->getMessage());
            }
        }
    }
    public function update()
    {

        $this->validate([
            'name' => ['required', 'min:4', 'unique:roles,name']
        ]);
        // dd($this->new_name);
        $this->role->name = $this->name;

        if ($this->role->save()) {

            Toaster::success(trans('messages.Item Saved'));

        }
    }
    public function render()
    {
        return view('livewire.admin.roles.role-card');
    }
}
