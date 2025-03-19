<?php

namespace App\Livewire\DataTables;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Masmerise\Toaster\Toaster;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DepartmentTable extends CustomeDataTableComponent
{

    protected $model = Department::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.department.create'));
    }

    public function builder(): Builder
    {
        $query =  $this->model::query()
            ->with('employees');

        // dd($query);
        return $query;
    }

    public function columns(): array
    {
        return [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),
            Column::make(trans('string.Name'), 'name')
                ->sortable(),
            Column::make(trans('string.description'), 'description'),
            Column::make(trans('string.Manager'), 'manager.user.id')->format(function ($value, $row) {
                $user = User::find($value);
                return  $user ? $user->fullname()  : trans('string.Dont has Manager');
            })
        ];
    }

    public function edit($id = 0): void
    {
        redirect()->route('admin.department.edit', ['id' => $id]);
    }

    public function delete($id = 0): void
    {
        if ($id > 0) {
            $dep = Department::where("id", '=', $id)->first();
            if ($dep) {
                if ($dep->delete()) {
                    Toaster::success(trans('messages.Deleted Item'));
                } else {
                    Toaster::error(trans('messages.Faild delete item'));
                }
            }
        }
    }
}
