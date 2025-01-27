<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $department ;
    public $employees ;
    public $hide = true;


    #[On("show_department" , 'id')]
    public function show($id){
        if($id>0){
            $dep = Department::where('id', '=' , $id)->first();
            if($dep){
                $this->department = $dep;
                $this->employees = $dep->employees;
                $this->hide = false;
            }

        }else{
            $this->hide = true;
        }
        $this->render();
    }
    /**
     * delete employee form curent department then re render component
     */
    public function delete($id){
        if($id> 0){
            $emp = Employee::where('id', '=' , $id)->first();
            if($emp){
                $emp->department_id = null;
                $emp->save();
                if($this->department->manager_id == $emp->id){
                    $this->department->manager_id = null;
                    $this->department->save();
                }
            }
        }
        $this->show($this->department->id);
    }
    public function render()
    {
        return view('livewire.admin.department.index');
    }
}
