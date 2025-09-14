<?php

use App\Http\Controllers\RequestListController;
use Illuminate\Support\Facades\Route;




Route::middleware([
    'auth',
    'auth.session'
])->group(function () {
    Route::group([
        "prefix" => "user",
        "as" => "user."
    ], function () {
        Route::group([
            "prefix" => "requests",
            "as" => "requests."
        ], function () {
            Route::get('/', [RequestListController::class, 'create'])->name('create');
            Route::get('/show/{id}', [RequestListController::class, 'index'])->name('index');
            Route::get('/addNew', [RequestListController::class, 'add'])->name('add');
        });
        Route::group([
            "prefix" => "notification",
            "as" => "notification."
        ], function () {
            Route::view('', 'user.notification.index')->name("index");
            Route::view('/create', 'user.notification.create')->name('create');
        });
    });
});
