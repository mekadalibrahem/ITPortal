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
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\RequireData;
use App\Traits\StepsUi\StepTrait;
use Illuminate\Support\Facades\Log;
use MSA\LaravelGrapes\Models\Page;

class Add extends Component
{
    use StepTrait;
    public $name;
    public $type;
    public $departments;
    public $types;
    public $active;
    public $page;
    public $pages;

    public $dataTypes;
    public Collection $dataRequired;

    public $data_name;
    public $data_name_en;
    public $datatype;
    
    public $templates;
    public $template = 0;
    public $template_name;
    public $template_disc;

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
        $this->templates = RequestTemplate::query()->with('order_steps', 'order_steps.step')->get();
        $this->template_steps = RequestTemplateStep::all();
        $this->types = RequestType::all();
        $this->departments  = Department::all();
        $this->dataRequired = collect();
        $this->dataTypes = DataTypeEnum::array();
        $this->pages = Page::all();
        $this->setMaxStep(5);
        $this->template_steps_list = collect();
        $this->roles = StepRolesEnum::array();
    }

    public  function request_rules(): array
    {
        return [
            'name' => 'required|min:8|unique:requests,name',
            'type' => 'required|exists:request_types,id',
            'page' => 'required|exists:pages,id',
        ];
    }

    public function validate_template()
    {
        if ($this->template <= 0) {
            $this->validate([
                'template_name' => 'required|string|unique:request_templates,name',
                'template_disc' => 'nullable|string',
            ]);
            $this->increment();
        } else {
            $steps = RequestTemplateStep::query()->join('order_steps', 'order_steps.request_tamplates_steps_id', 'request_tamplates_steps.id')
                ->where('request_template_id', '=', $this->template)
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
                $this->validate($this->request_rules());
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
            if ($this->template) {
                // skip add request step for template  (step)
                $this->template_steps_list = collect();
                $this->decremnt();
            }
        }
        $this->decremnt();
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
                // check if new template or not
                $template_id = $this->template;
                if ($this->template <= 0) {
                    // create new template
                    $template =  RequestTemplate::create([
                        'name' => $this->template_name,
                        'description' => $this->template_disc,
                    ]);
                    if (!$template) {
                        DB::roleBack();
                    }
                    // update template id 
                    $template_id = $template->id;
                    // create step and link with tempalte
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
                            $step = $new_step;
                            $step_id = $step->id;
                        }
                        if ($item['link'] == 1) {
                            $step_id = $step['id'];
                        }
                        // step alreade created so just link with template
                        $linked = OrderStep::create([
                            'order' => $order,
                            'request_tamplates_steps_id' =>  $step_id,
                            'request_template_id' => $template_id
                        ]);
                        if (!$linked) {
                            DB::rollBack();
                        }
                    }
                }
                $re = Requests::create([
                    'name' => $this->name,
                    'type_id' => $this->type,
                    'request_template_id' => $template_id,
                    'isActive' => $this->active ?? 0,
                    'page_id' => $this->page,
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
                Log::error($e->getMessage());
                Toaster::error(trans('messages.Faild Add Request'));
            }
        });
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
    public function render()
    {
        return view('livewire.request.add');
    }
}
