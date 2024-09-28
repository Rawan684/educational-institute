<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

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
    Route::apiResource('students', StudentsController::class)->names('students');
});

Route::post('/students/register', 'Modules\Students\Http\Controllers\StudentController@register');

Route::group(['prefix' => 'attendances'], function () {
    Route::post('/mark', 'Modules\Students\Http\Controllers\AttendanceController@markAttendance')->name('attendances.mark');
    Route::get('/{enrollment_id}/{attendance_date}', 'Modules\Students\Http\Controllers\AttendanceController@getAttendances')->name('enrollments.attendances.index');
    Route::get('/report/{enrollment_id}/{start_date}/{end_date}', 'Modules\Students\Http\Controllers\AttendanceController@getAttendanceReport')->name('attendances.report');
});
