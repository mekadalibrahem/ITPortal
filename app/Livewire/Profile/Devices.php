<?php

namespace App\Livewire\Profile;

use App\Http\Controllers\ProfileController;
use App\Livewire\ConfirmPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;


class Devices extends Component
{



    public $user;

    public $password ;

    public $logout_status = [];




    public function mount()
    {
        $this->user = Auth::user();






    }

    public function logout_others(){
            $this->validate([
                'password' => 'required|min:8'
            ]);
            if(Hash::check($this->password,$this->user->password)){

                $ids = DB::table('sessions')
                    ->where('user_id', '=', Auth::user()->id)
                    ->where('id', '!=', session()->getId())
                    ->pluck('id');


                if ($ids->isNotEmpty()) {
                    DB::table('sessions')->whereIn('id', $ids)->delete();
                }
                $this->logout_status = ['type' => 'success' , 'message' => 'logout done '];
                $this->render();
            }else{
                $this->logout_status = ['type' => 'danger' , 'message' => 'wrong password'];
            }


    }


    /**
     * Get the current sessions.
     *
     * @return \Illuminate\Support\Collection
    */
    protected function sessions(){
        if (config('session.driver') !== 'database') {
            return []; // Return an empty array if session driver is not 'database'
        }

        $sessions = DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                          ->where('user_id', $this->user->id)
                          ->orderBy('last_activity', 'desc')
                          ->get();

        $result = [];
        foreach ($sessions as $session) {
            $agent = $this->createAgent($session);
            $result[] = [
                'agent' => $agent,
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id ===session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        }

        return $result;
    }

     /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn ($agent) => $agent->setUserAgent($session->user_agent));
    }
    public function render()
    {

        return view('livewire.profile.devices', [
            'sessions' => $this->sessions()
        ]);
    }
}
