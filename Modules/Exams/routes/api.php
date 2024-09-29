<?php

use Illuminate\Support\Facades\Route;
use Modules\Exams\Http\Controllers\ExamsController;
use Modules\Exams\Http\Controllers\AssignmentController;
use Modules\Exams\Http\Controllers\EvaluationController;

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

Route::apiResource('assignments', AssignmentController::class);

Route::get('assignments/{id}/download', [AssignmentController::class, 'download']);
Route::post('assignments/{id}/upload', [AssignmentController::class, 'upload']);


Route::get('/evaluations', [EvaluationController::class, 'index']);
Route::get('/evaluations/{$id}', [EvaluationController::class, 'show']);
