<?php

namespace App\Livewire;

use App\Models\CollageInformations;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\Rule;

class FormUpdateCollageInformation extends Component
{

    public $info;
    public $id;


    public $new_name;


    public $new_value;



    public function edit()
    {
        $this->validate([
            'new_name' => [
                "required",
                Rule::unique('collage_informations', 'name')->ignore($this->info->id), // Exclude the current record
            ],
            'new_value' => [
                'required'
            ]
        ]);

        $this->info->name = $this->new_name;
        $this->info->value = $this->new_value;


        if ($this->info->isDirty()) {
            $this->info->save();
            Toaster::success(trans('messages.Item Saved'));
        } else {
            // nothing chanag
        }

        $this->mount();
        $this->render();
    }

    public function init()
    {
        $this->new_name = $this->info->name;
        $this->new_value = $this->info->value;
    }

    public function mount()
    {
        $info = CollageInformations::find($this->id);
        if (!$info) {
            abort(404);
        }
        $this->info = $info;
        $this->init();
    }
    public function render()
    {

        return view('livewire.form-update-collage-information');
    }
}
