<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    });
    Route::prefix('user')->group(function () {
        Route::get('', 'UserManagementUserController@index')->name('userManagementUser.index');
    });
});
