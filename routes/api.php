<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\StreamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/email/resend/token', [AuthController::class, 'resendPIN']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/verify-pin', [ForgotPasswordController::class, 'verifyPin']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/email/verify', [AuthController::class, 'verifyEmail']);
    Route::get('/logout', [AuthController::class, 'logout']);


    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/messages', [ChatController::class, 'message']);
    Route::post('/view-messages', [ChatController::class, 'view']);
    Route::post('/send-message', [ChatController::class, 'send']);

    Route::post('/start-stream', [StreamController::class, 'start']);
    Route::post('/stop-stream', [StreamController::class, 'stop']);
});

Route::get('/service-worker', [AuthController::class, 'serviceworker']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/create_booking', [AuthController::class, 'create']);
    Route::get('/all_pricing', [AuthController::class, 'index']);
    Route::get('/get_price/{id}', [AuthController::class, 'byId']);
});
