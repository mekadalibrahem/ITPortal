<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Livewire\Staticties\Traits\HasHeader;
use App\Models\RequestList;
use App\Models\Requests;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class RequestListCount extends Component
{
    use WithChart;
    use HasHeader;
   



    public function mount()
    {
        $this->setChartLabels(Requests::distinct()->orderBy('id')->pluck('name')->toArray());
        $this->setChartName('test');
        $this->setChartType('bar');
        $this->setHeader(trans('string.request_list_count'));
    }

    public function data(): array
    {
        $query =  RequestList::select('request_id', DB::raw('count(*) as total'));
        $query->groupBy('request_id');

        return [
            $query->pluck('total')->toArray()
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

        return view('livewire.staticties.request-list-count');
    }
}
