<?php

use Illuminate\Support\Facades\Route;

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

// Welcome and Home Pages
Route::get('/', 'HomeController@index')->name('dashboard')->middleware('role:Admin,NL');

Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('role:Admin,NL');

// Route::get('/home', 'HomeController@user_dashboard')->name('home')->middleware('auth');


// Settings
Route::resource('settings', 'SettingsController');
Route::get('edit_settings/{id}', 'SettingsController@edit')->name('edit_settings');

// Facilities
Route::resource('facilities', 'FacilitiesController');
Route::get('add_facility', 'FacilitiesController@create')->name('add_facility');
Route::get('facility/{id}', 'FacilitiesController@edit');

// Audits
Route::resource('audits', 'AuditController');

// Categories
Route::resource('categories', 'CategoryController');

// ACCESS AND AUTHENTICATIONS
Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('users', function(){
    return View('users');
});

Route::get('edit_user/{id}', function(){
    return View('edit_user');
});
Route::get('edit_user/{id}', 'CategoryController@editUser')->name('edit_user');
Route::post('deleteUser', 'CategoryController@deleteUser')->name('deleteUser');
Route::put('updateUser', 'CategoryController@updateUser')->name('updateUser');

// HELP LINK
Route::get('help', function(){
    return View('help');
});


// THIS IS NEW ROUTES FOR TRACKING
// Facilities
Route::resource('tracking', 'TrackerController');
Route::get('tfacility', 'TrackerController@create')->name('add_tracking');
Route::get('tfacility/{id}', 'TrackerController@edit');
Route::get('broadsheet', 'TrackerController@broadsheet')->name('broadsheet');
Route::post('filtered_tracking', 'TrackerController@filtered_tracking')->name('filtered_tracking');

// DAILY REPORTS
Route::resource('dailyreports', 'DailyreportController');

// INDICATORS REPORTS
Route::get('indicators_reporting', 'DailyreportController@indicators_reporting')->name('indicators_reporting');
Route::post('filtered_indicators', 'DailyreportController@filtered_indicators')->name('filtered_indicators');
