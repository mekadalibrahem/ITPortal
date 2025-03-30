<?php

namespace App\Livewire\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PermissionDataTable extends CustomeDataTableComponent {

    public $model = Permission::class ;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.auth.permission.create'));
    }

    public function builder(): Builder {

        return $this->model::query();

    }

    public function columns(): array {
        return [
            Column::make('ID', 'id')
            ->sortable(),
        Column::make('Name', 'name')
            ->sortable(),
        ];
    }

    public function edit($id = 0): void {
        redirect()->route('admin.auth.permission.edit', ['id' => $id]);
    }

    public function delete($id = 0): void
    {
        if ($id > 0) {
            $permission = Permission::find($id);
            if ($permission) {
                if ($permission->delete()) {
                    Toaster::success(trans('messages.Deleted Item'));
                } else {
                    Toaster::error(trans('messages.Faild delete item'));
                }
            }
        }
    }
}


