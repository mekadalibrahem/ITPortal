<?php

namespace App\Livewire\Form;

use Livewire\Component;

class InputImage extends Component
{
    public $model ;
    
    public function render()
    {
        return view('livewire.form.input-image');
    }
}
