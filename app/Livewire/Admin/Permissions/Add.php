<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class Add extends Component
{

    public $name = '';
    public $guard = '';
    public $display_name;

    public function store()
    {
        $this->validate([
            'name' => ['required', 'min:4', 'unique:permissions,name'],
            'display_name' =>  ['required', 'min:4']
        ]);

        $permission = Permission::create([
            'name' => $this->name,
            'display_name' => $this->display_name
        ]);

        if ($permission) {
            Toaster::success('permission [ ' . $this->name . ' ] saved ');
            return redirect()->route('admin.auth.permission.index');
        }

        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.permissions.add');
    }
}
