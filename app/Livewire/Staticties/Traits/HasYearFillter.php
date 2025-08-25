<?php

namespace App\Livewire\Staticties\Traits;

trait HasYearFillter
{
    public $from_year;
    public $to_year;
    public $has_year_fillter = true;

    public function enableYearFillter()
    {
        $this->has_year_fillter = true;
    }
    public function disableYearFillter()
    {
        $this->has_year_fillter = false;
    }
    public function hasYearFilter()
    {
        return $this->has_year_fillter;
    }
}
