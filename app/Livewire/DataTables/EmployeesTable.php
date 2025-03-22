<?php

namespace App\Livewire\DataTables;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Masmerise\Toaster\Toaster;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EmployeesTable extends CustomeDataTableComponent
{

    protected $model = Employee::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.employee.create'));
    }

    public function builder(): Builder
    {
        return $this->model::query()
            ->with('user');


        
    }

    public function columns(): array
    {
        return [

            Column::make('id', 'id')
                ->sortable(),
            Column::make(trans('string.username'), 'user_id')->format(function ($value, $row) {
                return $row->user->fullname();
            })->sortable(),
            Column::make(trans('string.email'), 'user_id')->format(function ($value, $row) {
                return $row->user->email;
            })->sortable()
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
                    Toaster::success(trans('messages.Deleted Item'));
                } else {
                    Toaster::error(trans('messages.Faild delete item'));
                }
            }
        }
    }
}
