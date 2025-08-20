<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Classes\Colors\ColorGenerator;
use App\Models\RequestList as ModelsRequestList;
use App\Models\Requests;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RequestListCount extends Component
{
    use WithChart;

    public function mount()
    {
        $this->setChartLabels(Requests::distinct()->orderBy('id')->pluck('name')->toArray());
        $this->setChartName('test');
        $this->setChartType('bar');
    }

    public function data(): array
    {
        return [
            ModelsRequestList::select('request_id', DB::raw('count(*) as total'))
                ->groupBy('request_id')
                ->pluck('total')->toArray()
        ];
    }
    public function datasets(): array
    {
        $data =  $this->data();
        $colors = $this->getColorsInstance(count($this->getChartLabels()), count($data));
        return  [
            Dataset::make("Request Registrations", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }

    public function render()
    {
        return view('livewire.staticties.request-list-count', ['chart' => $this->chart()]);
    }
}
