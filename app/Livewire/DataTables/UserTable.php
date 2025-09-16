<?php

namespace App\Livewire\DataTables;

use App\Classes\Services\Actions\UserAction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Spatie\Permission\Models\Role;

class UserTable extends DataTableComponent
{
    protected $model = User::class;
    public $roles;
    public function mount()
    {
        $this->roles = Role::all()->pluck('name')->toArray();
    }
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(route('admin.auth.user.create'));
        $this->setDefaultSort('id', 'desc');
        $this->setSearchEnabled();
    }

    public function builder(): Builder
    {
        return $this->model::query()->withTrashed()->with('roles')
            ->select(['fname', 'lname', 'mname', 'email', 'id', 'deleted_at'])
            ->when($this->getAppliedFilterWithValue('roles'), function ($query, $selectedRoleIds) {
                $query->whereHas('roles', function ($q) use ($selectedRoleIds) {
                    $q->whereIn('roles.id', $selectedRoleIds);
                });
            });
    }
    public function filters(): array
    {
        return [
            MultiSelectFilter::make('roles')
                ->options(
                    Role::query()
                        ->orderBy('name')
                        ->get()
                        ->keyBy('id')
                        ->map(fn($role) => $role->name)
                        ->toArray()
                ),
        ];
    }
    public function columns(): array
    {
        return [
            Column::make('id', 'id')
                ->sortable(),
            Column::make(trans('string.full name'), 'fname')->format(function ($value, $row) {

                return $row->fullname();
            })->sortable(),
            Column::make(trans('string.ID number'), 'national_id')
                ->sortable()->searchable(),
            Column::make('email', 'email')
                ->sortable()->searchable(),
            Column::make(trans('string.Roles'), 'id')->format(function ($value, $row) {

                return  $this->showUserRole($row->roles);
            })->html()->sortable(),
            Column::make(trans('string.update_at'), 'updated_at')->sortable(),
            Column::make(trans('string.create_at'), 'created_at')->sortable(),
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
    public function delete($id = 0): void
    {
        try {
            $item =  $this->model::where('id', '=', $id)->first();
          
            if ($item) {
                if (UserAction::delete($item)) {
                    Toaster::success(trans("messages.Deleted Item"));
                }
            } else {
                Toaster::error(trans('messages.Faild delete item'));
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' .  __FUNCTION__ . " : " . $th->getMessage());
        }
    }
    public function restore($id): void
    {

        $item =  $this->model::query()->withTrashed()->where('id', '=', $id)->first();
        if ($item) {
            if (UserAction::restore($item)) {
                Toaster::success(trans("messages.Restor Item"));
            }
        } else {
            Toaster::error(trans('messages.Faild restor item'));
        }
    }
    public function edit($id): void
    {
        redirect()->route('admin.auth.user.edit', $id);
    }

    public function setAddButton($addButtonRoute)
    {
        $this->setConfigurableAreas([
            'toolbar-left-start' => [
                'components.widgets.btn-create-new',
                [
                    'href' => $addButtonRoute,
                    'text' => trans('string.Add'),
                ],
            ],
        ]);
    }

    public function showUserRole($roles)
    {

        // dd($roles);
        $text = $roles->pluck('name')->implode(', ');
        $html = "<div class='flex' gap-1>";
        foreach ($roles as  $r) {
            $html .= "<span class='inline-flex ms-1 items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-white'>";
            $html .= $r->name;
            $html .= "</span>";
        }
        $html .= "</div>";
        return  $html;
    }
}
