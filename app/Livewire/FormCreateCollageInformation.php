<?php

namespace App\Livewire;

use App\Models\CollageInformations;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormCreateCollageInformation extends Component
{
    #[Rule('required'  , message:'هذا الحقل مطلوب')]
    #[Rule('unique:collage_informations,name'  , message:'إن هذا الاسم مستخدم سابقا  ')]
    public $name = '';
    #[Rule('required'  , message:'هذا الحقل مطلوب')]
    public $value = '';




    public function create(){
        $this->validate();

        $collage = CollageInformations::create(
            [
                'name'=> $this->name ,
                'value' =>$this->value
            ]
        );

        session()->flash('create_collage_info_done', 'تم إضافة القيمة بنجاح');
        
        $this->dispatch('created');
        $this->reset();
        $this->render();
    }

    public function render()
    {
        return view('livewire.form-create-collage-information');
    }
}
