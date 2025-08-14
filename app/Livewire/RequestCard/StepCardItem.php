<?php

namespace App\Livewire\RequestCard;

use Livewire\Component;

class StepCardItem extends Component
{
    public $status ;
    public $time ;
    public $note ;
    public $title ;
    public $connector = true ;
    public function render()
    {
        return view('livewire.request-card.step-card-item');
    }
}
