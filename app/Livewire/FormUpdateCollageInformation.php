<?php

namespace App\Livewire;

use App\Models\CollageInformations;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormUpdateCollageInformation extends Component
{

    #[Rule('required')]
    #[Rule('exists:collage_informations,name')]
    public $old_name = '';

    // #[Rule('unique:collage_informations,name'  , message:'إن هذا الاسم مستخدم سابقا  ')]
    public $new_name = '' ;


    public $new_value = '';



    public function edit(){
        $this->validate();

        $info = CollageInformations::where(['name' => $this->old_name])->first();
        // dd($info);
        if($this->new_name  != '' ){
            $info_exist = CollageInformations::where('name' , '=' , $this->new_name)->first();
            // dd($info_exist);
            if($info_exist){
                session()->flash('name_exists' , 'هذا الاسم مستخدم سابقا') ;
            }else{

                $info->name = $this->new_name ;
            }

        }
        if($this->new_value != ''){
            $info->value = $this->new_value;
        }

        if($info->isDirty()){
            $info->save();
            session()->flash('update_collage_info_done' , 'تم تعديل البيانات');
        }else{
            // nothing chanag
        }
        $this->dispatch('updated');
        $this->reset();
        $this->render();

    }


    public function render()
    {
        return view('livewire.form-update-collage-information');
    }
}
