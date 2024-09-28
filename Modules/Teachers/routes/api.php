<?php

use Illuminate\Support\Facades\Route;
use Modules\Teachers\Http\Controllers\TeachersController;
use Modules\Teachers\Http\Controllers\TeacherController;

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
    Route::apiResource('teachers', TeachersController::class)->names('teachers');
});


Route::post('/teachers/{teacher}/subjects/{subject}/resources', [TeacherController::class, 'addResourceToSubject']);
Route::put('/teachers/{teacher}/subjects/{subject}/resources/{resource}', [TeacherController::class, 'updateResource']);
Route::delete('/teachers/{teacher}/subjects/{subject}/resources/{resource}', [TeacherController::class, 'deleteResource']);
