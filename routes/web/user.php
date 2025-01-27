<?php
use Illuminate\Support\Facades\Route ;




Route::middleware([
    'auth' , 'auth.session'
])->group(function(){
    Route::group([
        "prefix" => "user" ,
        "as" => "user."
    ], function(){
        Route::view('/requests', 'user.requests')->name('requests.create');
        Route::view('/notification' , 'user.notification')->name("notification.create");
    });

});



