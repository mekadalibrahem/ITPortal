<?php

namespace App\Classes\Chart\Traits;

use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Livewire\Attributes\Computed;

trait WithChart
{
    use HasColors;
    use HasLabels;
    // use HasDataset;
    use HasSize;
    use HasName;
    use HasType;
    public $datasets;
    public abstract function getDatasets(): array;
    public abstract function data(): array;
    #[Computed]
    public function chart()
    {
        return Chartjs::build()
            ->name($this->getChartName())
            ->type($this->getChartType())
            ->size($this->getChartSize())
            ->livewire()
            ->model("datasets");
    }
    public function getData()
    {
        $this->datasets = [
            'datasets' => $this->getDatasets(),
            'labels' => $this->getChartLabels()
        ];
    }
    public function update_chart()
    {
        $this->render();
    }
}
