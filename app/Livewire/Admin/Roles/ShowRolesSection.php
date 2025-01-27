<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ShowRolesSection extends Component
{

    use WithPagination;
    use WithoutUrlPagination;

    public $status = [];
    public  $role_showed = 0 ;
    public $input_search = '';

    public function search()
    {

        if ($this->input_search == '') {
            return Role::where('id', '!=', 0)->orderBy('id', 'desc')->paginate(5);
        } else {
            return Role::where('name', 'like', $this->input_search . '%')->orderBy('id', 'desc')->paginate(5);
        }
    }
    public function delete($id)
    {
        // dd($id);
        $role =  Role::findById($id);
        if ($role) {
            if ($role->delete()) {
                $this->dispatch('role_deleted');

                // dd($id , $this->role_showed);
                if($id == $this->role_showed){
                    $this->index(0);
                }

            }
        }
    }

    public function index($id)
    {
        $this->role_showed = $id ;
        $this->dispatch('show_role_info' , id: $id);
    }


    #[On('role_deleted')]
    #[On('add-role')]
    public function render()
    {
        return view('livewire.admin.roles.show-roles-section', [
            'roles' => $this->search()
        ]);
    }
}
