<?php

namespace App\Livewire\Employee;

use App\Enums\RequestStatusEnum;
use App\Models\Employee;
use App\Models\RequestList;
use App\Models\RequestLog;
use Illuminate\Support\Facades\Auth;
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
    public $employee ;
    public $all_request_status;
    public $is_manager  = false;



    public function get_reqs_id($logs_id){
        $reqs_id = [] ;
        $logs = RequestLog::whereIn('id' , $logs_id)->get();
        foreach ($logs as $log) {
            $reqs_id[] = $log->request_list_id;
        }
        return $reqs_id ;
    }
    public function mount()
    {
        $this->all_request_status = RequestStatusEnum::cases();
        $this->employee =  Employee::where("user_id" , "=" , Auth::user()->id)->first();
        $this->is_manager = $this->employee->is_manager();

    }
    public function search()
    {



        $ID_list = $this->get_reqs_id($this->employee->get_request_log_ids());


        if (array_search("all", $this->request_status_fillter) > -1 || empty($this->request_status_fillter)) {
            return  RequestList::whereIn('id', $ID_list)
                ->orderBy('id', 'desc')->paginate(5);
        } else {
            return RequestList::whereIn('id', $ID_list)
                ->whereIn("status", $this->request_status_fillter)
                ->orderBy('id', 'desc')->paginate(5);
        }
    }


    public function status_fillter()
    {
        $this->render();
    }

    public function index($id)
    {
       if($id>0){
        $this->request_show = $id;
        $this->dispatch('show_request_info', id: $id);
       }
    }
    public function render()
    {
        return view('livewire.employee.requests-table',
        [
            "requests" =>   $this->search()
        ]);
    }
}
