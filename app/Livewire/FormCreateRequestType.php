<?php

namespace App\Livewire;

use App\Models\RequestType;
use Livewire\Attributes\Rule;
use Livewire\Component;

class FormCreateRequestType extends Component
{
    #[Rule('required' , message:'هذا الحقل مطلوب')]
    #[Rule('unique:request_types,type' , message:'هذا النوع مسجل مسبقا')]
    public $type ='';


    public function create(){
        $this->validate();

        try {
            RequestType::create([
                'type' => $this->type
            ]);
            session()->flash('reqest_type_create_done' , 'تم إضافة النوع الجديد');
            $this->dispatch('request-type-create');
            $this->reset();
            $this->render();
        } catch (\Throwable $th) {
            session()->flash('request_type_create_error' , 'ERROR in `form-create-request-type` :'. $th  );
        }

    }

    public function render()
    {
        return view('livewire.form-create-request-type');
    }
}
