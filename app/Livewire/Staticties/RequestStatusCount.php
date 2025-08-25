<?php

namespace App\Livewire\Staticties;

use Livewire\Component;
use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Enums\RequestStatusEnum;
use App\Livewire\Staticties\Traits\HasOptions;
use App\Models\RequestList as RequestList;


class RequestStatusCount extends Component
{
    use WithChart;
    use HasOptions;
    public function mount()
    {
        $this->setChartLabels([
            'rejected',
            'accepted',
            'working',
        ]);
        $this->setChartName('request_status_count');
        $this->setChartType('pie');
        $this->setHeader(trans('string.request_status_count'));
        $this->setExportHeadings(['requests', 'total']);
    }

    public function data(): array
    {
        $working_cases = [
            RequestStatusEnum::CHECKING->value,
            RequestStatusEnum::WATING->value,
            RequestStatusEnum::WORKING->value
        ];
        $rejected_cases = [
            RequestStatusEnum::END_REJECTED->value,
            RequestStatusEnum::REJECTED->value,
            RequestStatusEnum::TIMEOUT->value
        ];
        $accepted_cases = [
            RequestStatusEnum::END_ACCEPT->value,
            RequestStatusEnum::END_UNDER_DELIVERY->value,
            RequestStatusEnum::END_DELEVERED->value
        ];
        $rejected_count = RequestList::whereIn('status', $rejected_cases);
        $accepted_count = RequestList::whereIn('status', $accepted_cases);
        $working_count  = RequestList::whereIn('status', $working_cases);
        if ($this->hasYearFilter()) {
            if (!empty($this->from_year)) {
                $rejected_count->whereYear('created_at', '>=', $this->from_year);
                $accepted_count->whereYear('created_at', '>=', $this->from_year);
                $working_count->whereYear('created_at', '>=', $this->from_year);
            }
            if (!empty($this->to_year)) {
                $rejected_count->whereYear('created_at', '<=', $this->to_year);
                $accepted_count->whereYear('created_at', '<=', $this->to_year);
                $accepted_count->whereYear('created_at', '<=', $this->to_year);
            }
        }
        return [
            [
                $rejected_count->count(),
                $accepted_count->count(),
                $working_count->count(),
            ]
        ];
    }
    public function getDatasets(): array
    {
        $data =  $this->data();

        $colors = $this->getColorsInstance(count($this->getChartLabels()), count($data));
        return  [
            Dataset::make("Request Registrations status", $colors['colors'][0], $colors['hovers'][0], $data[0])

        ];
    }
    public function render()
    {
        $this->getData();
        return view('livewire.staticties.request-status-count');
    }
}
