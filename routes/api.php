<?php

use App\Http\Controllers\Api\AppHomeController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\RetreatRequestController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('countries', CountryController::class . '@index');
Route::post('register', UserController::class . '@create');
Route::post('activate', UserController::class . '@activate');
Route::post('login', UserController::class . '@login');
Route::post('forgot-password', UserController::class . '@forgotPassword');
Route::post('check-verification-code', UserController::class . '@checkVerificationCode');
Route::post('reset-password', UserController::class . '@resetPassword');
Route::post('resend-verification-code', UserController::class . '@resendVerificationCode');
Route::get('onboarding-screens', AppHomeController::class . '@OnboardingScreens');
Route::get('nafath/callback', AppHomeController::class . '@nafathCallback')->name('nafath.callback');
Route::any('nafath/validate', AppHomeController::class . '@validateNafath');

// Auth routes
Route::middleware(['auth:sanctum', 'update_user_last_active'])->group(function () {
    // User routes
    Route::put('update-profile', UserController::class . '@update');
    Route::post('delete-account', UserController::class . '@delete');
    Route::get('profile', UserController::class . '@show');
    Route::post('update-password', UserController::class . '@updatePassword');
    Route::post('logout', UserController::class . '@logout');
    Route::post('switch-notification-settings', UserController::class . '@switchNotificationSettings');
    Route::get('get-delete-reasons', UserController::class . '@getDeleteReasons');
    // Notification routes
    Route::get('notifications', NotificationController::class . '@index');
    Route::get('notifications-count', NotificationController::class . '@getNotificationsCount');
    Route::get('unread-notifications-count', NotificationController::class . '@getUnreadNotificationsCount');
    Route::post('mark-as-read', NotificationController::class . '@markAsRead');
    // App home routes
    Route::get('home', AppHomeController::class . '@index');
    Route::get('employee-index', AppHomeController::class . '@employeeIndex');
    Route::get('prayers', AppHomeController::class . '@prayers');
    Route::get('retreat-services', AppHomeController::class . '@retreatServices');
    Route::get('retreat-instructions', AppHomeController::class . '@retreatInstructions');
    Route::get('support-services', AppHomeController::class . '@supportServices');
    Route::get('in-retreat-services', AppHomeController::class . '@inRetreatServices');
    // Retreat request routes
    Route::post('retreat-request', RetreatRequestController::class . '@create');
    Route::get('retreat-mosques', RetreatRequestController::class . '@getRetreatMosques');
    Route::get('retreat-mosque-locations', RetreatRequestController::class . '@getRetreatMosqueLocations');
    Route::post('retreat-request-status-change/{retreatRequest}', RetreatRequestController::class . '@changeRequestStatus');
    Route::get('current-retreat-season', RetreatRequestController::class . '@getCurrentRetreatSeason');
    Route::post('retreat-request-services', RetreatRequestController::class . '@requestRetreatServices');
    Route::get('retreat-request-location', RetreatRequestController::class . '@getRetreatRequestLocation');
    // Rate routes
    Route::post('rate', RateController::class . '@rate');
    Route::get('retreat-surveys', RateController::class . '@getSurveys');
    Route::get('retreat-survey', RateController::class . '@getSurvey');
    Route::post('retreat-survey/{retreatSurvey}', RateController::class . '@createSurvey');
    // Page routes
    Route::get('pages', PageController::class . '@index');
    Route::get('page-slug/{slug}', PageController::class . '@getPageBySlug');
    Route::get('page/{page}', PageController::class . '@show');
    //Chat routes
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::get('/chat', [ChatController::class, 'getChatBetweenUsers']);
    Route::post('/chat/{chatId}/mark-as-read', [ChatController::class, 'markAsRead']);
    Route::get('/chat/unread/{userId}', [ChatController::class, 'getUnreadMessages']);
    Route::get('/chat/group', [ChatController::class, 'getGroupedChats']);
    // Qr code
    Route::get('qr-code', RetreatRequestController::class . '@getQrCode');
    Route::post('check-qr-code', RetreatRequestController::class . '@checkQrCode');
    // Rate Question
    Route::get('rate-question', AppHomeController::class . '@getRateQuestion');
});
Route::middleware(['auth:sanctum', 'is_employee', 'update_user_last_active'])->group(function () {
    // Employee routes
    Route::get('retreat-request-services', AppHomeController::class . '@retreatRequestServices');
    Route::post('change-request-service-status/{retreatRequestServiceModel}', RetreatRequestController::class . '@changeRequestServiceStatus');
    Route::get('retreat-request-service/{retreatRequestServiceModel}', AppHomeController::class . '@getRetreatRequestService');
});
