<?php

namespace App\Livewire;

use App\Models\RequestType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

use function Laravel\Prompts\search;

class RequestTypesTable extends Component
{

    use WithPagination ;
    use WithoutUrlPagination ;


    public $search_string = '';
    public function search(){
        $types = null ;

        if($this->search_string == ''){
            $types = RequestType::orderBy('id' , 'desc')->paginate(5);
        }else{
            $types = RequestType::where('type' ,'LIKE' ,$this->search_string.'%')->paginate(5);
        }

        return $types ;
    }
    public function delete($id){
        if($id>0){
            $type = RequestType::find($id);
            if($type){
                $type->delete();
            }
            $this->render();
        }
    }

    #[On('request-type-update')]
    #[On('request-type-create')]
    public function render()
    {
        $types = $this->search();
        return view('livewire.request-types-table', [
            'types' => $types
        ]);
    }
}
