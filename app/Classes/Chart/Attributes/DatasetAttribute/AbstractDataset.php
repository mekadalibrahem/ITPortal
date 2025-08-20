<?php

namespace App\Classes\Chart\Attributes\DatasetAttribute;

abstract class AbstractDataset
{
    public $label;
    public $bg_color;
    public $hover_bg_color;

    public abstract static function make($label ,$bgcolor , $hoverbgcolor , $data) : array;
}
