<?php

use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('switchLang/{locale}', [App\Http\Controllers\Admin\HomeController::class, 'lang'])->name('lang');
Route::post('getAjaxDataUrl', [App\Http\Controllers\Admin\AjaxController::class, 'getAjaxDataUrl'])->name('getAjaxDataUrl');

Route::get('/test-prayer-times-job', function () {
    dispatch(new \App\Jobs\FetchPrayerTimes());
    return 'Job dispatched successfully!';
});
Auth::routes(['verify' => true]);

Route::get('login', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [CustomAuthController::class, 'login']);
Route::get('logout', [CustomAuthController::class, 'logout'])->name('logout');
Route::get('authorize/callback', [HomeController::class, 'authNafath'])->name('authorize.callback');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'permissions', 'update_user_last_active']], function () {
    // Home route
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'root'])->name('root');
    // Open season route
    Route::get('open-season-now', [App\Http\Controllers\Admin\RetreatSeasonController::class, 'openSeasonNow'])->name('open_season_now');
    Route::post('schaduale-season', [App\Http\Controllers\Admin\RetreatSeasonController::class, 'schadualeSeason'])->name('schaduale_season');
    // Close season route
    Route::get('close_season', [App\Http\Controllers\Admin\RetreatSeasonController::class, 'closeSeason'])->name('close_season');
    Route::post('schaduale-close-season', [App\Http\Controllers\Admin\RetreatSeasonController::class, 'schadualeCloseSeason'])->name('schaduale_close_season');
    // Retreat Requests route
    Route::get('retreat-requests', [App\Http\Controllers\Admin\RetreatRequestController::class, 'index'])->name('retreat_requests.index');
    Route::get('retreat-requests-export', [App\Http\Controllers\Admin\RetreatRequestController::class, 'export'])->name('retreat-requests.export');
    Route::get('retreat-requests/{id}', [App\Http\Controllers\Admin\RetreatRequestController::class, 'show'])->name('retreat_requests.show');
    Route::post('retreat-accept/{id}', [App\Http\Controllers\Admin\RetreatRequestController::class, 'accept'])->name('retreat_requests.accept');
    Route::post('retreat-reject/{id}', [App\Http\Controllers\Admin\RetreatRequestController::class, 'reject'])->name('retreat_requests.reject');
    Route::post('retreat-requests/reject', [App\Http\Controllers\Admin\RetreatRequestController::class, 'rejectRequests'])->name('retreat-requests.reject');
    Route::post('retreat-requests/accept', [App\Http\Controllers\Admin\RetreatRequestController::class, 'acceptRequests'])->name('retreat-requests.accept');
    // translations route
    Route::group(['prefix' => 'translations'], function () {
        Route::any('/edit/{lang?}', [App\Http\Controllers\Admin\TranslationController::class, 'edit'])->name('translations.edit');
    });
    // Countries route
    Route::resource('countries', CountriesController::class);
    Route::get('countries-export', [CountriesController::class, 'export'])->name('countries.export');
    // Retreat Mosques route
    Route::resource('retreat-mosques', App\Http\Controllers\Admin\RetreatMosqueController::class);
    Route::get('retreat-mosques-export', [App\Http\Controllers\Admin\RetreatMosqueController::class, 'export'])->name('retreat-mosques.export');
    // Retreat Mosque Locations route
    Route::resource('retreat-mosque-locations', App\Http\Controllers\Admin\RetreatMosqueLocationController::class);
    Route::get('retreat-mosque-locations-export', [App\Http\Controllers\Admin\RetreatMosqueLocationController::class, 'export'])->name('retreat-mosque-locations.export');
    // Retreat Instructions route
    Route::resource('retreat-instructions', App\Http\Controllers\Admin\RetreatInstructionController::class);
    Route::get('retreat-instructions-export', [App\Http\Controllers\Admin\RetreatInstructionController::class, 'export'])->name('retreat-instructions.export');
    // Retreat Service Categories route
    Route::resource('retreat-service-categories', App\Http\Controllers\Admin\RetreatServiceCategoryController::class);
    Route::get('retreat-service-categories-export', [App\Http\Controllers\Admin\RetreatServiceCategoryController::class, 'export'])->name('retreat-service-categories.export');
    // Retreat Services route
    Route::resource('retreat-services', App\Http\Controllers\Admin\RetreatServiceController::class);
    Route::get('retreat-services-export', [App\Http\Controllers\Admin\RetreatServiceController::class, 'export'])->name('retreat-services.export');
    // Employees route
    Route::resource('employees', App\Http\Controllers\Admin\EmployeeController::class);
    Route::post('employees/switch-status/{id}', [App\Http\Controllers\Admin\EmployeeController::class, 'switchStatus'])->name('employees.switch-status');
    Route::get('employees-export', [EmployeeController::class, 'export'])->name('employees.export');
    // Admins route
    Route::resource('admins', App\Http\Controllers\Admin\AdminController::class);
    Route::post('admins/switch-status/{id}', [App\Http\Controllers\Admin\AdminController::class, 'switchStatus'])->name('admins.switch-status');
    Route::get('admins-profile', [App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('admins.profile');
    Route::put('admins-update-profile', [App\Http\Controllers\Admin\AdminController::class, 'updateProfile'])->name('admins.update-profile');
    // Users route
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('users-export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
    Route::post('users/switch-status/{id}', [App\Http\Controllers\Admin\UserController::class, 'switchStatus'])->name('users.switch-status');
    // Retreat Service Requests
    Route::resource('retreat-service-requests', App\Http\Controllers\Admin\RetreatServiceRequestController::class);
    Route::get('retreat-service-requests-export', [App\Http\Controllers\Admin\RetreatServiceRequestController::class, 'export'])->name('retreat-service-requests.export');
    Route::post('retreat-service-requests/reassign/{id}', [App\Http\Controllers\Admin\RetreatServiceRequestController::class, 'reassign'])->name('retreat-service-requests.reassign');
    Route::get('retreat-service-requests/accept/{id}', [App\Http\Controllers\Admin\RetreatServiceRequestController::class, 'accept'])->name('retreat-service-requests.accept');
    Route::post('retreat-service-requests/reject', [App\Http\Controllers\Admin\RetreatServiceRequestController::class, 'rejectRequests'])->name('retreat-service-requests.rejects');
    Route::post('retreat-service-requests/accept', [App\Http\Controllers\Admin\RetreatServiceRequestController::class, 'acceptRequests'])->name('retreat-service-requests.accepts');
    // Pages
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class)->except(['show', 'create', 'store', 'destroy']);
    Route::get('pages-export', [App\Http\Controllers\Admin\PageController::class, 'export'])->name('pages.export');
    // Surveys
    Route::resource('surveys', App\Http\Controllers\Admin\SurveyController::class);
    Route::post('surveys/switch-status/{id}', [App\Http\Controllers\Admin\SurveyController::class, 'switchStatus'])->name('surveys.switch-status');
    Route::get('surveys/retreat-rate-questions/{surveyId}/{userId}', [App\Http\Controllers\Admin\SurveyController::class, 'userSurveyQuestions'])->name('retreat-rate-questions.show');
    Route::get('surveys-export', [App\Http\Controllers\Admin\SurveyController::class, 'export'])->name('surveys.export');
    // on boarding screen
    Route::resource('on-boarding-screen', App\Http\Controllers\Admin\OnboardingScreenController::class)->names('on-boarding-screens');
    Route::get('on-boarding-screens-export', [App\Http\Controllers\Admin\OnboardingScreenController::class, 'export'])->name('on-boarding-screens.export');
    // Notifications
    Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications-all', [App\Http\Controllers\Admin\NotificationController::class, 'index_all'])->name('notifications.index_all');
    Route::post('notifications/mark-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    // Reasons
    Route::resource('reasons', App\Http\Controllers\Admin\ReasonController::class);
    Route::get('reasons-export', [App\Http\Controllers\Admin\ReasonController::class, 'export'])->name('reasons.export');
    // delete reasons
    Route::resource('delete-reasons', App\Http\Controllers\Admin\DeleteReasonController::class);
    Route::get('delete-reasons-export', [App\Http\Controllers\Admin\DeleteReasonController::class, 'export'])->name('delete-reasons.export');
    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
    // Chat
    Route::get('chat', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{userId}', [App\Http\Controllers\Admin\ChatController::class, 'getChat'])->name('chat.get');
    Route::post('/chat/save', [App\Http\Controllers\Admin\ChatController::class, 'save'])->name('chat.save');
    // Rates
    Route::get('rates', [App\Http\Controllers\Admin\RateController::class, 'index'])->name('rates.index');
});
