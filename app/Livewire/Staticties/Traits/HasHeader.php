<?php

namespace App\Livewire\Staticties\Traits;

trait HasHeader
{
    public $has_header = true;
    public $header;
    public function setHeader($header)
    {
        $this->header = $header;
    }
    public function enableHeader()
    {
        $this->has_header = true;
    }
    public function disableHeader()
    {
        $this->has_header = false;
    }
}
