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
use Masmerise\Toaster\Toaster;

class Backup extends Component
{
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


        $this->files = array_reverse(
            array_map(
                "basename",
                Storage::disk('backups')->allFiles()

            )
        );
    }
    public function download($filename)
    {
        $filePath = Storage::disk('backups')->path(config('app.name') . '/' . $filename);
        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);

        try {

            return response()->download($filePath, $filename, [
                'Content-Type' => 'application/zip',
            ]);
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

            Storage::disk('backups')->delete(config('app.name') . '/' . $filename);

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
            Toaster::success("Backup done");
        } else {
            Toaster::error("Backup Faild");
        }
        $this->index();
        $this->render();
    }
    public function render()
    {
        return view('livewire.admin.tools.backup');
    }
}
