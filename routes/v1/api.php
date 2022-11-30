<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\NotificationHistoryController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function() {
    Route::prefix('user')->group(function() {
        Route::any('search','search')->name('user.search');
        Route::get('firstById/{id}','firstById')->name('user.firstById');
    });
});

Route::controller(LanguageController::class)->group(function() {
    Route::prefix('language')->group(function() {
        Route::get('get','get')->name('language.get');
    });
});

Route::controller(CountryController::class)->group(function() {
    Route::prefix('country')->group(function() {
        Route::get('get','get')->name('country.get');
    });
});

Route::controller(RegionController::class)->group(function() {
    Route::prefix('region')->group(function() {
        Route::get('getByCountryId/{countryId}','getByCountryId')->name('country.getByCountryId');
    });
});

Route::controller(CityController::class)->group(function() {
    Route::prefix('city')->group(function() {
        Route::get('getByRegionId/{regionId}','getByRegionId')->name('city.getByRegionId');
    });
});

Route::controller(NotificationController::class)->group(function() {
    Route::prefix('notification')->group(function() {
        Route::get('getByUserId/{userId}','getByUserId')->name('notification.getByUserId');
    });
});

Route::controller(NotificationHistoryController::class)->group(function() {
    Route::prefix('notificationHistory')->group(function() {
        Route::get('getByNotificationId/{notificationId}','getByNotificationId')->name('notificationHistory.getByNotificationId');
    });
});
