<?php

namespace App\Traits;


trait HasConvertImageToBase64
{


    public function storage2base64($file, $file_name)
    {
       
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $base64 = 'data:image/' .  $extension . ';base64,' . base64_encode($file);
        return $base64;
    }
}
