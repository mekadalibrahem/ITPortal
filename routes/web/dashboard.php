<?php

use App\Http\Controllers\DashboardController;
use illuminate\Support\Facades\Route ;


Route::group(
    [
        'prefix' => 'dashboard' ,
        'as' => "dashboard." ,
        'middleware' => ['auth']
    ],function(){
        Route::get('/' , [DashboardController::class , 'index'])->name('index');
    }
);
