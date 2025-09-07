<?php

namespace App\Livewire\Profile;

use App\Traits\HasConvertImageToBase64;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Signature extends Component
{
    use WithFileUploads;
    use HasConvertImageToBase64;
    public $spassword;
    public $suser;
    public $signature;
    public $current_signature;
    public $current_signature_name;



    public function mount()
    {
        $this->suser = Auth::user();
        $this->current_signature_name = $this->suser->signature;
        if ($this->current_signature_name) {
            $this->current_signature  = $this->storage2base64(Storage::disk("signature")->get($this->current_signature_name), $this->current_signature_name);
        }
    }

    public function edit()
    {
        $this->validate([
            'spassword' => "required",
            'signature' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);
        if (Hash::check($this->spassword, $this->suser->password)) {



            $extension = $this->signature->getClientOriginalExtension();
            $file_name = $this->suser->id . "_" . time() . "." . $extension;
            $this->signature->storeAs("", $file_name, 'signature');
            $this->suser->signature = $file_name;


            if ($this->suser->save()) {
                if (Storage::disk('signature')->exists($this->current_signature_name)) {

                    Storage::disk('signature')->delete($this->current_signature_name);
                }
                $this->current_signature_name = $this->suser->signature;
                $this->current_signature  = $this->storage2base64(Storage::disk("signature")->get($this->current_signature_name), $this->current_signature_name);
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
