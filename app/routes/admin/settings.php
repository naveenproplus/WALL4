<?php

use App\Http\Controllers\admin\settings\CMSController;
use App\Http\Controllers\admin\settings\generalSettingsController;
use App\Http\Controllers\admin\settings\CompanySettingsController;
use App\Http\Controllers\admin\settings\mapSettingsController;

Route::group(['prefix'=>'cms'],function (){
    Route::controller(CMSController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/edit/{ID}', 'edit');


        Route::post('/data', 'TableView');
        Route::Post('/edit/{ID}', 'Update');
    });
});

Route::group(['prefix'=>'general'],function (){
    Route::controller(generalSettingsController::class)->group(function () {
        Route::get('/', 'index');
        Route::Post('/', 'Update');
    });
});
Route::group(['prefix'=>'company'],function (){
    Route::controller(CompanySettingsController::class)->group(function () {
        Route::get('/', 'index');
        Route::Post('/', 'Update');
    });
});