<?php
use App\Http\Controllers\admin\master\faqController;
use App\Http\Controllers\admin\master\taxController;
use App\Http\Controllers\admin\master\uomController;
use App\Http\Controllers\admin\master\clientsController;
use App\Http\Controllers\admin\master\galleryController;
use App\Http\Controllers\admin\master\serviceController;
use App\Http\Controllers\admin\master\categoryController;
use App\Http\Controllers\admin\master\projectsController;
use App\Http\Controllers\admin\master\projectTypeController;
use App\Http\Controllers\admin\master\youtubeVideoController;

Route::group(['prefix' => 'category'], function () {
    Route::controller(categoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{CID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{CID}', 'update');
        Route::post('/delete/{CID}', 'Delete');
        Route::post('/restore/{CID}', 'Restore');
    });
});

Route::group(['prefix' => 'faq'], function () {
    Route::controller(faqController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{ID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{ID}', 'update');
        Route::post('/delete/{ID}', 'Delete');
        Route::post('/restore/{ID}', 'Restore');
    });
});


Route::group(['prefix' => 'youtube-video'], function () {
    Route::controller(youtubeVideoController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{ID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{ID}', 'update');
        Route::post('/delete/{ID}', 'Delete');
        Route::post('/restore/{ID}', 'Restore');
    });
});


Route::group(['prefix' => 'project-type'], function () {
    Route::controller(projectTypeController::class)->group(function () {
         Route::get('/', 'index');
        Route::get('/create', 'Create');
        Route::get('/edit/{PID}', 'Edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{PID}', 'update');
        Route::post('/delete/{PID}', 'Delete');
        Route::post('/restore/{PID}', 'Restore');
    });
});


Route::group(['prefix' => 'tax'], function () {
    Route::controller(taxController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{TaxID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{TaxID}', 'update');
        Route::post('/delete/{TaxID}', 'Delete');
        Route::post('/restore/{TaxID}', 'Restore');
    });
});

Route::group(['prefix' => 'unit-of-measurement'], function () {
    Route::controller(uomController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{UID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{UID}', 'update');
        Route::post('/delete/{UID}', 'Delete');
        Route::post('/restore/{UID}', 'Restore');
    });
});

Route::group(['prefix' => 'services'], function () {
    Route::controller(serviceController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{serviceID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{serviceID}', 'update');
        Route::post('/delete/{serviceID}', 'Delete');
        Route::post('/restore/{serviceID}', 'Restore');

        Route::post('/get/category', 'getCategory');

        Route::post('/get/tax', 'getTax');
        Route::post('/get/uom', 'getUOM');

        Route::post('/check/service-name', 'checkServiceName');
        Route::post('/check/slug', 'checkSlug');
    });
});

Route::group(['prefix' => 'clients'], function () {
     Route::controller(clientsController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{clientID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'Save');
        Route::post('/edit/{clientID}', 'Update');

        Route::post('/delete/{clientID}', 'Delete');
        Route::post('/restore/{clientID}', 'Restore');

        Route::post('/get/project-type', 'getProjectType');

        Route::post('/get/tax', 'getTax');
        Route::post('/get/uom', 'getUOM');

        Route::post('/check/project-name', 'checkProjectName');
        Route::post('/check/slug', 'checkSlug');
      
    });
});


Route::group(['prefix' => 'projects'], function () {
    Route::controller(projectsController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{projectID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{projectID}', 'update');
        Route::post('/delete/{projectID}', 'Delete');
        Route::post('/restore/{projectID}', 'Restore');

        Route::post('/get/category', 'getCategory');

        Route::post('/get/tax', 'getTax');
        Route::post('/get/uom', 'getUOM');
        Route::post('/getclients', 'getClients');
        Route::post('/get-project-type', 'getProjectType');
        
        Route::post('/check/project-name', 'checkProjectName');
        Route::post('/check/slug', 'checkSlug');
    });
});

Route::group(['prefix' => 'gallery'], function () {
    Route::controller(galleryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{GalleryID}', 'edit');
        Route::get('/restore', 'restoreView');

        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'Save');
        Route::post('/edit/{GalleryID}', 'Update');
        Route::post('/delete/{GalleryID}', 'Delete');
        Route::post('/restore/{GalleryID}', 'Restore');

        Route::post('/get/category', 'getCategory');

        Route::post('/check/gallery-name', 'checkGalleryName');
        Route::post('/check/slug', 'checkSlug');
    });
});