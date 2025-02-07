<?php

use Illuminate\Support\Facades\Route;



Route::group(
    [
        'prefix' => '' ,
        'as' => "admin." ,
        'middleware' => ['auth' ,  \Spatie\Permission\Middleware\RoleMiddleware::using('admin')]
    ],function(){
        Route::group([
            'prefix' =>'auth' ,
            'as' => 'auth.'
        ] ,  function(){

            Route::view('/role' , 'dashboard.admin.auth.role')->name('role');
            Route::view('/user' , 'dashboard.admin.auth.user')->name('user');
            Route::view('/permission' , 'dashboard.admin.auth.permission')->name('permission');
        } );

        Route::view('/collage_information' , 'dashboard.admin.collage_information')->name('collage_information');

        Route::group([
            'prefix' => 'requests' ,
            'as' => 'requests.'
        ] , function () {
            Route::view('/type' , 'admin.requests.types')->name('type');
            Route::view('/requset' , 'admin.requests.request')->name('requset');
        });


        Route::group([
            'prefix' => 'employee' ,
            'as' => 'employee.'
        ], function(){

            Route::view('/employee' , 'admin.employee.employee')->name('employee');
            Route::view('/department' , 'admin.employee.department')->name('department');

        });

        Route::view("/backups","dashboard.admin.tools.backup")->name("backups");
        Route::view('/staticties' , 'dashboard.admin.staticties')->name('staticties');


});



// Route::view('admin/auth/permission', 'admin.auth.permission')->name('admin.auth.permission');
// Route::view('admin/auth/user', 'admin.auth.user')->name('admin.auth.user');



