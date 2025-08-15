<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Signature extends Component
{
    use WithFileUploads;
    public $spassword;
    public $suser;
    public $signature;



    public function mount()
    {
        $this->suser = Auth::user();
    }

    public function edit()
    {
        $this->validate([
            'spassword' => "required",
            'signature' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);
        if (Hash::check($this->spassword, $this->suser->password)) {


              $image = $this->signature; 

            $imageData = file_get_contents($image->getRealPath());
            $base64Image = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageData);

            $this->suser->signature = $base64Image;

            if ($this->suser->save()) {
                Toaster::success(__('messages.Item Saved'));
                $this->reset('signature', 'spassword'); 
            } else {
                Toaster::error(__('messages.Faild save item'));
            }
            $this->render();
        } else {
            $this->addError('spassword', trans('validation.current_password'));
            return;
        }
    }
    public function render()
    {
        return view('livewire.profile.signature');
    }
}
