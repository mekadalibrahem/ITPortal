<?php

namespace App\Livewire;

use App\Models\RequestType;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormUpdateRequestType extends Component
{

    #[Rule('required' , message: 'هذا الحقل مطلوب')]
    #[Rule('exists:request_types,type' ,message: "هذا النوع غير مسجل ")]
    public $old_type ='' ;
    #[Rule('required' , message:"هذا الحقل مطلوب")]
    #[Rule('unique:request_types,type' , message:'هذا النوع مستخدم سايقا')]
    public $new_type = '';

    public function edit(){
        $this->validate();

        try {
            $type= RequestType::where(['type' => $this->old_type])->first();
            $type->type = $this->new_type ;
            if($type->isDirty()){
                $type->save();
                session()->flash('request_type_update_done' , ' تم التعديل بنجاح');
                $this->dispatch('request-type-update');
                $this->reset();
                $this->render();
            }
        } catch (\Throwable $th) {
            session()->flash('request_type_update_error' , 'ERROR in formUpdateRequestType.edit() :'  . $th);
        }
    }

    public function render()
    {
        return view('livewire.form-update-request-type');
    }
}
