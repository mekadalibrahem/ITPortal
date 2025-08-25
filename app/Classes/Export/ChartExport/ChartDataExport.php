<?php

namespace App\Classes\Export\ChartExport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChartDataExport implements FromArray, WithHeadings
{
    protected $labels;
    protected $data;
    protected $headings;

    public function __construct(array $labels, array $data , $headings)
    {
        $this->labels = $labels;
        $this->data = $data;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return array_map(null, $this->labels, ...$this->data);
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
