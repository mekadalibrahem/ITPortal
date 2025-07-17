<?php

namespace App\Livewire\User\Request;

use App\Enums\DataTypeEnum;

use App\Models\Requests;
use App\Models\RequestType;
use App\Models\RequireData;

use App\Traits\AddNewRequestTransaction;
use App\Traits\FillterAllowsItems;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class NewRequest extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    use AddNewRequestTransaction;
    use FillterAllowsItems;
    public $status = [];
    public $request;
    public $require_data = [];
    public $request_data = [];
    public $all_request_type = [];
    public $all_requests;
    public $selected_request;
    public $select_request;
    public $user;



    
    public function change_request()
    {
        try {

            $this->require_data = RequireData::where('requests_id', "=", $this->select_request)->get();

            $this->render();
        } catch (\Throwable $th) {
        }
    }
    public function mount()
    {
        $this->user = Auth::user();
        $this->all_request_type =  $this->fillter_allows_items(RequestType::all());
        $allowed_ids = [];
        foreach ($this->all_request_type as  $value) {
            $allowed_ids[] = $value->id;
        }
       
        $this->all_requests = Requests::whereIn(
            'type_id',
            
            $allowed_ids
        )->active()->get();
       
    }


    /**
     * build rules for request data
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->require_data as $item) {

            $name = $item->name_en;
            $req_data = RequireData::where('name_en', "=", $name)->first();
            $rules_item = DataTypeEnum::get_role($req_data->type);
            $rules["request_data.{$name}"] = $rules_item;
        }

        return $rules;
    }
    public function store($draft = false)
    {
        // dd($this->rules());
        $this->validate($this->rules());
        $is_done = $this->add_new_request_transaction(
            $draft,
            $this->user->id,
            $this->select_request,
            $this->request_data
        );

        if ($is_done) {
            Toaster::success(trans("messages.Request Saved"));
        }
        return redirect()->route('user.requests.create');
    }


    public function render()
    {
        return view(
            'livewire.user.request.new-request'
        );
    }
}
