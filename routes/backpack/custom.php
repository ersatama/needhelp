<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('question', 'QuestionCrudController');
    Route::crud('request', 'RequestCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('lawyer', 'UserCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('region', 'RegionCrudController');
    Route::crud('language', 'LanguageCrudController');
    Route::crud('lawyer', 'LawyerCrudController');
    Route::crud('admin', 'AdminCrudController');
    Route::crud('ip', 'IpCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('price', 'PriceCrudController');
    Route::crud('moderator', 'ModeratorCrudController');
    Route::crud('notification-global', 'NotificationGlobalCrudController');
}); // this should be the absolute last line of this file
