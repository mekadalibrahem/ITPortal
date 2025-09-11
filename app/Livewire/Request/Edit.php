<?php

namespace App\Livewire\Request;

use App\Enums\DataTypeEnum;
use App\Enums\StepRolesEnum;
use App\Models\Department;
use App\Models\Requests;
use App\Models\RequestTemplates\OrderStep;
use App\Models\RequestTemplates\RequestTemplate;
use App\Models\RequestTemplates\RequestTemplateStep;
use App\Models\RequestType;
use App\Models\RequireData;
use App\Traits\StepsUi\StepTrait;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use MSA\LaravelGrapes\Models\Page;

class Edit extends Component
{
    use StepTrait;
    public $name;
    public $type;

    public $pages;
    public $page;
    public $types;
    public $active;
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

    public $template_id;
    public $template;
    public $templates;
    public $template_name;
    public $template_disc;

    public $departments;

    public $template_steps;
    public $template_step  = 0;
    public $step_name;
    public $step_description;
    public $step_role;
    public $step_department;
    public Collection $template_steps_list;
    public $roles;

    public function mount()
    {
        $this->index();
        $this->setMaxStep(5);
        $this->templates = RequestTemplate::query()->with('order_steps', 'order_steps.step')->get();
        $this->template_steps = RequestTemplateStep::all();
        $this->types = RequestType::all();
        $this->dataTypes = DataTypeEnum::array();
        $this->pages = Page::all();
        $this->departments  = Department::all();
        $this->template_steps_list = collect();
        $this->roles = StepRolesEnum::array();
    }

    public function index()
    {
        $this->req = Requests::where('id', $this->id)->with('requireData')->first();


        if ($this->req) {
            $this->name =  $this->req->name;
            $this->type = $this->req->type_id;
            $this->template_id =  $this->req->request_template_id;
            $this->active   =  $this->req->isActive ? true : false;
            $this->page = $this->req->page_id;
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
    public function update_request_rules(): array
    {
        return [
            'name' => [
                'required',
                'min:8',
                Rule::unique('requests', 'name')->ignore($this->req->id)
            ],
            'type' => 'required|exists:request_types,id',

            'page' => 'required|exists:pages,id',
        ];
    }
    public function validate_template()
    {
        if ($this->template_id <= 0) {
            $this->validate([
                'template_name' => 'required|string|unique:request_templates,name',
                'template_disc' => 'nullable|string',
            ]);
            $this->increment();
        } else {
            $steps = RequestTemplateStep::query()->join('order_steps', 'order_steps.request_tamplates_steps_id', 'request_tamplates_steps.id')
                ->where('request_template_id', '=', $this->template_id)
                ->orderBy('order')
                ->get();

            $steps->map(function ($step) {
                $this->template_steps_list->push([
                    'link' => 0,
                    'create' => 0,
                    'step' => $step->toArray()
                ]);
            });

            $this->increment();
            $this->increment();
        }
    }
    public function next()
    {
        switch ($this->step) {
            case 1:
                $this->validate($this->update_request_rules());
                $this->increment();
                break;

            case 2:
                $this->increment();
                break;
            case 3:

                $this->validate_template();
                break;
            case 4:
                $this->increment();
                break;
        }
    }

    public function back()
    {
        if ($this->step == 5) {
            if ($this->template_id) {
                // skip add request step for template  (step)
                $this->template_steps_list = collect();
                $this->decremnt();
            }
        }
        $this->decremnt();
    }


    public function resetData($i)
    {
        switch ($i) {

            case 1:
                $this->name =  $this->req->name;
                $this->type = $this->req->type_id;
                $this->template =  $this->req->request_template_id;
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

    public function addStep()
    {
        if ($this->template_step) {

            $selectedStep = $this->template_steps->find($this->template_step);

            if (!$selectedStep) {
                $this->addError('template_step', 'Selected step not found.');
                return;
            }

            $this->template_steps_list->push([
                'link' => 1,
                'create' => 0,
                'step' => $selectedStep->toArray(),
            ]);
        } else {
            // create new step 
            $this->validate([
                'step_name' => 'required|string',
                'step_description' => 'nullable|string',
                'step_role' => 'required|string',
                'step_department' => 'exists:departments,id',
            ]);
            $stepData = [
                'name' => $this->step_name,
                'description' => $this->step_description,
                'role' => $this->step_role,
                'department_id' => $this->step_department,

            ];

            $this->template_steps_list->push([
                'link' => 0,
                'create' => 1,
                'step' => $stepData,
            ]);
            $this->reset('step_name', 'step_description', 'step_role', 'step_department');
        }
    }
    public function removeStep($index)
    {
        $this->template_steps_list = $this->template_steps_list->reject(function ($value, $key) use ($index) {
            return  $key == $index;
        });
    }

    public function save()
    {

        $this->validate($this->update_request_rules());
        DB::transaction(function () {
            try {
                $request_template_id = $this->template_id;
                if ($this->template_id <= 0) {
                    //  first clear all template step that stored in order step table  for old template 
                    $deleted_old_template_data = OrderStep::where('request_template_id', '=', $this->req->request_template_id)->delete();
                    if (!$deleted_old_template_data) {
                        DB::rollBack();
                    }
                    // create new template
                    $template =  RequestTemplate::create([
                        'name' => $this->template_name,
                        'description' => $this->template_disc,
                    ]);
                    if (!$template) {
                        DB::rollBack();
                    }
                    // update template id 
                    $request_template_id = $template->id;
                    foreach ($this->template_steps_list as $key => $item) {
                        $step = $item['step'];
                        $step_id = 0;
                        $order = $key + 1;
                        if ($item['create'] == 1) {
                            // new step => create it 
                            $new_step = RequestTemplateStep::create([
                                'name' => $step['name'],
                                'description' => $step['description'],
                                'role' => $this->roles[$step['role']],
                                'department_id' => $step['department_id'],

                            ]);
                            if (!$new_step) {
                                DB::rollBack();
                            }

                            $step_id = $new_step->id;
                        }
                        if ($item['link'] == 1) {
                            $step_id = $step['id'];
                        }
                        // step alreade created so just link with template
                        $linked = OrderStep::create([
                            'order' => $order,
                            'request_tamplates_steps_id' =>  $step_id,
                            'request_template_id' => $request_template_id
                        ]);
                        if (!$linked) {
                            DB::rollBack();
                        }
                    }
                }


                $req = $this->req;
                $req->name = $this->name;
                $req->request_template_id = $request_template_id;
                $req->type_id = $this->type;
                $req->isActive = $this->active ? 1 : 0;
                $req->page_id = $this->page;
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
                Log::error(__CLASS__ . "@" . __FUNCTION__ . " : " . $e->getMessage());
                Toaster::error(trans('messages.Failed to update request.'));
            }
        });
    }

    public function render()
    {

        return view('livewire.request.edit');
    }
}
