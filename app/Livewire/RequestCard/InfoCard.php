<?php

namespace App\Livewire\RequestCard;

use App\Classes\Export\BrowserShotExportRequest;
use App\Classes\Export\GrapesJsTemplateRenderer;
use App\Models\RequestList;
use Livewire\Component;

class InfoCard extends Component
{
    public $hasexport = false;
    public $request ;

    public function mount(){

    }
    public function exportToPdf()
    {   $request = RequestList::where('id', $this->request->id)->with(
        [
            'user',
            'requestLog.employee.user',
            'requests',
        ]
        )->first();
        $browser_shot = new  BrowserShotExportRequest(new GrapesJsTemplateRenderer(), $request);
        return  $browser_shot->export();

    }
    public function render()
    {
        return view('livewire.request-card.info-card');
    }
}
