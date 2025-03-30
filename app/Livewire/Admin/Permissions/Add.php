<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class Add extends Component
{

    public $name = '';
    public $guard = '';


    public function store()
    {
        $this->validate([
            'name' => ['required', 'min:4', 'unique:permissions,name']
        ]);

        $permission = Permission::create([
            'name' => $this->name
        ]);

        if ($permission) {
            Toaster::success('permission [ ' . $this->name . ' ] saved ');
        }

        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.permissions.add');
    }
}
