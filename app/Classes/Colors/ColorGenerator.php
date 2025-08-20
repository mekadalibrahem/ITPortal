<?php

namespace App\Classes\Colors;


class ColorGenerator extends AbstractColorGenerator
{

    public  function generate($hue): array
    {
        $hue = $hue;
        // Base color with 70% saturation and 50% lightness
        $baseColors = "hsl($hue, 70%, 50%)";
        // Hover color - same hue, slightly more saturation, darker
        $hoverColors = "hsl($hue, 80%, 40%)";
        return [
            'color' => $baseColors,
            'hover' => $hoverColors
        ];
    }
    public   function generateColors($count): array
    {
        $baseColors = [];
        $hoverColors = [];
        $hueStep = 360 / max($count, 1); // Avoid division by zero

        for ($i = 0; $i < $count; $i++) {
            $hue = $i * $hueStep;
            $color = $this->generate($hue);
            // Base color with 70% saturation and 50% lightness
            $baseColors[] = $color['color'];
            // Hover color - same hue, slightly more saturation, darker
            $hoverColors[] = $color['hover'];
        }

        return [
            'colors' => $baseColors,
            'hovers' => $hoverColors
        ];
    }
    public  function generateColorsChunks($count, $chunks = 1): array
    {
        // avoid zero values
        $count = max($count, 1);
        $chunks = max($chunks, 1);
        $chunks_size = $count;
        $total_count = $count * $chunks;
        $colors =  $this->generateColors($total_count);
        $base_color_chunks  = array_chunk($colors['colors'],$chunks_size);
        $hover_color_chunks = array_chunk($colors['hovers'],$chunks_size);
        return [
            'colors' => $base_color_chunks,
            'hovers' => $hover_color_chunks
        ];
    }
}
