<?php

namespace App\Livewire\User\Request;

use App\Enums\RequestStatusEnum;
use App\Models\RequestList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class RequestsTable extends Component
{
    use WithPagination;
    use WithoutUrlPagination;
    public $status = [];
    public $request_show = 0;
    public $request_status_fillter = ['all'];

    public $all_request_status;

    public function mount()
    {
        $this->all_request_status = RequestStatusEnum::cases();
    }
    public function search()
    {
        if (array_search("all", $this->request_status_fillter) > -1 || empty($this->request_status_fillter)) {
            return RequestList::where(
                [
                    ['id', '!=', 0],
                    ['user_id', "=", Auth::user()->id]
                ]
            )

                ->orderBy('id', 'desc')->paginate(5);
        } else {
            return RequestList::where(
                [
                    ['id', '!=', 0],
                    ['user_id', "=", Auth::user()->id]
                ]
            )
                ->whereIn("status", $this->request_status_fillter)
                ->orderBy('id', 'desc')->paginate(5);
        }
    }
    public function delete($id)
    {

        $re =  RequestList::where('id' , '=' , $id)->first();

        if (Gate::allows('delete' , $re)) {
            if ($re) {
                if ($re->delete()) {
                    $this->dispatch('re_deleted');
                    if ($id == $this->request_show) {
                        $this->index(0);
                    }
                }
            }
        } else {
            $this->status = [
                "type" => "warning",
                "message" => trans("messages.Can't delete Request")
            ];
        }
    }

    public function status_fillter()
    {
        $this->render();
    }

    public function index($id)
    {

       if($id >0){

        $this->request_show = $id;
        $this->dispatch('show_request_info', id: $id);
       }
    }


    #[On('re_deleted')]
    // #[On('add-role')]
    public function render()
    {
        return view(
            'livewire.user.request.requests-table',
            [
                "requests" =>   $this->search()
            ]
        );
    }
}
