<?php

use Illuminate\Support\Facades\Route;
use Modules\Exams\Http\Controllers\ExamsController;

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
    Route::apiResource('exams', ExamsController::class)->names('exams');
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/exams', [ExamsController::class, 'publishExam']);
    Route::get('/exams/{exam}/questions', [ExamsController::class, 'getExamQuestions']);
    Route::post('/exams/{exam}/submit', [ExamsController::class, 'submitExamAnswers']);
    Route::get('/exams/{exam}/results', [ExamsController::class, 'getExamResults']);
});
