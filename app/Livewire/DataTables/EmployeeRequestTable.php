<?php

namespace App\Livewire\DataTables;

use App\Classes\RequestManagment\RequestManagmentTemplate;
use App\Enums\RequestStatusEnum;
use App\Models\Employee;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\RequestTemplates\RequestTemplateStep;
use App\Traits\RequestStatusStyle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class EmployeeRequestTable extends DataTableComponent
{
    use RequestStatusStyle;

    protected $model = RequestList::class;
    public Employee $employee;
    public $requestListIds;


    public function mount(): void
    {
        $this->employee = Employee::where('user_id', Auth::id())->first();

        $this->requestListIds = $this->employee->get_requests_ids();
    }





    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setPerPageAccepted([5, 10, 25]);
        $this->setEmptyMessage(trans("messages.Don't Have any request yet"));
        $this->setSearchStatus(false);
        $this->setSearchEnabled();
        $this->setThAttributes(function (Column $column) {
            return [
                'default' => true,
                'default-styling' => true,
                'class' => 'text-center ',
            ];
        });
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

    public function builder(): Builder
    {


        $q = $this->model::query()
            ->with(['user', 'requestLog', 'requestLog.employee', 'currentStep'])
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
                ->sortable()->searchable(),
            Column::make(trans('string.request user'), 'user_id')->format(function ($value, $row) {
                return $row->user->fullname();
            })->sortable(),
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
            Column::make(trans('string.step.current'), "current_step_id")
                ->sortable()
                ->format(function ($value, $row) {
                    $step = $row->currentStep;
                    $text = "----";
                    if ($step) {
                        $text =  $step->name;
                        $text = $row->isEnd() ? "-----" : $text;
                    }
                    return "<div class=' px-3 py-1 rounded-full text-sm font-medium text-center'>" .
                        $text
                        . "</div>";
                })->html(),

            Column::make(trans('string.assign to'), "id")
                ->sortable()
                ->format(function ($value, $row) {

                    $assign_to = $this->employee->assign_to($row);

                    if ($assign_to || $row->isEnd()) {

                        $text = $assign_to ?  $assign_to->fullname() : null;


                        $text = $row->isEnd() ? "-----" : $text;
                        return "<div class=' px-3 py-1 rounded-full text-sm font-medium text-center'>" .
                            $text
                            . "</div>";
                    } else if ($this->employee->can_work($row, true)) {
                        return " <button type='button'
                            class='py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none  '
                            wire:click='start(" . $value . ")'>
                        start
                        </button>";
                    } else {
                        return "<div class=' px-3 py-1 rounded-full text-sm font-medium text-center'> ------- </div>";
                    }
                    // Return raw HTML with the status badge styled using Tailwind CSS

                })->html(),
            Column::make(trans('string.create_at'), "created_at")
                ->sortable(),
            Column::make(trans('string.update_at'), "updated_at")
                ->sortable()->hideIf(true),
            Column::make(trans('string.end_at'), "end_at")
                ->sortable(),
            LinkColumn::make('Action')

                ->title(function ($row) {
                    return view('components.svg.arrow-up', [
                        'attributes' => new \Illuminate\View\ComponentAttributeBag([
                            'class' => 'w-6 h-6 text-blue-500',
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


    public function start($id)
    {
        if ($id < 0) {
            abort(404);
        } else {
            $request_list = RequestList::where('id', $id)->first();
            if (!$request_list) {
                abort(404);
            }
            $requestManagment = new RequestManagmentTemplate();
            $requestManagment->setEmployee($this->employee);
            $requestManagment->setRequestList($request_list);
            $requestManagment->start();
            return redirect()->route('employee.edit.request', $id);
        }
    }
}
