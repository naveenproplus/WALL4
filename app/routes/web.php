<?php
use App\Http\Controllers\admin\loginController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\supportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});
Route::controller(homeController::class)->group(function () {
    Route::get('/', 'HomeView');
    Route::get('/home', 'HomeView');
    Route::get('/about-us', 'AboutUsView');
    Route::get('/faq', 'FAQView');
    Route::get('/projects', 'ProjectsView');
    Route::get('/projects/{Slug}', 'ProjectDetailsView');
    Route::get('/get/faq', 'getFaq');
    Route::get('/services/{Slug}', 'ServicesDetailsView');
    Route::get('/terms-and-conditions', 'TermsAndConditionsView');
    Route::get('/privacy-policy', 'PrivacyPolicyView');
    Route::get('/help', 'help');
    Route::get('/teams', 'TeamsView');
    Route::get('/services', 'ServicesView');
    Route::get('/contact-us', 'ContactUsView');

    Route::post('/get/service-enquiry-form', 'getServiceEnquiryForm');
    Route::post('/get/clients', 'getClientsList');
    Route::post('/get/links', 'getLinks');
    Route::post('/get/services', 'getServicesList');
    Route::post('/get/projects', 'getProjectsList');
    Route::post('/save/service-enquiry', 'ServiceEnquirySave');
    Route::post('/save/contact-enquiry', 'ContactEnquirySave');

});
Route::controller(supportController::class)->group(function () {
    Route::post('/get/country', 'GetCountry');
    Route::post('/get/states', 'GetState');
    Route::post('/get/gender', 'GetGender');
    Route::post('/get/city', 'GetCity');
    Route::post('/get/postal-code', 'getPostalCode');
});

Route::controller(loginController::class)->group(function () {
    Route::post('/auth/login', 'login');
});
require __DIR__ . '/auth.php';
Route::group(['prefix' => 'admin'], function () {
    Route::middleware('auth')->group(function () {
        require __DIR__ . '/admin/admin.php';
    });
});
