<?php

namespace App\Classes\Chart\Traits;

trait HasLabels
{
    public $chart_labels;

    public function setChartLabels($labels)
    {
        $this->chart_labels = $labels;
    }
    public function getChartLabels(): array
    {
        return $this->chart_labels ?? [];
    }
}
