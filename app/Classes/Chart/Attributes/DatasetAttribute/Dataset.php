<?php

namespace App\Classes\Chart\Attributes\DatasetAttribute;

class Dataset extends AbstractDataset
{

    public static function make($label, $bgcolor, $hoverbgcolor, $data): array
    {
        return  [

            "label" => $label,
            'backgroundColor' => $bgcolor,
            'hoverBackgroundColor' => $hoverbgcolor,
            "data" => $data

        ];
    }
}
