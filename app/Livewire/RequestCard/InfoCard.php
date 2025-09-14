<?php

namespace App\Livewire\RequestCard;

use App\Classes\Export\BrowserShotExportRequest;
use App\Classes\Export\GrapesJsTemplateRenderer;
use App\Models\RequestList;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class InfoCard extends Component
{
    public $hasexport = false;
    public $request;

    public function mount() {}
    public function exportToPdf()
    {
        if ($this->request->isEnd()) {
            $request = RequestList::where('id', $this->request->id)->with(
                [
                    'user',
                    'requestLog.employee.user',
                    'requests',
                ]
            )->first();
            $browser_shot = new  BrowserShotExportRequest(new GrapesJsTemplateRenderer(), $request);
            return  $browser_shot->export();
        }else{
            Toaster::info("messages.Can't Export request if not ened");
        }
    }
    public function render()
    {
        return view('livewire.request-card.info-card');
    }
}
