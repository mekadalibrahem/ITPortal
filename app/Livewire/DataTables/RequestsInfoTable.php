<?php

namespace App\Livewire\DataTables;


use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Requests;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class RequestsInfoTable extends DataTableComponent
{


    protected $model = Requests::class;




    public function mount() {}

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEmptyMessage(trans("messages.Don't Have any request yet"));
        $this->setSearchStatus(false);
        $this->setPerPageAccepted([5, 10, 25])->setPerPage(5);

        $this->setThAttributes(function (Column $column) {

            return [

                'default' => true,

                'default-styling' => true,

                'class' => ' text-start ',

            ];
        });





        // Add this configuration for the header button
        $this->setConfigurableAreas([

            'toolbar-left-start' => [

                'components.widgets.btn-create-new',
                [

                    'href' => Route('admin.requests.request.create'),
                    'text' => trans('string.Add'),

                ],

            ],

        ]);
    }

    public function builder(): Builder

    {
        return $this->model::query()->with(['department', 'type']);
    }
    public function columns(): array
    {


        return [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),
            Column::make(trans('string.Name'), "name")
                ->sortable(),
            Column::make(trans('string.Department'), "department.name")
                ->sortable(),
            Column::make(trans('string.Type'), "type.type")
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
            } else {
                Toaster::error(trans('messages.Faild delete item'));
            }
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' .  __FUNCTION__ . " : " . $th->getMessage());
        }
    }
    public function edit($id)
    {
        redirect()->route('admin.requests.request.edit', ["id" => $id]);
    }
}
