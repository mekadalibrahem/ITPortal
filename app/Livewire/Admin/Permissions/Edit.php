<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{

    public $status = [] ;

    public $old_name ;
    public $new_name ;



    public function update(){
        $this->validate([
            'old_name' => ['required', 'min:4', 'exists:permissions,name' ] ,
            'new_name'=> ['required' , 'min:4']
        ]);

        $permission = Permission::findByName($this->old_name);
        $permission->name = $this->new_name ;

        if($permission->save()){
            $this->status = [
                'type' => 'success' ,
                'message' => 'Permission [ ' .$this->new_name .' ] saved '
            ];
            $this->dispatch('update_permission');
        }
    }

    public function render()
    {
        return view('livewire.admin.permissions.edit');
    }
}
