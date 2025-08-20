<?php

namespace App\Classes\Chart\Traits;

trait HasType
{
    public $chart_type;
    public function setChartType($type)
    {
        $this->chart_type = $type;
    }
    public function getChartType()
    {
        return $this->chart_type  ?? 'bar';
    }
}
