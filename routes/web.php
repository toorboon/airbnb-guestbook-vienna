<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'PageController@index')->name('index');
Route::get('/legal', 'PageController@legal')->name('legal')->middleware('can:create-guest');

Route::get('/guests/export', 'GuestController@export')->name('guests.export')->middleware('can:manage-app');
Route::resource('/guests', 'GuestController')->only(['create','store','index', 'show'])->middleware('can:create-guest');

Route::middleware('can:manage-app')->group(function() {
    Route::get('/about', 'PageController@about')->name('about');

    Route::resource('/guests', 'GuestController')->except(['create', 'store','index','show']);

    Route::put('/invite/{userId}', 'Auth\RegisterController@invite')->name('invite');

    Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
        Route::put('/users/assignRole/{userId?}', 'UsersController@assignRole')->name('users.assignRole');
        Route::put('/users/assignAccommodation/{userId?}', 'UsersController@assignAccommodation')->name('users.assignAccommodation');
        Route::resource('/users', 'UsersController')->only(['update', 'destroy']);
        Route::resource('/accommodations', 'AccommodationsController')->except(['index', 'edit', 'show']);
    });
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard')->prefix('admin');

});

Auth::routes();

