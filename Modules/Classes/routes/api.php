<?php

use Illuminate\Support\Facades\Route;
use Modules\Classes\Http\Controllers\ClassesController;
use Modules\Classes\Http\Controllers\GradeController;
use Modules\Classes\Http\Middleware\Authenticate;
use Modules\Classes\Http\Middleware\Authorize;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('classes', ClassesController::class)->names('classes');
});

Route::apiResource('classes', GradeController::class)->middleware([Authenticate::class, Authorize::class]);
