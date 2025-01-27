<?php

namespace App\Livewire;

use App\Models\CollageInformations;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CollageInformationTable extends Component
{
    use WithPagination;
    use WithoutUrlPagination;



    public function delete($id){
        if($id>0){
            $info = CollageInformations::find($id);
            $info->delete();

            $this->render();
        }
    }

    #[On('created')]
    #[On('updated')]
    public function render()
    {
        $infos = CollageInformations::orderBy('id' , 'desc')->paginate(5);
        // dd($infos);
        return view('livewire.collage-information-table' , [
            'infos' => $infos
        ] );
    }
}
