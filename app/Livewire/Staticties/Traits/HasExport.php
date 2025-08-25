<?php

namespace App\Livewire\Staticties\Traits;

use App\Classes\Export\ChartExport\ChartDataExport;
use Maatwebsite\Excel\Facades\Excel;

trait HasExport
{

    public $has_export = true;
    public $export_headings;
    public function export()
    {
        return Excel::download(
            new ChartDataExport(
                $this->getChartLabels(),
                $this->data(),
                $this->getExportHeadings()
            ),
            $this->getChartName() . '_' . time() . '.xlsx'

        );
    }
    public function enableExport()
    {
        $this->has_export = true;
    }
    public function disableExport()
    {
        $this->has_export = false;
    }
    public function setExportHeadings(array $headings)
    {
        $this->export_headings  = $headings;
    }
    public function getExportHeadings()
    {
        return $this->export_headings;
    }
    public function hasExport()
    {
        return $this->has_export;
    }
}
