<?php

namespace App\Classes\Colors;


abstract class AbstractColorGenerator
{

    abstract public  function generate($hue) :array ;
    abstract public  function generateColors($count): array;
    abstract public  function generateColorsChunks($count, $chunks =1 ): array;
}
