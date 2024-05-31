<?php
use App\Http\Controllers\admin\enquiry\ServiceEnquiryController;
use App\Http\Controllers\admin\enquiry\ContactEnquiryController;

Route::group(['prefix'=>'service'],function (){
    Route::controller(ServiceEnquiryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/restore', 'restoreView');


        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/delete/{TranNo}', 'Delete');
        Route::post('/restore/{TranNo}', 'Restore');

        Route::post('/details/{TranNo}', 'getDetails');

        Route::post('/get/services', 'getServices');
    });
});




Route::group(['prefix'=>'contact-us'],function (){
    Route::controller(ContactEnquiryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/restore', 'restoreView');


        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/delete/{CID}', 'Delete');
        Route::post('/restore/{CID}', 'Restore');
        
        Route::post('/details/{TranNo}', 'getDetails');
    });
});