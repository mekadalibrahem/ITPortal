<?php

use Illuminate\Support\Facades\Route;



Route::group(
    [
        'prefix' => '',
        'as' => "admin.",
        'middleware' => ['auth',  \Spatie\Permission\Middleware\RoleMiddleware::using('admin')]
    ],
    function () {
        Route::group([
            'prefix' => 'auth',
            'as' => 'auth.'
        ],  function () {
            // TODO Add Route Authorization Routes
            Route::view('/role', 'dashboard.admin.auth.role')->name('role');
            Route::view('/user', 'dashboard.admin.auth.user')->name('user');
            Route::view('/permission', 'dashboard.admin.auth.permission')->name('permission');
        });

        Route::group([
            'prefix' => 'collage',
            'as' => 'collage.'
        ], function () {
            Route::view('/', 'dashboard.admin.collage.index')->name('index');
            Route::view('/create', 'dashboard.admin.collage.create')->name('create');
            Route::view('/{id}', 'dashboard.admin.collage.edit')->name('edit')->where(['id' => '[0-9]+']);
        });


        Route::group([
            'prefix' => 'requests',
            'as' => 'requests.'
        ], function () {
            // TODO  Add Request Type Managment
            Route::view('/type', 'dashboard.admin.requests.types')->name('type');

            Route::group([
                'prefix' => 'request',
                'as' => 'request.'
            ], function () {

                Route::view('/', 'dashboard.admin.requests.request.index')->name('index');
                Route::view('/create', 'dashboard.admin.requests.request.create')->name('create');
                Route::view('/{id}', 'dashboard.admin.requests.request.edit')->name('edit')->where(['id' => '[0-9]+']);
            });
        });


        Route::group([
            'prefix' => 'employee',
            'as' => 'employee.'
        ], function () {
            // TODO ADD employee Routes
            Route::view('/employee', 'dashboard.admin.employee.employee')->name('employee');
            // TODO ADD department Routes
            Route::view('/department', 'dashboard.admin.employee.department')->name('department');
        });
        // TODO  Add backups Routes
        Route::view("/backups", "dashboard.admin.tools.backup")->name("backups");
        // TODO  Add staticties Routes
        Route::view('/staticties', 'dashboard.admin.staticties')->name('staticties');
    }
);



// Route::view('admin/auth/permission', 'admin.auth.permission')->name('admin.auth.permission');
// Route::view('admin/auth/user', 'admin.auth.user')->name('admin.auth.user');
