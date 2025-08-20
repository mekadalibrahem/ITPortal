<?php

namespace App\Livewire\Staticties;

use Livewire\Component;
use App\Classes\Chart\Attributes\DatasetAttribute\Dataset;
use App\Classes\Chart\Traits\WithChart;
use App\Enums\RequestStatusEnum;
use App\Models\RequestList as RequestList;

use Illuminate\Support\Facades\DB;


class RequestStatusCount extends Component
{
    use WithChart;

    public function mount()
    {
        $this->setChartLabels(['working', 'rejected', 'accepted']);
        $this->setChartName('requeststatuscount');
        $this->setChartType('pie');
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

        return [
            [
                RequestList::whereIn('status', $working_cases)->count(),
                RequestList::whereIn('status', $rejected_cases)->count(),
                RequestList::whereIn('status', $accepted_cases)->count()
            ]
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
        return view('livewire.staticties.request-status-count', ['chart' => $this->chart()]);
    }
}
