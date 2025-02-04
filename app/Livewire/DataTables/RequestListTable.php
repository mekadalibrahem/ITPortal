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
use Rappasoft\LaravelLivewireTables\Views\Columns\ColorColumn;

class RequestListTable extends DataTableComponent
{


    protected $model = RequestList::class;
    public  $user_id;
    protected $statusColors = [
        'draft' => [
            'light' => 'bg-gray-500 text-white', // Light mode: Gray background with white text
            'dark' => 'dark:bg-gray-700 dark:text-gray-200', // Dark mode: Dark gray background with light gray text
        ],
        'checking' => [
            'light' => 'bg-orange-500 text-white',
            'dark' => 'dark:bg-orange-700 dark:text-gray-200',
        ],
        'deleted' => [
            'light' => 'bg-red-500 text-white',
            'dark' => 'dark:bg-red-700 dark:text-gray-200',
        ],
        'wating' => [
            'light' => 'bg-yellow-500 text-black', // Yellow background with black text for contrast
            'dark' => 'dark:bg-yellow-700 dark:text-gray-200',
        ],
        'timeout' => [
            'light' => 'bg-orange-700 text-white',
            'dark' => 'dark:bg-orange-900 dark:text-gray-200',
        ],
        'working' => [
            'light' => 'bg-blue-400 text-white',
            'dark' => 'dark:bg-blue-600 dark:text-gray-200',
        ],
        'rejected' => [
            'light' => 'bg-red-600 text-white',
            'dark' => 'dark:bg-red-800 dark:text-gray-200',
        ],
        'end_rejected' => [
            'light' => 'bg-red-700 text-white',
            'dark' => 'dark:bg-red-900 dark:text-gray-200',
        ],
        'accept' => [
            'light' => 'bg-green-500 text-white',
            'dark' => 'dark:bg-green-700 dark:text-gray-200',
        ],
        'under delivery' => [
            'light' => 'bg-blue-500 text-white',
            'dark' => 'dark:bg-blue-700 dark:text-gray-200',
        ],
        'delevered' => [
            'light' => 'bg-green-600 text-white',
            'dark' => 'dark:bg-green-800 dark:text-gray-200',
        ],
    ];


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
        return $query;
    }
    public function columns(): array
    {


        return [

            Column::make('id', 'id')
                ->sortable()->hideIf(true),

            Column::make("Request name", "requests.name")
                ->attributes(function ($row) {

                    return [

                        'class' => '!',

                        'default' => true,

                    ];
                })
                ->sortable(),
                Column::make("Status", "status")
                ->sortable()
                ->format(function ($value, $row) {
                    // Get the status from the row
                    $status = $row->status;

                    // Get the corresponding light and dark mode styles for the status
                    $styles = $this->statusColors[$status] ?? [
                        'light' => 'bg-gray-300 text-black', // Default light mode style
                        'dark' => 'dark:bg-gray-700 dark:text-gray-200', // Default dark mode style
                    ];

                    // Combine light and dark mode styles
                    $class = $styles['light'] . ' ' . $styles['dark'];

                    // Return raw HTML with the status badge styled using Tailwind CSS
                    return "<div class='{$class} px-3 py-1 rounded-full text-sm font-medium text-center'>" .
                           ucfirst($status) .
                           "</div>";
                })->html(),
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
