<?php

namespace App\Livewire\DataTables;

use App\Models\CollageInformations;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\RequestList;
use App\Traits\RequestStatusStyle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class CollageInfoTable extends DataTableComponent
{
    use RequestStatusStyle;

    protected $model = CollageInformations::class;




    public function mount() {}

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEmptyMessage(trans("messages.Don't Have any request yet"));
        $this->setSearchStatus(false);
        // Add this configuration for the header button
        $this->setConfigurableAreas([

            'toolbar-left-start' => [

                'components.widgets.btn-create-new',
                [

                    'href' => Route('admin.collage.create'),
                    'text' => trans('string.Add'),

                ],

            ],

        ]);
    }

    public function builder(): Builder

    {


        return $this->model::query();
    }
    public function columns(): array
    {


        return [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),
            Column::make(trans('string.Name'), "name")
                ->sortable(),
            Column::make(trans('string.Value'), "value")
                ->sortable(),

            Column::make('Actions')
                ->label(
                    fn($row) => view(
                        'livewire.actions',
                        [
                            'row' => $row,
                            'confirm_delete_message' => trans("messages.confirm delete"),

                        ]
                    )

                )->html(),


        ];
    }

    public function delete($id)
    {
       
        try {
            $info =  $this->model::where('id', '=', $id)->first();
            if ($info) {
                if ($info->delete()) {
                    Toaster::success(trans("messages.Deleted Item"));
                }
            }else{
                Toaster::error(trans('messages.Faild delete item'));
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ .'@'.  __FUNCTION__ ." : " . $th->getMessage());
        }
    }
    public function edit($id)
    {
        redirect()->route('admin.collage.edit', ["id" => $id]);
    }
}
