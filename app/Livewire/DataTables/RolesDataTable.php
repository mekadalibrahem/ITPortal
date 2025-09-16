<?php

namespace App\Livewire\DataTables;

use App\Livewire\DataTables\CustomeDataTableComponent;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Masmerise\Toaster\Toaster;
use Rappasoft\LaravelLivewireTables\Views\Column;

class RolesDataTable extends CustomeDataTableComponent
{
    public $model = Role::class;


    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.auth.role.create'));
    }

    public function builder(): Builder
    {
        return $this->model::query();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Name', 'name')
                ->sortable(),

        ];
    }

    public function edit($id = 0): void
    {
        redirect()->route('admin.auth.role.edit', ['id' => $id]);
    }

    public function delete($id = 0): void
    {
        if ($id > 0) {
            $role = Role::find($id);
            if ($role) {

                if ($role->id > 5) {
                    try {
                        if ($role->delete()) {
                            Toaster::success(trans('messages.Deleted Item'));
                        } else {
                            Toaster::error(trans('messages.Faild delete item'));
                        }
                    } catch (Exception $e) {
                        if ($e->getCode() === '23000' || $e->getPrevious()?->getCode() === '19') {
                            Toaster::error(trans('messages.CANNOT_DELETE_ITEM_IN_USE'));
                        } else {
                            logger()->error(__CLASS__ . '@' .  __FUNCTION__ . " : " . $e->getMessage());
                        }
                    }
                } else {
                    Toaster::warning(trans("messages.THIS ITEM IS STATIC CAN NOT EDIT OR DELETED"));
                }
            }
        }
    }
}
