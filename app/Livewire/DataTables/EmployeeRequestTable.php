<?php

namespace App\Livewire\DataTables;

use App\Enums\RequestStatusEnum;
use App\Models\Employee;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Traits\RequestStatusStyle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class EmployeeRequestTable extends DataTableComponent
{
    use RequestStatusStyle;

    protected $model = RequestList::class;
    public Employee $employee;
    public bool $is_manager = false;
    public $requestListIds ;

    public function mount(): void
    {
        $this->employee = Employee::where('user_id', Auth::id())->first();
        $this->is_manager = $this->employee->is_manager();
        $requestLogIds = $this->employee->get_request_log_ids();
        $this->requestListIds = RequestLog::whereIn('id', $requestLogIds)
            ->pluck('request_list_id');
    }





    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setPerPageAccepted([5, 10, 25])
            ->setPerPage(5);
        $this->setEmptyMessage(trans("messages.Don't Have any request yet"));
        $this->setSearchStatus(false);
    }
    public function filters(): array
    {
        return [
            MultiSelectFilter::make('Status')
                ->options(
                    collect(RequestStatusEnum::cases())
                        ->filter(function ($status) {
                            return !($status->value == "draft");
                        })
                        ->mapWithKeys(fn($status) => [
                            $status->value => $status->name
                        ])->toArray()
                )
                ->filter(function ($query, $values) {
                    return $query->whereIn('status', $values);
                }),
        ];
    }

    public function builder() : Builder
    {


        $q = $this->model::query()
            ->with('user')
            ->whereIn('request_lists.id', $this->requestListIds)
            ->when($this->getAppliedFilterWithValue('status'), function ($query, $status) {
                return $query->whereIn('status', $status);
            });
       return $q;
    }
    public function columns(): array
    {


        $columns = [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),
            Column::make(trans('string.request user'), 'user_id')->format(function ($value, $row) {
                return $row->user->fullname();
            })
                ->sortable(),
            Column::make(trans('string.Request type'), "requests.name")
                ->sortable(),
            Column::make(trans('string.Status'), "status")
                ->sortable()
                ->format(function ($value, $row) {
                    // Get the status from the row
                    $status = $row->status;

                    $class = $this->getStatusStyle($status);

                    // Return raw HTML with the status badge styled using Tailwind CSS
                    return "<div class='{$class} px-3 py-1 rounded-full text-sm font-medium text-center'>" .
                        ucfirst($status) .
                        "</div>";
                })->html(),
            DateColumn::make(trans('string.create_at'), "created_at")
                ->sortable(),
            DateColumn::make(trans('string.update_at'), "updated_at")
                ->sortable(),
            LinkColumn::make('Action')

                ->title(function ($row) {
                    return view('components.svg.arrow-up', [
                        'attributes' => new \Illuminate\View\ComponentAttributeBag([
                            'class' => 'w-6 h-6 text-blue-500', // Add custom attributes here
                        ]),
                    ])->render();
                })

                ->location(fn($row) => route('employee.edit.request', $row->id))
                ->html(),


        ];
        // Reverse columns if the language is RTL
        if (trans('string.lang direction') == "ltr") {

            $columns = array_reverse($columns);
        }
        return $columns;
    }
}
