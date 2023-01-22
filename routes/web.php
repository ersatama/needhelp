<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\IpAddressMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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

Route::get('/', function () {
    return view('welcome');
});


Route::controller(\App\Http\Controllers\Api\NotificationController::class)->group(function() {
    Route::get('/onesignal', 'onesignal');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('login','login')->name('backpack.auth.login');
});

Route::get('/terms', function () {
    return Response::make(file_get_contents('docs/terms.pdf'), 200, [
        'content-type'=>'application/pdf',
    ]);
});

Route::get('/privacy', function() {
    return view('privacy.index');
});
