<?php

namespace App\Classes\Chart\Traits;

use App\Classes\Colors\AbstractColorGenerator;
use App\Classes\Colors\ColorGenerator;

trait  HasColors
{

    
    public $chart_color;
    public function setChartColors($colors)
    {
        $this->chart_color =  $colors;
    }
    public function getChartColors()
    {
        return   $this->chart_color ?? null;
    }
    public function getColorsInstance($count, $chunks, $force = false , AbstractColorGenerator $generator =  new ColorGenerator())
    {
        $colors = $this->getChartColors();

        if ($colors == null || $force == true) {
            $colors =  $generator->generateColorsChunks($count, $chunks);
            $this->setChartColors($colors);
        }

        return $colors;
    }
}
