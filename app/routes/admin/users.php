<?php

use App\Http\Controllers\admin\users\employeesController;
use App\Http\Controllers\admin\users\userRoleController;
use App\Http\Controllers\admin\users\PasswordChangeController;
use App\Http\Controllers\admin\users\profilecontroller;

//user roles
Route::group(['prefix'=>'user-roles'],function (){
    Route::controller(userRoleController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/view', 'index');
        Route::post('/data', 'TableView');
        Route::get('/create', 'Create');
        Route::get('/edit/{RoleID}', 'Edit');
        Route::POST('/json/{RoleID}', 'RoleData');
        Route::post('/create', 'Save');
        Route::POST('/edit/{RoleID}', 'Update');
    });
});
Route::group(['prefix'=>'employees'],function (){
    Route::controller(employeesController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/view', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{UserID}', 'edit');
        Route::get('/restore', 'restoreView');


        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{UserID}', 'update');
        Route::post('/delete/{UserID}', 'Delete');
        Route::post('/restore/{UserID}', 'Restore');

        Route::post('/get/user-roles', 'getUserRoles');
        Route::post('/get/designation', 'getDesignation');
        Route::post('/get/password', 'getPassword');
    });
});
Route::controller(PasswordChangeController::class)->group(function () {
    Route::get('/change-password', 'PasswordChange');
    Route::post('/change-password', 'Update_Password');
});
Route::controller(profilecontroller::class)->group(function () {
    Route::get('/profile','Profile');
    Route::get('/UpdateProfile','UpdateProfile');
    Route::post('/profileupdate','ProfileUpdate');
});