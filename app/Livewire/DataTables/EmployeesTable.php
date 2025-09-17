<?php

namespace App\Livewire\DataTables;

use App\Classes\Services\Actions\RoleBackRequests;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Masmerise\Toaster\Toaster;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EmployeesTable extends DataTableComponent
{

    protected $model = Employee::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        // $this->setAddButton(Route('admin.employee.create'));
    }

    public function builder(): Builder
    {
        return $this->model::query()->withTrashed()
            ->with(['user', 'department'])
            ->select('employees.id', 'employees.deleted_at', 'fname', 'lname', 'mname', 'email', 'department.name');
    }

    public function columns(): array
    {
        return [

            Column::make('id', 'id')
                ->sortable(),
            Column::make(trans('string.username'), 'user_id')->format(function ($value, $row) {

                return  $row->user->fullname();
            })->sortable(),
            Column::make(trans('string.email'), 'user.email')
                ->sortable()->searchable(),
            Column::make(trans('string.Department'), 'department.name')
                ->sortable(),
            Column::make(trans('string.Options'))
                ->label(
                    fn($row) => view(
                        'livewire.user-actions',
                        [
                            'row' => $row,
                            'confirm_delete_message' => trans("messages.confirm delete request"),
                        ]
                    )
                )->html(),
        ];
    }

    public function edit($id = 0): void
    {
        redirect()->route('admin.employee.edit', ['id' => $id]);
    }

    public function delete($id = 0): void
    {
        if ($id > 0) {
            $emp = Employee::find($id);

            if ($emp) {
                if ($emp->delete()) {
                    RoleBackRequests::roleBackAfterEmployeeArchived($emp->user);
                    Toaster::success(trans('messages.Deleted Item'));
                } else {
                    Toaster::error(trans('messages.Faild delete item'));
                }
            }
        }
    }
    public function restore($id)
    {
        if ($id > 0) {
            $emp = $this->model::query()->withTrashed()->where('id', '=', $id)->first();
            if ($emp) {
                if ($emp->restore()) {
                    Toaster::success(trans("messages.Restor Item"));
                } else {
                    Toaster::error(trans('messages.Faild restor item'));
                }
            }
        }
    }
}
