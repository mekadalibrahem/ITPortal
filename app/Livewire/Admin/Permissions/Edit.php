<?php

namespace App\Livewire\Admin\Permissions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public $id;
    public $name;
    public $display_name;
    public $permission;

    public function mount()
    {

        if ($this->id) {

            $this->permission = Permission::where('id', $this->id)->first();
            $this->name = $this->permission->name;
            $this->display_name = $this->permission->display_name;
        } else {
            abort(404);
        }
    }

    public function update()
    {
       if (  $this->permission->id > 5){
            $this->validate([
                'name' => ['required', 'min:4', Rule::unique('permissions', 'name')->ignore($this->permission->id)],
                'display_name' => ['required', 'min:4'],
            ]);

            $this->permission->name = $this->name;
            $this->permission->display_name = $this->display_name;

            if ($this->permission->isDirty()) {
                if ($this->permission->save()) {
                    Toaster::success('Permission [ ' . $this->name . ' ] saved ');
                    return redirect()->route('admin.auth.permission.index');
                }
            } else {
                Toaster::warning(trans('messages.Alrady saved'));
            }
        } else {
            Toaster::warning(trans("messages.THIS ITEM IS STATIC CAN NOT EDIT OR DELETED"));
        }
    }

    public function render()
    {
        return view('livewire.admin.permissions.edit');
    }
}
