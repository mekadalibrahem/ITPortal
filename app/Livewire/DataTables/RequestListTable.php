<?php

namespace App\Livewire\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\RequestList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class RequestListTable extends DataTableComponent
{


    protected $model = RequestList::class;
    public  $user_id;



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

                    'href' => Route('user.requests.add'),

                    'text' => trans('string.Add'),

                ],

            ],

        ]);
    }

    public function builder(): Builder

    {

        return RequestList::query()

            ->where('user_id', '=', Auth::user()->id)
            ->with('requests');
    }
    public function columns(): array
    {


        return [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),

            Column::make("Request name", "requests.name")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Create at", "created_at")
                ->sortable(),
            Column::make("Update at", "updated_at")
                ->sortable(),
            Column::make('Actions')
                ->label(
                    fn($row) => view(
                        'livewire.actions',
                        [
                            'row' => $row,
                            'confirm_delete_message' => trans("messages.confirm delete request"),

                        ]
                    )

                )->html(),


        ];
    }

    public function delete($id)
    {


        $re =  RequestList::where('id', '=', $id)->first();

        if (Gate::allows('delete', $re)) {
            try {

                if ($re->request)
                    dd($re->requestLog);
                if ($re->requestLog) {
                    foreach ($re->requestLog as $log) {
                        dd($log);
                        $log->delete();
                    }
                }
                if ($re->delete()) {
                    Toaster::success(trans("messages.Deleted Item"));
                }
            } catch (\Throwable $th) {
                Log::error("RequestListTable@delete : " . $th->getMessage());
            }
        } else {
            Toaster::warning(trans("messages.Can't delete Request"));
        }
    }
    public function edit($id)
    {
        redirect()->route('user.requests.index', ["id" => $id]);
    }
}
