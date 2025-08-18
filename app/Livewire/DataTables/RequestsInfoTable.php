<?php

namespace App\Livewire\DataTables;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Requests;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class RequestsInfoTable extends CustomeDataTableComponent
{


    protected $model = Requests::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.requests.request.create'));
    }

    public function builder(): Builder

    {
        return $this->model::query()->with([ 'type' , 'template' , 'page'])
        ->select([ 'requests.id' , 'requests.name' ,'type.type' , 'template.name' , 'page.name']);
    }
    public function columns(): array
    {


        return [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),
            Column::make(trans('string.Name'), "name")
                ->sortable(),
         
            Column::make(trans('string.Type'), "type.type")
                ->sortable(),
            Column::make(trans('string.request_template.name') ,'template.name' )
            ->sortable(),
              Column::make(trans('string.slut.name') ,'page.name' )
            ->sortable()


        ];
    }

    public function delete($id=0) :void
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
    public function edit($id) : void
    {
        redirect()->route('admin.requests.request.edit', ["id" => $id]);
    }
}
