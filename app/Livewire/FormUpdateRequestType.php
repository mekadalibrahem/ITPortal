<?php

namespace App\Livewire;

use App\Models\RequestType;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class FormUpdateRequestType extends Component
{


    #[Rule('required' )]
    #[Rule('unique:request_types,type')]
    public $type ;
    public $request_type ;
    public $id ;
    public function mount(){

        if($this->id < 0){

            // Invalid parameter
            abort(400);
        }else{
            $this->request_type = RequestType::find($this->id);

            if(!$this->request_type){
                // type not found
                abort(404);
            }else{
                $this->type = $this->request_type->type ;
            }
        }
    }
    public function edit(){
        $this->validate();

        try {

            $this->request_type->type = $this->type ;

            if($this->request_type->isDirty()){
                $this->request_type->save();
                Toaster::success(trans("messages.Item Saved"));
                $this->render();
            }
        } catch (\Throwable $th) {
         Toaster::error('ERROR in formUpdateRequestType.edit() :'  . $th);
        }
    }

    public function render()
    {
        return view('livewire.form-update-request-type');
    }
}
