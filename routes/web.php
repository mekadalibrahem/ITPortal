<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WordExportController;


Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'language',
    'as' => 'language.'
], function () {
    Route::post('/switch', [LanguageController::class, 'switch'])->name('switch');
});

Route::get('/exportPdf', function () {
    return view('pdfs.document', ["text" => "النص العربي هنا"]);
})->withoutMiddleware('lang')->name("export_pdf_controller");


Route::get("/exportWord", [WordExportController::class, "export"])->withoutMiddleware("lang")->name("ex-word");

// Route::get('/app/request_photos/{$name}', function($name)){
//     return
// }
// Route::view('/user/home' , 'user.home')->name('user.home');

require __DIR__ . "/web/auth.php";
require __DIR__ . "/web/admin.php";
require __DIR__ . "/web/user.php";
require __DIR__ . "/web/employee.php";
require __DIR__ . "/web/dashboard.php";
require __DIR__ . "/web/test.php";
