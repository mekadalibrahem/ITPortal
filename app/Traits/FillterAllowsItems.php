<?php
namespace App\Traits;
use Illuminate\Support\Facades\Gate;


trait FillterAllowsItems {


    public  function fillter_allows_items($itmes){

        $allows_items = [];
        foreach ($itmes as $item ) {
            if (Gate::allows('view', $item)) {
                // Log::info('start filtter allowed items : ' . $item->type);
                $allows_items[] = $item;
            }
        }
        return $allows_items ;
    }
}



