<?php

namespace App\Livewire\Admin\Request\Template;

use App\Enums\StepRolesEnum;
use App\Models\Department;
use App\Models\RequestTemplates\OrderStep;
use App\Models\RequestTemplates\RequestTemplate;
use App\Models\RequestTemplates\RequestTemplateStep;
use App\Traits\StepsUi\StepTrait;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Edit extends Component
{
    use StepTrait;
    public $steps;
    public $departments;

    public $id;
    public $template;
    public $name;
    public $description;
    public $temp_updated = false;

    public $selected_step;
    public $order;
    public $template_step;
    public Collection $original_tempalte_steps;
    public Collection $original_tempalte_steps_list;
    public Collection $template_steps;

    public $selectedStepDescription;
    public function mount()
    {
        $this->index();
        $this->setMaxStep(3);

        $this->departments = Department::all();
        $this->template_steps = collect();
        $this->steps = RequestTemplateStep::all();
    }
    public function index()
    {
        if ($this->id > 0) {
            $this->template = RequestTemplate::where('id', $this->id)->with('order_steps.step')->first();


            $this->name = $this->template->name;
            $this->description = $this->template->description;
            if ($this->template) {
                $template_steps  = [];
                if ($this->template->order_steps) {
                    foreach ($this->template->order_steps as $i) {

                        $template_steps[$i->id] = [
                            'step' => $i->step,
                            'order' => $i->order,
                            "changed" => '0',
                            "delete" => '0'
                        ];
                    }
                }
                $this->original_tempalte_steps = $this->original_tempalte_steps_list = collect($template_steps);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function template_rules(): array
    {
        return  [

            'name' => [
                'required',
                'string',
                Rule::unique('request_templates', 'name')->ignore($this->template->id)
            ],
            'description' => 'nullable|string',
        ];
    }
    public function updateDescription()
    {
        if ($this->template_step) {

            $this->selectedStepDescription = $this->steps->where('id', $this->template_step)->first()->description;
        } else {
            $this->selectedStepDescription = '';
        }
    }
    public function template_step_rule_create()
    {
        return [
            'template_step' => [
                'required',

            ],
            'order' => 'required|integer',
        ];
    }
    public function next()
    {
        switch ($this->step) {
            case 1:
                $this->validate($this->template_rules());
                $this->increment();
                break;
            case 2:

                $this->increment();
                break;
            case 3:

                $this->increment();
                break;
        }
    }
    public function addTemplateStep()
    {
        $this->validate($this->template_step_rule_create());

        // first search is in original data 
        if ($this->selected_step > 0) {
            $existingOriginal = $this->original_tempalte_steps[$this->selected_step] ?? null;
            if ($existingOriginal) {

                $existingOriginal = [
                    'step' => $this->steps->where('id', $this->template_step)->first(),
                    'order' => $this->order,
                    "changed" => '1',
                    "delete" => '0'
                ];
                $this->original_tempalte_steps[$this->selected_step] = $existingOriginal;
            }
        } else {
            // Add new item
           
            $this->template_steps->push([
                'key' => "key_" . time(),
                'id' => $this->steps->where('id', $this->template_step)->first()->id,
                'step' => $this->steps->where('id', $this->template_step)->first(),
                'order' => $this->order,
            ]);
           
        }





        $this->reset(['template_step', 'order', 'selected_step']);
    }
    public function removeTemplaeStep($key)
    {
        $this->template_steps = $this->template_steps->reject(
            fn($item) => $item['key'] === $key
        );
    }

    public function removeOrginalData($key)
    {
        $item = $this->original_tempalte_steps[$key];
        $item['delete'] = '1';
        $this->original_tempalte_steps[$key] = $item;
    }
    public function restorOrginalData($key)
    {
        $this->original_tempalte_steps[$key] = $this->original_tempalte_steps_list[$key];
    }

    public function select_row($key)
    {
        $item = $this->original_tempalte_steps[$key];
        $this->order = $item['order'];
        $this->selected_step = $key;
        $this->template_step = $item['step']->id;
    }

    public function save()
    {
        $this->validate($this->template_rules());
        DB::transaction(function () {
            try {
                $template = $this->template;
                $template->name = $this->name;
                $template->description = $this->description;
                if ($template->isDirty()) {
                    $re = $template->save();
                } else {

                    $re =  true;
                }
                if ($re) {
                    foreach ($this->original_tempalte_steps as $key => $item) {
                        $temp = OrderStep::find($key);
                        $this->temp_updated = false;
                        if ($item['delete'] == '1') {
                            $this->temp_updated =     $temp->delete();
                        } else {
                            if ($item['changed'] == '1') {
                                $temp->request_tamplates_steps_id = $item['step']->id;
                                $temp->order = $item['order'];

                                $this->temp_updated =  $temp->save();
                            } else {
                                // nothing edit
                                $this->temp_updated = true;
                            }
                        }
                        if (!$this->temp_updated) {
                            throw new Exception("FAILD EDIT REQUEST TEMPLATE STEP");
                        }
                    }
                    foreach ($this->template_steps as $item) {
                        $temp = OrderStep::create([

                            'order' => $item['order'],
                            'request_tamplates_steps_id' =>  $item['id'],
                            'request_template_id' => $template->id

                        ]);
                        if ($temp) {
                            continue;
                        } else {
                            throw new Exception("FAILD ADD REQUEST TEMPALTE STEP");
                        }
                    }
                    DB::commit();
                    Toaster::success(trans('messages.Item Saved'));
                    return redirect()->route('admin.requests.templates.index');
                } else {
                    DB::rollBack();
                }
            } catch (Exception $e) {
                DB::rollBack();
                Log::error(__CLASS__ . "/" . __FUNCTION__ .  $e->getMessage());
                Toaster::error(trans('messages.Faild Add Item'));
            }
        });
    }
    public function render()
    {
        return view('livewire.admin.request.template.edit');
    }
}
