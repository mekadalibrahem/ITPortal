<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use  ZipArchive;

class ZipController extends Controller
{
    public const BACKUPFOLDER = "/backups";
    public static function create_back_up($db, $folders)
    {

        $date_time = date("Y_m_d_G_i_s_u");
        $zipFileName = config("APP_NAME", "BACKUP") .$date_time . ".zip";
        $zip = new ZipArchive();

        if ($zip->open(storage_path(self::BACKUPFOLDER . "/$zipFileName"), ZipArchive::CREATE) === TRUE) {
            $filesToZip = [
                $db,
                $folders,
            ];

            foreach ($filesToZip as $f) {
                $zip->addFile($f, basename($f));
            }
            
            $zip->close();
            return true;
            // return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        } else {
            return "Failed to create the zip file.";
        }
    }

    public static function getallfiles($f)
    {
        $files = [];
        if (File::isDirectory($f)) {
            $subs = File::allFiles($f);
            foreach ($subs as $itme) {
                $files[] = ZipController::getallfiles($itme);
            }
        } elseif (File::isFile($f)) {
            $files = $f;
        }
        return $files;
    }
}
