<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    use WithoutUrlPagination;



    public function mount(){

    }

    public function index($id){
        if($id>0){

            $this->dispatch('show_department', id: $id);

        }
    }

    public function delete($id){
        if($id >0){
            $dep = Department::where("id" , '=' , $id)->first();
            if($dep){
                $dep->delete();
               $this->dispatch('deps_changed');
            }
        }

    }

    #[On('deps_changed')]
    public function render()
    {

        return view('livewire.admin.department.show', [
            'departments' => Department::where('id' , '>' , 0)->orderBy('id', 'asc')->paginate(5),
        ]);
    }
}
