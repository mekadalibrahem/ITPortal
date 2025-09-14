<?php

namespace App\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Command\Command;
use Illuminate\Http\Request;

trait BackupTrait
{
    public static function backup()
    {
        try {
            
            Artisan::call('down', [
                '--retry' => 60, 
                '--secret' => 'backup-secret'
            ]);
            sleep(10);
            // Run the backup commands
            $command = "cd " . base_path() . " && php artisan backup:run --disable-notifications";
            $output = shell_exec($command);

          
            Log::info("Backup completed successfully", ['output' => $output]);

            return true;
        } catch (\Throwable $th) {
            Log::error("ERROR BACKUP: " . $th->getMessage(), [
                'exception' => $th,
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ]);
            return false;
        } finally {
          
            Artisan::call('up');
        }
    }

    /**
     * Alternative method that provides more control over maintenance mode
     */
    public static function backupWithRouteBlocking()
    {
        $maintenanceFile = storage_path('framework/down');

        try {
            // Create maintenance mode file manually with custom content
            $payload = json_encode([
                'time' => now()->timestamp,
                'message' => 'System is currently performing backup operations. Please try again in a few minutes.',
                'retry' => 60,
                'secret' => 'backup-secret'
            ]);

            file_put_contents($maintenanceFile, $payload);

            // Run the backup commands
            $command = "cd " . base_path() . " && php artisan backup:run --disable-notifications";
            $output = shell_exec($command);

            Log::info("Backup completed successfully", ['output' => $output]);

            return true;
        } catch (\Throwable $th) {
            Log::error("ERROR BACKUP: " . $th->getMessage(), [
                'exception' => $th,
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ]);
            return false;
        } finally {
            // Always remove maintenance mode file
            if (file_exists($maintenanceFile)) {
                unlink($maintenanceFile);
            }
        }
    }
}
