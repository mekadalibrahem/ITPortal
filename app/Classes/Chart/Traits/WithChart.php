<?php

namespace App\Classes\Chart\Traits;

use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

trait WithChart
{
    use HasColors;
    use HasLabels;
    // use HasDataset;
    use HasSize;
    use HasName;
    use HasType;

    public abstract function datasets(): array;
    public abstract function data(): array;
    public function chart()
    {   
        $chart = Chartjs::build()
            ->name($this->getChartName())
            ->type($this->getChartType())
            ->size($this->getChartSize())
            ->labels($this->getChartLabels())
            ->datasets($this->datasets());
        return $chart;
    }
}
