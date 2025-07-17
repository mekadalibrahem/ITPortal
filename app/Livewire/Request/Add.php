<?php

namespace App\Livewire\Request;

use App\Enums\DataTypeEnum;
use App\Models\Department;
use App\Models\Requests;
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
    public $department;
    public $departments;
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
        $this->departments = Department::all();
        $this->types = RequestType::all();
        $this->dataRequired = collect();
        $this->dataTypes = DataTypeEnum::array(); 
    }

    public function validateStepOne()
    {

        $this->validate([
            'name' => 'required|min:8|unique:requests,name',
            'type' => 'required|exists:request_types,id',
            'department' => 'required|exists:departments,id',
        ]);
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
                if ($this->validateStepOne()) {
                    $this->step = 2;
                }
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
        $this->validate([
            'name' => 'required|min:8|unique:requests,name',
            'type' => 'required|exists:request_types,id',
            'department' => 'required|exists:departments,id',
        ]);

        DB::transaction(function () {
            try {
                $re = Requests::create([
                    'name' => $this->name,
                    'type_id' => $this->type,
                    'to_department' => $this->department,
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
