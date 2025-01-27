<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Show extends Component
{
    use WithPagination;
    use WithoutUrlPagination;
    public $status = [] ;
    public $input_search = '';


    public function search()
    {
        if ($this->input_search == '') {
            return Permission::where('id', '!=', 0)->orderBy('id', 'desc')->paginate(5);
        } else {
            return Permission::where('name', 'like', $this->input_search . '%')->orderBy('id', 'desc')->paginate(5);
        }
    }
    public function delete($id)
    {
        // dd($id);
        $permission =  Permission::findById($id);
        if ($permission) {
            if ($permission->delete()) {
                $this->dispatch('permission_deleted');
            }
        }
    }


    #[On('permission_deleted')]
    #[On('add_permission')]
    #[On('update_permission')]
    public function render()
    {
        return view('livewire.admin.permissions.show' , [
            'permissions' => $this->search()
        ]);
    }
}
