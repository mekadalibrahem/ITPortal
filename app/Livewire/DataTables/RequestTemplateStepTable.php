<?php

namespace App\Livewire\DataTables;

use Rappasoft\LaravelLivewireTables\Views\Column;


use App\Models\RequestTemplates\RequestTemplateStep;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class RequestTemplateStepTable extends CustomeDataTableComponent
{
    protected $model = RequestTemplateStep::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAddButton(Route('admin.requests.steps.create'));
    }

    public function builder(): Builder

    {
        return $this->model::query()->with('department');
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
            Column::make(trans('string.Department'), "department.name")
                ->sortable(),
            Column::make(trans('string.Role'), "role")
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
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . '@' .  __FUNCTION__ . " : " . $th->getMessage());
        }
    }
    public function edit($id): void
    {
        redirect()->route('admin.requests.steps.edit', ["id" => $id]);
    }
}
