<?php

namespace App\Livewire\Admin\Tools;

use App\Http\Controllers\ZipController;
use App\Traits\BackupTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Backup extends Component
{
    public const PATH_BACKUP = 'backups/Laravel';
    use BackupTrait;
    public $user;
    public $files;
    public function mount()
    {
        $this->user = Auth::user();
        $this->index();
    }

    public function index()
    {

        // dd(Storage::allFiles("Laravel"));
        $this->files = array_reverse(
            array_map(
                "basename",
                Storage::allFiles(SELF::PATH_BACKUP)
            )
        );
    }
    public function download($filename)
    {
        // dd($filename);
        try {
            return Storage::download(SELF::PATH_BACKUP . "/" . $filename);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
        }
    }

    // Delete a backup file
    public function delete($filename)
    {
        // dd($filename);
        try {

            Storage::delete(SELF::PATH_BACKUP . "/" . $filename);

            $this->index();
            $this->render();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function store()

    {
        // dd("store");
        $is_done =  $this->backup();
        if ($is_done) {
            session()->flash("status", [
                "type" => "success",
                "message" => "Backup done"
            ]);
        } else {
            session()->flash("status", [
                "type" => "danger",
                "message" => "Backup Faild"
            ]);
        }
        $this->index();
        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.tools.backup');
    }
}
