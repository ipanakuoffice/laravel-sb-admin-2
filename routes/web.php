<?php

use App\Http\Controllers\InputPemeriksaanController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiwayatPemeriksaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::prefix('user-management')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('', 'UserManagementRoleController@index')->name('userManagementRole.index');
    });
    Route::prefix('permission')->group(function () {
        Route::get('', 'UserManagementPermissionController@index')->name('userManagementPermission.index');
        Route::get('getData', 'UserManagementPermissionController@getData')->name('userManagementUser.getData');
    });
    Route::prefix('user')->group(function () {
        Route::get('', 'UserManagementUserController@index')->name('userManagementUser.index');
        Route::get('getData', 'UserManagementUserController@getData')->name('userManagementUser.getData');
    });
});

Route::prefix('examination')->group(function () {
    Route::get('', 'ExaminationController@index')->name('Examination.index');
    Route::get('getData', 'ExaminationController@getData')->name('Examination.getData');
    Route::get('getDataModalitas', 'ExaminationController@getDataModalitas')->name('Examination.getDataModalitas');
    Route::get('getDataDoseIndicators', 'ExaminationController@getDataDoseIndicators')->name('Examination.getDataDoseIndicators');
    Route::post('addExamination', 'ExaminationController@addExamination')->name('Examination.addExamination');
    Route::get('editExamination/{examinationId}', 'ExaminationController@editExamination')->name('Examination.editExamination');
    Route::put('updateExamination/{examinationId}', 'ExaminationController@updateExamination')->name('Examination.updateExamination');
    Route::delete('deletePatient/{examinationId', 'ExaminationController@deleteExamination')->name('Examination.deleteExamination');
});

Route::prefix('patients')->group(function () {
    Route::get('', 'PatientController@index')->name('Patient.index');
    Route::get('getData', 'PatientController@getData')->name('Patient.getData');
    Route::post('addPatient', 'PatientController@addPatient')->name('Patient.addPatient');
    Route::get('editPatient/{patientId}', 'PatientController@editPatient')->name('Patient.editPatient');
    Route::put('updatePatient/{patientId}', 'PatientController@updatePatient')->name('Patient.updatePatient');
    Route::delete('deletePatient/{id}', 'PatientController@deletePatient')->name('Patient.deletePatient');
});

Route::prefix('input-pemeriksaan')->group(function () {
    Route::resource('input-pemeriksaan', InputPemeriksaanController::class);
});


Route::prefix('riwayat-pemeriksaan')->group(function () {
    Route::get('', 'RiwayatPemeriksaanController@index')->name('RiwayatPemeriksaan.index');
});

Route::prefix('examinationHistory')->group(function () {
    Route::get('', 'examinationHistoryController@index')->name('examinationHistory.index');
    Route::get('getData', 'examinationHistoryController@getData')->name('examinationHistory.getData');
    Route::delete('deletePatient/{id}', 'PatientController@deletePatient')->name('examinationHistory.deletePatient');
});

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});


Route::get('/chart', [RiwayatPemeriksaanController::class, 'showChart']);
