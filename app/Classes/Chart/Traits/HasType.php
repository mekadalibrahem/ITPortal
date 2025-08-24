<?php

namespace App\Classes\Chart\Traits;

use Exception;

trait HasType
{   
    public const CHART_TYPES = [
         "bar",
         "horizontalBar",
         "bubble",
         "scatter",
         "doughnut",
         "line",
         "pie",
         "polarArea",
         "radar",
    
    ];
    public $chart_type;
    public function setChartType($type)
    {
        if(in_array($type , self::CHART_TYPES)){
            $this->chart_type = $type;
        }else{
            throw new Exception("INVALID CHART TYPE  avalibale types is {" . implode(' , ' , self::CHART_TYPES) . "}");
        }
    }
    public function getChartType()
    {
        return $this->chart_type  ?? 'bar';
    }
}
