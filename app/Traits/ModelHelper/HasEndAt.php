<?php

namespace App\Traits\ModelHelper;

use Carbon\Carbon;

trait HasEndAt
{

    protected $endAt = 'end_at';
    public function isEnd()
    {
        return $this[$this->endAt] ? true : false;
    }
    public function setEnd(?Carbon $time = null){
        $this[$this->endAt] = $time ?? Carbon::now();
        $this->save(); 
    }
    public function clearEnd(){
        $this[$this->endAt] = null;
        $this->save(); 
    }
    public function getEndTime(){
        
        return  $this[$this->endAt] ?? "----" ;
    }
   

}
