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

            Route::group([
                'prefix' => 'role',
                'as' => 'role.'
            ], function () {
                Route::view('/', 'dashboard.admin.auth.role.index')->name('index');
                Route::view('/create', 'dashboard.admin.auth.role.create')->name('create');
                Route::view('/{id}', 'dashboard.admin.auth.role.edit')->name('edit')->where(['id' => '[0-9]+']);
            });

          Route::group([
              'prefix' => 'user',
              'as' => 'user.'
          ], function () {
              Route::view('/', 'dashboard.admin.auth.user.index')->name('index');
            //   Route::view('/create', 'dashboard.admin.auth.user.create')->name('create');
            //   Route::view('/{id}', 'dashboard.admin.auth.user.edit')->name('edit')->where(['id' => '[0-9]+']);
          });
           Route::group([
               'prefix' => 'permission',
               'as' => 'permission.'
           ], function(){
               Route::view('/', 'dashboard.admin.auth.permission.index')->name('index');
               Route::view('/create', 'dashboard.admin.auth.permission.create')->name('create');
               Route::view('/{id}', 'dashboard.admin.auth.permission.edit')->name('edit')->where(['id' => '[0-9]+']);
           });
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

            Route::group([
                "prefix" => "type",
                'as' => "type."
            ], function () {
                Route::view('/', 'dashboard.admin.requests.type.index')->name('index');
                Route::view('/create', 'dashboard.admin.requests.type.create')->name('create');
                Route::view('/{id}', 'dashboard.admin.requests.type.edit')->name('edit')->where(['id' => '[0-9]+']);
            });


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
            Route::view('/', 'dashboard.admin.employee.employee.index')->name('index');
            Route::view('/create', 'dashboard.admin.employee.employee.create')->name('create');
            Route::view('/{id}', 'dashboard.admin.employee.employee.edit')->name('edit')->where(['id' => '[0-9]+']);
        });

        Route::group([
            'prefix' => 'department',
            'as' => 'department.'
        ], function () {
            Route::view('/', 'dashboard.admin.employee.department.index')->name('index');
            Route::view('/create', 'dashboard.admin.employee.department.create')->name('create');
            Route::view('/{id}', 'dashboard.admin.employee.department.edit')->name('edit')->where(['id' => '[0-9]+']);
        });

        // TODO  Add backups Routes
        Route::view("/backups", "dashboard.admin.tools.backup")->name("backups");
        // TODO  Add staticties Routes
        Route::view('/staticties', 'dashboard.admin.staticties')->name('staticties');
    }
);

