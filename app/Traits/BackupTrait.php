<?php

namespace App\Traits;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Command\Command;

trait BackupTrait
{

    public static function backup()
    {
        try {

            // Put the application in maintenance mode with a custom view
            Artisan::call('down', [
                // '--render' => 'errors::503', // Custom maintenance view (e.g., resources/views/errors/503.blade.php)
                // '--retry' => 60, // Seconds after which users can retry
            ]);

            // Run the backup commands
            // Artisan::call('backup:clean');
            // Artisan::call('backup:run --disable-notifications');
            $command = "cd " . base_path() . " && php artisan backup:run --disable-notifications";

            $output = shell_exec($command);

            return true;
        } catch (\Throwable $th) {
            Log::error("ERROR BACKUP: " . $th->getMessage());
            return false;
        } finally {
            // Always bring the application back online
            Artisan::call('up');
        }
    }
}
