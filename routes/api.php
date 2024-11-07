<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExaminationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route untuk login
Route::post('/login', [AuthController::class, 'login']);

// Route group untuk Examination
Route::middleware('auth:api')->prefix('examination')->group(function () {
    Route::get('getData', 'ExaminationController@getData')->name('Examination.getData');
    Route::get('getDataModalitas', 'ExaminationController@getDataModalitas')->name('Examination.getDataModalitas');
    Route::get('getDataDoseIndicators', 'ExaminationController@getDataDoseIndicators')->name('Examination.getDataDoseIndicators');
    Route::post('addExamination', [ExaminationController::class, 'addExamination'])->name('Examination.addExamination');
    Route::get('editExamination/{examinationId}', 'ExaminationController@editExamination')->name('Examination.editExamination');
    Route::put('updateExamination/{examinationId}', 'ExaminationController@updateExamination')->name('Examination.updateExamination');
    Route::delete('deletePatient/{examinationId}', 'ExaminationController@deleteExamination')->name('Examination.deleteExamination');
});
