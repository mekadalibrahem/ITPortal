<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

class Info extends Component
{

    public  $user;


    public  $fname;
    public  $lname;
    public  $mname;
    public  $username;
    public  $email;
    public $nid;
    protected $id;

    public function mount()
    {
        $this->user = Auth::user();
        $this->fname = $this->user->fname;
        $this->mname = $this->user->mname;
        $this->lname = $this->user->lname;
        $this->nid = $this->user->national_id;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
    }

    public  function  edit()
    {

        $this->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'nid' => ['required', 'string', 'max:255', 'unique:users,national_id,' . $this->user->id],
            "username" =>  ['required', 'string', 'max:255', 'unique:users,username,' . $this->user->id],

            'email' => ['required', 'max:255', 'email', 'unique:users,email,' . $this->user->id]
        ]);
        $this->user->fname = $this->fname;
        $this->user->lname = $this->lname;
        $this->user->mname = $this->mname;
        $this->user->national_id = $this->nid;
        $this->user->username = $this->username;
        $this->user->email = $this->email;

        if ($this->user->isDirty()) {
            if ($this->user->isDirty('email')) {
                $this->user->email_verified_at = null;
                event(new VerifyEmail());
            }
            $this->user->save();
            Toaster::success(trans('messages.Item Saved'));
        }
        $this->render();
    }

    public function render()
    {


        return view('livewire.profile.info');
    }
}
