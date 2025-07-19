<?php

namespace App\Livewire\Request;

use App\Enums\DataTypeEnum;
use App\Models\Requests;
use App\Models\RequestTemplates\RequestTemplate;
use App\Models\RequestType;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\RequireData;


class Add extends Component
{
    public $name;
    public $type;
    public $template;
    public $templates;
    public $types;
    public $active;
    public $validationPassed = false;
    public $step = 1;
    public $isFinishStep = false;
    public $MAX_STEP = 3;
    public $dataTypes;
    public Collection $dataRequired;

    public $data_name;
    public $data_name_en;
    public $datatype;



    public function mount()
    {
        $this->templates = RequestTemplate::all();
        $this->types = RequestType::all();
        $this->dataRequired = collect();
        $this->dataTypes = DataTypeEnum::array();
    }

    public  function request_rules(): array
    {
        return [
            'name' => 'required|min:8|unique:requests,name',
            'type' => 'required|exists:request_types,id',
            'template' => 'required|exists:request_templates,id',
        ];
    }

    public function validateStepOne()
    {

        $this->validate($this->request_rules());
        return true;
    }

    public function validateStepTwo()
    {
        // validat step logic 
        return true;
    }
    public function next()
    {
        switch ($this->step) {
            case 1:
                $this->validate($this->request_rules());
                    $this->step = 2;
                
                break;

            case 2:
                if ($this->validateStepTwo()) {
                    $this->step = 3;
                    $this->isFinishStep = true;
                }
                break;
        }
    }

    public function back()
    {
        $this->step =  $this->step - 1;
        if ($this->step < 1) {
            $this->step = 1;
        }
        if ($this->step != 3) {
            $this->isFinishStep = false;
        }
    }


    public function addData()
    {
        $this->validate([
            'data_name' => 'required',
            'data_name_en' => "required",
            'datatype' => 'required',
        ]);
        $existingIndex = $this->dataRequired->search(
            fn($item) => $item['name'] === $this->data_name
        );

        if ($existingIndex !== false) {
            // Update existing item
            $this->dataRequired = $this->dataRequired->map(function ($item) {
                if ($item['name'] === $this->data_name) {
                    return [
                        'name' => $this->data_name,
                        'name_en' => $this->data_name_en,
                        'type' => $this->datatype,
                    ];
                }
                return $item;
            });
        } else {
            // Add new item
            $this->dataRequired->push([
                'name' => $this->data_name,
                'name_en' => $this->data_name_en,
                'type' => $this->datatype,
            ]);
        }

        // Clear input fields
        $this->reset(['data_name', 'data_name_en', 'datatype']);
    }

    public function removeData($name)
    {

        $this->dataRequired = $this->dataRequired->reject(
            fn($item) => $item['name'] === $name
        );
    }
    public function save()
    {
        $this->validate($this->request_rules());

        DB::transaction(function () {
            try {
                $re = Requests::create([
                    'name' => $this->name,
                    'type_id' => $this->type,
                    'to_template' => $this->template,
                    'isActive' => $this->active ?? 0,
                ]);
                if ($re) {

                    foreach ($this->dataRequired as $item) {
                        RequireData::create([
                            'name' => $item['name'],
                            'name_en' => $item['name_en'],
                            'type' => $this->dataTypes[$item['type']],
                            'requests_id' => $re->id,
                        ]);
                    }
                    DB::commit();
                    Toaster::success(trans('messages.Request Saved'));
                    return redirect()->route('admin.requests.request.index');
                } else {
                    DB::rollBack();
                }
            } catch (Exception $e) {
                DB::rollBack();

                Toaster::error(trans('messages.Faild Add Request'));
            }
        });
    }
    public function render()
    {
        return view('livewire.request.add');
    }
}
