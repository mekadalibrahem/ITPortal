<?php

namespace App\Livewire\DataTables;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\RequestList;
use App\Traits\RequestStatusStyle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Masmerise\Toaster\Toaster;

class RequestListTable extends CustomeDataTableComponent
{
    use RequestStatusStyle;

    protected $model = RequestList::class;
    public  $user_id;



    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setAddButton(Route('user.requests.add'));
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

            Column::make(trans('string.Request type'), "requests.name")
                ->attributes(function ($row) {

                    return [

                        'class' => '!',

                        'default' => true,

                    ];
                })
                ->sortable(),
            Column::make(trans('string.Status'), "status")
                ->sortable()
                ->format(function ($value, $row) {
                    // Get the status from the row
                    $status = $row->status;


                    $class = $this->getStatusStyle($status);

                    // Return raw HTML with the status badge styled using Tailwind CSS
                    return "<div class='{$class} px-3 py-1 rounded-full text-sm font-medium text-center'>" .
                        ucfirst($status) .
                        "</div>";
                })->html(),
            // Column::make("Create at", "created_at")
            //     ->sortable(),
            // Column::make("Update at", "updated_at")
            //     ->sortable(),
            // Column::make('Actions')
            //     ->label(
            //         fn($row) => view(
            //             'livewire.actions',
            //             [
            //                 'row' => $row,
            //                 'confirm_delete_message' => trans("messages.confirm delete request"),

            //             ]
            //         )

            //     )->html(),


        ];
    }

    public function delete($id=0) :void
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
    public function edit($id) : void
    {
        redirect()->route('user.requests.index', ["id" => $id]);
    }
}
