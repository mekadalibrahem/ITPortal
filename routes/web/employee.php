<?php

use Illuminate\Support\Facades\Route;



Route::group(
    [
        'prefix' => 'employee' ,
        'as' => "employee." ,
        'middleware' => ['auth']
    ],function(){
        Route::view('/requests' , 'employee.requests')->name('requests');
    }
);

