<?php

namespace App\Livewire\DataTables;

use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\RequestTemplates\RequestTemplate;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class RequestTemplateTable extends CustomeDataTableComponent
{
    protected $model = RequestTemplate::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.requests.templates.create'));
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
            Column::make(trans('string.Description'), "description")
                ->sortable(),


        ];
    }

    public function delete($id = 0): void
    {

        try {
            $item =  $this->model::where('id', '=', $id)->first();
            if ($item) {
                if ($item->delete()) {
                    Toaster::success(trans("messages.Deleted Item"));
                }
            } else {
                Toaster::error(trans('messages.Faild delete item'));
            }
        } catch (Exception $e) {
            if ($e->getCode() === '23000' || $e->getPrevious()?->getCode() === '19') {
                Toaster::error(trans('messages.CANNOT_DELETE_ITEM_IN_USE'));
            } else {
                Log::error(__CLASS__ . '@' .  __FUNCTION__ . " : " . $e->getMessage());
            }
        }
    }
    public function edit($id): void
    {
        redirect()->route('admin.requests.templates.edit', ["id" => $id]);
    }
}
