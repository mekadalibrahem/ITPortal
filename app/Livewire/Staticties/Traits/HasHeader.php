<?php

namespace App\Livewire\Staticties\Traits;

trait HasHeader
{
    public $header;
    public function setHeader($header)
    {
        $this->header = $header;
    }
}
