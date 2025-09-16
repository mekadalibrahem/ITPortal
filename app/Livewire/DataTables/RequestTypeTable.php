<?php

namespace App\Livewire\DataTables;

use App\Models\RequestType;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Masmerise\Toaster\Toaster;

use Rappasoft\LaravelLivewireTables\Views\Column;


class RequestTypeTable extends CustomeDataTableComponent
{

    protected $model = RequestType::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.requests.type.create'));
    }
    public function builder(): Builder
    {
        return $this->model::query()
            ->select(['id', 'type']);
    }

    public function columns(): array
    {

        return [
            Column::make('id', 'id')
                ->sortable(),

            Column::make(trans('string.Type'), "type")
                ->sortable(),

        ];
    }
    public function delete($id = 0): void
    {


        $re =  $this->model::where('id', '=', $id)->first();
        if ($re) {
            try {

                if ($re->delete()) {
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
        }
    }
    public function edit($id): void
    {

        redirect()->route('admin.requests.type.edit', ["id" => $id]);
    }
}
