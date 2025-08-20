<?php

namespace App\Classes\Chart\Traits;

trait HasName
{
    public $chart_name;
    public function setChartName($name)
    {
        $this->chart_name = $name;
    }
    public function getChartName()
    {
        return $this->chart_name  ?? 'char title';
    }
}
