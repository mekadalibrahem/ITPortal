<?php

namespace App\Livewire\Admin\Request\Template;

use App\Models\Department;
use App\Models\RequestTemplates\OrderStep;
use App\Models\RequestTemplates\RequestTemplate;
use App\Models\RequestTemplates\RequestTemplateStep;
use App\Traits\StepsUi\StepTrait;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Add extends Component
{
    use StepTrait;

    public $name;
    public $description;
    public $departments;

    public $template_steps;
    public Collection  $insert_step_list;
    public $template_step;
    public $selectedStepDescription;
    public $order;

    // public Collection $template_steps;

    public function mount()
    {
        $this->setMaxStep(3);
        $this->departments = Department::all();
        $this->template_steps = RequestTemplateStep::all();
        

        $this->insert_step_list = collect();
    }
    public function updateDescription()
    {
        if ($this->template_step) {
            $this->selectedStepDescription = $this->template_steps->where('id',$this->template_step)->first()->description;
           
        } else {
            $this->selectedStepDescription = '';
        }
    }
    public function template_rules(): array
    {
        return  [
            'name' => 'required|string|unique:request_templates,name',
            'description' => 'nullable|string',
        ];
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
        $step  = $this->template_steps->where('id',$this->template_step)->first();
        // Add new item
        $this->insert_step_list->push([
            'id' => $step->id,
            'step' => $step,
            'order' => $this->order
        ]);
        


        // Clear input fields
        $this->reset(['template_step', 'order']);
    }
    public function removeTemplaeStep($key)
    {
        $this->insert_step_list = $this->insert_step_list->reject(
            fn($item) => $item['id'] == $key
        );
       
    }

    public function save()
    {
        $this->validate($this->template_rules());
        DB::transaction(function () {
            try {
                $re = RequestTemplate::create([
                    'name' => $this->name,
                    'description' => $this->description,

                ]);
                if ($re) {

                    foreach ($this->insert_step_list as $item) {
                        $temp = OrderStep::create([

                            'order' => $item['order'],
                            'request_tamplates_steps_id' =>  $item['id'],
                            'request_template_id' => $re->id

                        ]);
                        if ($temp) {
                            continue;
                        } else {
                            DB::rollBack();
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
                // Log::error(__CLASS__ . "/" . __FUNCTION__ .  $e->getMessage());
                Toaster::error(trans('messages.Faild Add Item'));
            }
        });
    }
    public function render()
    {
        return view('livewire.admin.request.template.add');
    }
}
