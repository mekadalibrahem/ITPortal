<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserControlelr;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SendResetPasswordLinkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route ;

Route::middleware('guest')->group(function(){
    Route::get('/register' ,[ RegisterUserControlelr::class , 'create'])->name('register');
    Route::post('/register' , [RegisterUserControlelr::class , 'store']);
    Route::get('/login' , [AuthenticatedSessionController::class , 'create'])->name('login');
    Route::get('/login_handler' , [AuthenticatedSessionController::class , 'store'])->name('login_handler');

    // start reste password

    Route::name('password.')->group(function(){
        Route::get('/forgot-password' , [SendResetPasswordLinkController::class , 'create'])->name('request');
        Route::post('/forgot-password', [SendResetPasswordLinkController::class , 'store'])->name('email');
        Route::get('/reset-password/{token}',[ResetPasswordController::class , 'create'])->name('reset');
        Route::post('/reset-password' , [ResetPasswordController::class , 'update'])->name('update');
    });


    // end reste password


});




Route::middleware(['auth' , 'auth.session' ] )->group(function(){
    Route::get('/logout' , [AuthenticatedSessionController::class , 'destroy'])->name('logout_handler');

    // start verify email
    // show verify page
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // verify email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('home');
    })->middleware( 'signed')->name('verification.verify');

    // resend verification notification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');


    // end verify email
    // Route::middleware('verified')->group(function () {
    //     Route::view('/home' , 'user.home')->name('home');
    // });


});


Route::middleware([
    'auth' , 'verified' , 'auth.session'
])->group(function(){
    Route::get('/home' , [HomeController::class , "create"]  )->name('home');
    Route::name('profile.')->group(function(){
        Route::get('/profile' , [ProfileController::class , 'create'])->name('create');

    });

});

