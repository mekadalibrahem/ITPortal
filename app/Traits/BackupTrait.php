<?php

namespace App\Traits;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait BackupTrait
{

    public static function backup()
    {


        try {



            // Put the application in maintenance mode
            Artisan::call('down');

            // Run the backup commands
            Artisan::call('backup:clean');
            Artisan::call('backup:run --disable-notifications');

            // Bring the application back online
            Artisan::call('up');

            // $path_db =
            return true;
        } catch (\Throwable $th) {
            Log::error("ERROR BACKUP :" . $th->getMessage());
            return false;
        }
    }
}
