<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\NotificationHistoryController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WooppayController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function() {
    Route::prefix('user')->group(function() {
        Route::get('userDateBetween/{start}/{end}','userDateBetween')->name('user.userDateBetween');
        Route::get('deleteById/{id}','deleteById')->name('user.deleteById');
        Route::get('deleteByPhone/{phone}','deleteByPhone')->name('user.deleteByPhone');
        Route::get('restoreById/{id}','restoreById')->name('user.restoreById');
        Route::get('restoreByPhone/{phone}','restoreByPhone')->name('user.restoreByPhone');
        Route::get('checkUserByPhone/{phone}','checkUserByPhone')->name('user.checkUserByPhone');
        Route::get('firstByPhone/{phone}','firstByPhone')->name('user.firstByPhone');
        Route::get('checkCode/{phone}/{code}','checkCode')->name('user.checkCode');
        Route::get('resetPassword/{phone}','resetPassword')->name('user.resetPassword');
        Route::get('sendRegisterCode/{phone}','sendRegisterCode')->name('user.sendRegisterCode');
        Route::get('resendRegisterCode/{phone}','resendRegisterCode')->name('user.resendRegisterCode');
        Route::any('search','search')->name('user.search');
        Route::post('create','create')->name('user.create');
        Route::post('update/{id}','update')->name('user.update');
        Route::get('auth/{phone}/{password}','auth')->name('user.auth');
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

Route::controller(QuestionController::class)->group(function() {
    Route::prefix('question')->group(function() {
        Route::post('get','get')->name('get');
        Route::get('priceDateBetween/{start}/{end}','priceDateBetween')->name('question.priceDateBetween');
        Route::get('countDateBetween/{start}/{end}','countDateBetween')->name('question.countDateBetween');
        Route::get('averageBetweenClosed/{start}/{end}','averageBetweenClosed')->name('averageBetweenClosed');
        Route::get('countDateLawyerBetweenClosed/{lawyerId}/{start}/{end}','countDateLawyerBetweenClosed')->name('question.countDateLawyerBetweenClosed');
        Route::get('countDateAverageBetweenClosed/{lawyerId}/{start}/{end}','countDateAverageBetweenClosed')->name('question.countDateAverageBetweenClosed');
        Route::get('countDateBetweenClosed/{start}/{end}','countDateBetweenClosed')->name('question.countDateBetweenClosed');
        Route::get('getByUserId/{userId}','getByUserId')->name('question.getByUserId');
        Route::get('firstById/{id}','firstById')->name('question.firstById');
        Route::post('create','create')->name('question.create');
        Route::post('update/{id}','update')->name('question.update');
    });
});

Route::controller(WooppayController::class)->group(function() {
    Route::prefix('wooppay')->group(function() {
        Route::any('request','request')->name('wooppay.request');
        Route::any('back','back')->name('wooppay.back');
    });
});

Route::controller(NotificationController::class)->group(function() {
    Route::prefix('notification')->group(function() {
        Route::get('getByUserId/{userId}','getByUserId')->name('notification.getByUserId');
        Route::get('firstById/{id}','firstById')->name('notification.firstById');
    });
});

Route::controller(PaymentController::class)->group(function() {
    Route::prefix('payment')->group(function() {
        Route::get('get','get')->name('payment.get');
    });
});

Route::controller(PriceController::class)->group(function() {
    Route::prefix('price')->group(function() {
        Route::get('get','get')->name('price.get');
    });
});
