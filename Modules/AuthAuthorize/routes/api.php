<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthAuthorize\Http\Controllers\AuthAuthorizeController;
use  Modules\AuthAuthorize\Http\Controllers\Admin\RoleAndPermissionController;
use  Modules\AuthAuthorize\Http\Controllers\Auth\LoginController;
use  Modules\AuthAuthorize\Http\Controllers\Auth\RegisterController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [LoginController::class, 'logout']);
    });

    Route::post('/confirm-2FA-code', [LoginController::class, 'confirmTwoFactorCode']);
    Route::post('/re-send-2FA-code', [LoginController::class, 'resendTwoFactorCode']);
    Route::post('/confirm-email-vf-code/{user}', [RegisterController::class, 'confirmEmailVerificationCode'])->name('api.confirm-email-vf-code');
    Route::post('/re-send-email-vf-code', [RegisterController::class, 'resendEmailVerificationCode']);
    Route::get('/refresh-token', [LoginController::class, 'refreshToken'])->middleware('auth:sanctum');
});


Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::Resource('authauthorize', RoleAndPermissionController::class)->names('authauthorize');
});
