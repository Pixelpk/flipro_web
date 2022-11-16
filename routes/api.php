<?php

use App\Http\Controllers\Api\AuthenticationsController;
use App\Http\Controllers\Api\EventLogController;
use App\Http\Controllers\Api\GalleriesController;
use App\Http\Controllers\Api\NotesController;
use App\Http\Controllers\Api\PaymentActionsController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\ProjectActionsController;
use App\Http\Controllers\Api\ProjectReviewsController;
use App\Http\Controllers\Api\ProjectRolesController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\RegistrationsController;
use App\Http\Controllers\Api\UserProfilesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\ProjectValuesController;
use App\Libs\Firebase\Firebase;
use App\Models\Project;
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

Route::post('authenticate', [AuthenticationsController::class, 'authenticate']);
Route::post('forgot', [UserProfilesController::class, 'sendResetEmail']);
Route::patch('forgot', [UserProfilesController::class, 'resetPassword']);
Route::get('forgot', [UserProfilesController::class, 'verifyOtp']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users', [UsersController::class, 'get']);
    Route::post('users', [RegistrationsController::class, 'create']);
    Route::patch('users', [RegistrationsController::class, 'update']);
    Route::get('projects', [ProjectsController::class, 'list']);
    Route::post('projects', [ProjectsController::class, 'create']);
    Route::post('projects/search', [ProjectsController::class, 'search']);
    Route::patch('projects', [ProjectsController::class, 'update']);
    Route::patch('projects/approve', [ProjectsController::class, 'approve']);
    Route::post('projects/progress', [ProjectActionsController::class, 'uploadProgress']);
    Route::get('projects/progress', [ProjectActionsController::class, 'get']);
    Route::post('galleries', [GalleriesController::class, 'create']);
    Route::get('accesses', [ProjectRolesController::class, 'get']);
    Route::post('accesses', [ProjectRolesController::class, 'update']);
    Route::get('notes', [NotesController::class, 'list']);
    Route::get('event/log', [EventLogController::class, 'list']);
    Route::post('notes', [NotesController::class, 'create']);
    Route::patch('notes', [NotesController::class, 'update']);
    Route::delete('notes', [NotesController::class, 'delete']);
    Route::get('payment-requests', [PaymentsController::class, 'list']);
    Route::patch('payment-requests', [PaymentActionsController::class, 'update']);
    Route::post('payment-requests', [PaymentActionsController::class, 'create']);
    Route::patch('profile', [UserProfilesController::class, 'update']);
    Route::patch('password', [UserProfilesController::class, 'changePassword']);
    Route::post('logout', [UserProfilesController::class, 'logout']);
    Route::post('projects/value', [ProjectValuesController::class, 'create']);
    Route::post('projects/value/review', [ProjectValuesController::class, 'addReview']);
    Route::post('projects/progress/review', [ProjectReviewsController::class, 'addReview']);
});
Route::get('test/fcm', function () {
    return Project::first()->partTakerFcmTokens();
    // $fcm = new Firebase();
    // $fcm->setTitle('test');
    // $fcm->setBody('test');
    // $fcm->setToTokens('exYigL2bT-afS4D0WXdcPJ:APA91bH6JUgGxdET4ypbUeaaPGmUb6w3_6_i7hX2N5Uwr_f9pcj_1epVBhig3kB83XsbdilNbHUO7KBLhNxQgSiRwiMInpvJEvSUVfqvPfEjjVvz5jcGLNn0MX3ObfaLRXET7gwAh_g2');
    // return $fcm->send();
});
