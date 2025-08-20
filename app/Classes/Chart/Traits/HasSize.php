<?php

namespace App\Classes\Chart\Traits;


trait HasSize
{
    public $chart_width =  400;
    public $chart_height = 200;

    public  $chart_size = ["width" => 400, "height" => 200];

    public function getChartWidth()
    {
        return $this->chart_width;
    }
    public function getChartHeight()
    {
        return $this->chart_height;
    }

    public function setChartWidth($w)
    {
        $this->chart_width = $w;
    }
    public function setChartHeight($h)
    {
        $this->chart_height = $h;
    }

    public function getChartSize(): array
    {
        return $this->chart_size;
    }
    public function setChartSize(array $size)
    {
        $this->setChartWidth($size['width']);
        $this->setChartHeight($size['width']);
        $this->chart_size = $size;
    }
}
