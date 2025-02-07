<?php

namespace App\Livewire;

use App\Models\CollageInformations;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class FormCreateCollageInformation extends Component
{
    #[Rule('required')]
    #[Rule('unique:collage_informations,name')]
    public $name = '';
    #[Rule('required')]
    public $value = '';




    public function create(){
        $this->validate();

        $collage = CollageInformations::create(
            [
                'name'=> $this->name ,
                'value' =>$this->value
            ]
        );
        if($collage){

            Toaster::success(trans('messages.Item Saved'));
        }

        $this->reset();
        $this->render();
    }

    public function render()
    {
        return view('livewire.form-create-collage-information');
    }
}
