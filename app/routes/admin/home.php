<?php
use App\Http\Controllers\admin\home\bannerController;
use App\Http\Controllers\admin\home\contentController;
use App\Http\Controllers\admin\home\galleryController;

Route::group(['prefix' => 'banner'], function () {
    Route::controller(bannerController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/upload', 'create');
        Route::get('/edit/{TranNo}', 'edit');
        Route::post('/upload', 'save');
        Route::POST('/edit/{TranNo}', 'update');
        Route::POST('/delete/{TranNo}', 'Delete');
    });
});

Route::group(['prefix' => 'gallery'], function () {
    Route::controller(galleryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/upload', 'create');
        Route::get('/edit/{ID}', 'edit');
        Route::post('/upload', 'save');
        Route::POST('/edit/{ID}', 'update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');

        Route::get('/get-gallery-name', 'getGalleryName');
        Route::get('/deleted', 'deleted');

    });
});

Route::group(['prefix' => 'content'], function () {
    Route::controller(contentController::class)->group(function () {
        Route::get('/', 'index')->name('admin-home-content-view');
        Route::get('/create', 'create');
        // Route::get('/edit/{CID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/update', 'Update');
        Route::post('/image-update', 'ImageUpdate');
        Route::post('/delete/{CID}', 'Delete');
        Route::post('/restore/{CID}', 'Restore');

        Route::post('/get/section-names', 'getSectionNames');

        Route::get('/edit/{slug}', 'EditView');

    });
});
