<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\File;

trait HasCopyFiles
{
    public function copy_files($sourcePath, $destinationPath)
    {
        
        // Check if source directory exists
        if (!File::exists($sourcePath)) {
            $this->command->error("Source directory does not exist: {$sourcePath}");
            return;
        }

        // Create destination directory if it doesn't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
            $this->command->info("Created destination directory: {$destinationPath}");
        }

        // Clear the destination directory first
        $this->clearDirectory($destinationPath);

        // Copy all files from source to destination
        $files = File::allFiles($sourcePath);
        $copiedCount = 0;

        foreach ($files as $file) {
            $destinationFile = $destinationPath . '/' . $file->getRelativePathname();

            // Ensure the subdirectory exists in destination
            $destinationDir = dirname($destinationFile);
            if (!File::exists($destinationDir)) {
                File::makeDirectory($destinationDir, 0755, true);
            }

            File::copy($file->getRealPath(), $destinationFile);
            $copiedCount++;
        }

        $this->command->info("Successfully copied {$copiedCount} stamp files to private storage.");
    }
    /**
     * Clear all files and subdirectories from a directory
     */
    protected function clearDirectory(string $path): void
    {
        if (!File::exists($path)) {
            return;
        }

        $items = scandir($path);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $path . '/' . $item;

            if (is_dir($fullPath)) {
                File::deleteDirectory($fullPath);
            } else {
                File::delete($fullPath);
            }
        }

        $this->command->info("Cleared destination directory: {$path}");
    }
}
