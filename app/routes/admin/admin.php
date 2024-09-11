<?php
use App\Http\Controllers\admin\generalController;
use App\Http\Controllers\admin\dashboardController;

Route::controller(generalController::class)->group(function () {
    Route::post('/Set/Theme/Update','ThemeUpdate');
    Route::post('/get/menus','getMenus');
    Route::post('/get/menus-data','getMenuData');
    Route::post('/get/role','RoleData');
    Route::post('/tmp/upload-image','tmpUploadImage');
    Route::get('/get/csrf-token','getCSRFToken');
    Route::POST('/ckeditor/upload-image','uploadImageCKEditor');
    Route::post('/temp/upload', 'tempUpload')->name('temp.upload');
});

Route::controller(dashboardController::class)->group(function () {
    Route::get('/', 'dashboard');
    Route::get('/dashboard','dashboard');

    Route::POST('/dashboard/get/service-enquiry-chart','getGraphicalServiceEnquiry');
});
Route::group(['prefix'=>'master'],function (){
    require __DIR__.'/master.php';
});
Route::group(['prefix'=>'enquiry'],function (){
    require __DIR__.'/enquiry.php';
});
Route::group(['prefix'=>'home'],function (){
    require __DIR__.'/home.php';
});
Route::group(['prefix'=>'settings'],function (){
    require __DIR__.'/settings.php';
});
Route::group(['prefix'=>'users-and-permissions'],function (){
    require __DIR__.'/users.php';
});
