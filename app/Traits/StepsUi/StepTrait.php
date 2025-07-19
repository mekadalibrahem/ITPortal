<?php

namespace App\Traits\StepsUi;


trait StepTrait
{
    public $step = 1;
    public $max_step = 1;
    public $isFinishStep = false;
    public function setStep($i)
    {
        $this->step = $i;
    }
    public function setMaxStep($max)
    {
        $this->max_step = $max;
    }
    public function increment()
    {
        if ($this->step < $this->max_step) {
            $this->step++;
        }
        if ($this->step == $this->max_step) {
            $this->finish();
        }
    }
    public function decremnt()
    {
        if ($this->step > 1) {
            $this->step--;
        }
        if ($this->step < $this->max_step) {
            $this->unfinish();
        }
    }

    abstract public function next();
    public function back(){
        $this->decremnt();
    }
    public function finish()
    {
        $this->isFinishStep = true;
    }
    public function unfinish()
    {
        $this->isFinishStep = false;
    }
}
