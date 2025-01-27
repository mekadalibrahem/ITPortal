<?php

namespace App\Livewire\Profile;

use Jenssegers\Agent\Agent;
use Livewire\Component;

class DeviceItem extends Component
{

    public $is_desktop ;
    public $platform ;
    public $browser ;

    public $last_active ;
    public $ip_address ;
    public $is_current_device ;


    public function render()
    {
        return view('livewire.profile.device-item');
    }
}
