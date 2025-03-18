<?php

namespace App\Livewire;

use App\Models\RequestType;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class FormCreateRequestType extends Component
{
    #[Rule('required')]
    #[Rule('unique:request_types,type')]
    public $type ='';


    public function create(){
        $this->validate();

        try {
            RequestType::create([
                'type' => $this->type
            ]);
            Toaster::success(trans('messages.Item Saved'));
            $this->reset();
            $this->render();
        } catch (\Throwable $th) {
            Toaster::error('ERROR in `form-create-request-type` :'. $th  );
        }

    }

    public function render()
    {
        return view('livewire.form-create-request-type');
    }
}
