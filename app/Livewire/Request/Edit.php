<?php

namespace App\Livewire\Request;

use App\Enums\DataTypeEnum;
use App\Models\Department;
use App\Models\Requests;
use App\Models\RequestType;
use App\Models\RequireData;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
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
    public $MAX_STEP  = 3;
    public $dataTypes = [];
    public $req;
    public $id;
    public Collection $dataRequired;
    public Collection $requiredDataOriginalList;
    public Collection $requiredDataOriginal;
    public $temp_updated;
    public $data_name;
    public $data_name_en;
    public $datatype;

    public function mount()
    {
        $this->index();
        $this->departments = Department::all();
        $this->types = RequestType::all();
        $this->dataTypes = DataTypeEnum::array();
    }

    public function index()
    {
        $this->req = Requests::where('id', $this->id)->with('requireData')->first();


        if ($this->req) {
            $this->name =  $this->req->name;
            $this->type = $this->req->type_id;
            $this->department =  $this->req->to_department;
            $this->active   =  $this->req->isActive ? true : false;
            $temp_array = [];
            foreach ($this->req->requireData as $i) {
                $temp_array[$i->id] = [
                    "name" => $i->name,
                    "name_en" => $i->name_en,
                    "type" => $i->type,
                    "requests_id" => $i->requests_id,
                    "changed" => '0',
                    "delete" => '0'
                ];
            }
            $this->requiredDataOriginalList = $this->requiredDataOriginal = collect($temp_array);

            $this->dataRequired = collect();
        } else {
            abort(404);
        }
    }
    public function validateStepOne()
    {

        $this->validate([
            'name' => [
                'required',
                'min:8',
                Rule::unique('requests', 'name')->ignore($this->req->id)
            ],
            'type' => 'required|exists:request_types,id',
            'department' => 'required|exists:departments,id',
        ]);
        return true;
    }
    public function next()
    {
        switch ($this->step) {
            case 1:
                if ($this->validateStepOne()) {
                    $this->step++;
                }
                break;

            case 2:

                $this->step++;
                $this->isFinishStep = true;

                break;
        }
    }

    public function back()
    {
        $this->step =  $this->step - 1;
        if ($this->step < 1) {
            $this->step = 1;
        }
        if ($this->step != $this->MAX_STEP) {
            $this->isFinishStep = false;
        }
    }


    public function resetData($i)
    {
        switch ($i) {

            case 1:
                $this->name =  $this->req->name;
                $this->type = $this->req->type_id;
                $this->department =  $this->req->to_department;
                $this->active   =  $this->req->isActive ? true : false;
                break;
            case 2:
                $this->dataRequired = collect();
                $this->requiredDataOriginal = $this->requiredDataOriginalList;
                break;
        }
    }
    public function addData()
    {
        $this->validate([
            'data_name' => 'required',
            'data_name_en' => "required",
            'datatype' => 'required',
        ]);
        $this->temp_updated = false;
        // first search is in original data 
        $existingIndexOriginal = $this->requiredDataOriginal->search(
            fn($item) => $item['name'] == $this->data_name
        );
        if ($existingIndexOriginal) {
            $this->requiredDataOriginal = $this->requiredDataOriginal->map(function ($item) {
                if ($item['name'] == $this->data_name) {
                    return [
                        'name' => $this->data_name,
                        'name_en' => $this->data_name_en,
                        'type' => $this->datatype,
                        'changed' => '1',
                        'delete' => '0',

                    ];
                }
                return $item;
            });
            $this->temp_updated = true;
        }
        if ($this->temp_updated !== true) {

            // if not in original data search in new add list
            $existingIndex = $this->dataRequired->search(
                fn($item) => $item['name'] == $this->data_name
            );

            if ($existingIndex !== false) {
                // Update existing item
                $this->dataRequired = $this->dataRequired->map(function ($item) {
                    if ($item['name'] == $this->data_name) {
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
        }
        // Clear input fields
        $this->reset(['data_name', 'data_name_en', 'datatype']);
        $this->temp_updated = false;
    }

    public function removeData($name)
    {

        $this->dataRequired = $this->dataRequired->reject(
            fn($item) => $item['name'] == $name
        );
    }
    public function removeOrginalData($key)
    {

        $item = $this->requiredDataOriginal[$key];
        $item['delete'] = '1';
        $this->requiredDataOriginal[$key] = $item;
    }

    public function restorOrginalData($key)
    {
        $this->requiredDataOriginal[$key] = $this->requiredDataOriginalList[$key];
    }



    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'min:8',
                Rule::unique('requests', 'name')->ignore($this->req->id)
            ],
            'type' => 'required|exists:request_types,id',
            'department' => "required|exists:departments,id",
            'active' => 'boolean'
        ]);
        DB::transaction(function () {
            try {
                $req = $this->req;
                $req->name = $this->name;
                $req->to_department = $this->department;
                $req->type_id = $this->type;
                $req->isActive = $this->active ? 1 : 0;
                $updated = false;

                if ($req->isDirty()) {
                    $updated = $req->save();
                } else {
                    // nothing to updated in request information 
                    $updated = true;
                }
                if ($updated) {
                    foreach ($this->requiredDataOriginal as $key => $item) {
                        $temp = RequireData::find($key);
                        if ($item['delete'] == '1') {
                            $temp->delete();
                        } else {
                            if ($item['changed'] == '1') {

                                $temp->name = $item['name'];
                                $temp->name_en = $item['name_en'];
                                $temp->type = $this->dataTypes[$item['type']];
                                $temp->save();
                            }
                        }
                    }


                    foreach ($this->dataRequired as $item) {
                        RequireData::create([
                            'name' => $item['name'],
                            'name_en' => $item['name_en'],
                            'type' => $this->dataTypes[$item['type']],
                            'requests_id' => $req->id,
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
                // Log::error(__CLASS__ . "@" . __FUNCTION__ . " : " . $e->getMessage());
                Toaster::error(trans('messages.Failed to update request.'));
            }
        });
    }

    public function render()
    {

        return view('livewire.request.edit');
    }
}
