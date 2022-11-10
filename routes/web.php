<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\Front\HomeController::class, 'index'])->name('front.home');
Route::get('/test', [\App\Http\Controllers\TestController::class, 'code']);

Route::prefix('webhook')->group(function () {
    Route::get('sld/result' , [\App\Http\Controllers\Webhook\SldController::class, 'call']);
});
