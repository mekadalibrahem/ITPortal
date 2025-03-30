<?php

namespace App\Livewire\Admin\Permissions;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public $id;
    public $name;
    public $permission;

    public function mount()
    {

        if ($this->id) {

            $this->permission = Permission::where('id', $this->id)->first();
            $this->name = $this->permission->name;
        } else {
            abort(404);
        }
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'min:4', Rule::unique('permissions', 'name')->ignore($this->permission->id)],
        ]);

        $this->permission->name = $this->name;

        if ($this->permission->isDirty()) {
            if ($this->permission->save()) {
                Toaster::success('Permission [ ' . $this->name . ' ] saved ');
            }
        } else {
            Toaster::warning(trans('messages.Alrady saved'));
        }
    }

    public function render()
    {
        return view('livewire.admin.permissions.edit');
    }
}
