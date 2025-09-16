<?php

namespace App\Livewire\Staticties;

use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Models\RequestList;
use App\Models\Requests;
use Illuminate\Support\Facades\DB;
use App\Classes\Chart\Traits\WithChart;
use App\Livewire\Staticties\Traits\HasOptions;

use Livewire\Component;


class RequestListCount extends Component
{
    use WithChart;
    use HasOptions;


    public function mount()
    {
        $this->setChartLabels(Requests::distinct()->orderBy('id')->pluck('name')->toArray());
        $this->setChartName('request_registration_count');
        $this->setChartType('horizontalBar');
        $this->setHeader(trans('string.request_list_count'));
        $this->setExportHeadings(['request', 'total']);
    }

    public function data(): array
    {
        $query = DB::table('requests')
            ->leftJoin('request_lists', function ($join) {
                $join->on('requests.id', '=', 'request_lists.request_id');

                // Apply date filters to the join
                if ($this->hasYearFilter()) {
                    if (!empty($this->from_year)) {
                        $join->whereYear('request_lists.created_at', '>=', $this->from_year);
                    }
                    if (!empty($this->to_year)) {
                        $join->whereYear('request_lists.created_at', '<=', $this->to_year);
                    }
                }
            })
            ->select('requests.id', DB::raw('COUNT(request_lists.id) as total'))
            ->groupBy('requests.id')
            ->orderBy('requests.id');

        $results = $query->get();
        $counts = $results->pluck('total')->toArray();

        logger()->info("Final array with zeros (join method): ", $counts);

       
        return [

            $counts
        ];
    }
    public function getDatasets(): array
    {
        $data =  $this->data();
        $colors = $this->getColorsInstance(count($this->getChartLabels()), count($data));
        return  [
            Dataset::make("Request Registrations", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }

    public function render()
    {
        $this->getData();
        return view('livewire.staticties.request-list-count');
    }
}
