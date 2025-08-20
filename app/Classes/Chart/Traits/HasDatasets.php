<?php

namespace App\Classes\Chart\Traits;

trait HasDatasets
{
    public $chart_dataset;

    public function setChartDatasets($dataset)
    {
        $this->chart_dataset = $dataset;
    }
    public function getChartDatasets(): array
    {
        return $this->chart_dataset ?? [];
    }
    
}
