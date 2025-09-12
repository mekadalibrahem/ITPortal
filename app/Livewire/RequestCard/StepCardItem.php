<?php

namespace App\Livewire\RequestCard;

use App\Models\RequestLog;
use Livewire\Component;

class StepCardItem extends Component
{
    public $status ;
    public $time ;
    public $note ;
    public $hasnote = true;
    public $title ;
    public $connector = true ;
    public $id ;
    public $requestlog;

    public function mount(){
        if($this->id){
            $this->requestlog = RequestLog::where('id' ,$this->id)->with('employee' , 'employee.user')->first();
        }
    }
    public function render()
    {
        return view('livewire.request-card.step-card-item');
    }
}
