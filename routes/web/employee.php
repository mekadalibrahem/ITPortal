<?php

use Illuminate\Support\Facades\Route;



Route::group(
    [
        'prefix' => 'employee' ,
        'as' => "employee." ,
        'middleware' => ['auth' , \Spatie\Permission\Middleware\RoleMiddleware::using('employee')]
    ],function(){
        Route::view('/requests' , 'dashboard.employee.requests')->name('requests');
        Route::view('/request/{id}' , 'dashboard.employee.request')->name('edit.request');
    }
);

