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
Route::get('/', 'HomeController@index')->name('dashboard')->middleware('role:Admin');

Route::get('dashboard', 'HomeController@index')->name('dashboard')->middleware('role:Admin');

Route::get('/home', 'HomeController@user_dashboard')->name('home')->middleware('auth');


// Settings
Route::resource('settings', 'SettingsController');
Route::get('edit_settings/{id}', 'SettingsController@edit')->name('edit_settings');

// Suppliers
Route::resource('suppliers', 'SupplierController');
Route::get('add_supplier', 'SupplierController@create')->name('add_supplier');

// Inventories
Route::resource('inventories', 'InventoryController');
Route::get('add_item', 'InventoryController@create')->name('add_item');
Route::get('item/{id}', 'InventoryController@edit');
Route::get('print_item/{id}', 'InventoryController@show')->name('print_item');
Route::get('reports', 'InventoryController@reports')->name('reports');

// Item Requests
Route::get('requests', 'InventoryController@requests')->name('requests');
Route::get('request/{id}', 'InventoryController@request')->name('request');

Route::post('new_request', 'InventoryController@new_request')->name('new_request');
Route::post('request_destroy','InventoryController@request_destroy')->name('request_destroy');
Route::post('update_request', 'InventoryController@update_request')->name('update_request');

// Facilities
Route::resource('facilities', 'FacilitiesController');
Route::get('add_facility', 'FacilitiesController@create')->name('add_facility');
Route::get('facility/{id}', 'FacilitiesController@edit');

// Movements
Route::resource('movements', 'MovementController');
Route::get('move_item/{id}', 'MovementController@edit')->name('move_item');

// Audits
Route::resource('audits', 'AuditController');

// Departments
Route::resource('departments', 'DepartmentController');
Route::get('add_department', 'DepartmentController@create')->name('add_department');

// Categories
Route::resource('categories', 'CategoryController');


// Units
Route::resource('units', 'UnitController');
Route::get('add_unit', 'UnitController@create')->name('add_unit');

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


// THIS IS NEW ROUTES FOR RESTHUB

// Patients
Route::resource('patients', 'PatientsController')->middleware('auth');
Route::get('add_patient', 'PatientsController@create')->name('add_patient')->middleware('auth');
Route::get('patient/{id}', 'PatientsController@edit')->middleware('auth');

// Samples
Route::resource('samples', 'SamplesController')->middleware('auth');
Route::get('/add_sample', 'SamplesController@create')->name('add_sample')->middleware('auth');
Route::get('/sample/{id}', 'SamplesController@edit')->middleware('auth');
Route::get('/add_psample/{id}', 'SamplesController@addSample')->middleware('auth');
Route::post('/changesStatus', 'SamplesController@changesStatus')->name('changesStatus')->middleware('auth');
Route::get('/addmanifest', 'SamplesController@addManifests')->name('add_manifests')->middleware('auth');
Route::post('/add_manifest', 'SamplesController@postManifests')->name('add_manifest')->middleware('auth');


// Sites
Route::resource('sites', 'SitesController')->middleware('auth');

// Shipping
Route::resource('shippings', 'ShippingController')->middleware('auth');
Route::get('/add_shipping', 'ShippingController@create')->name('add_shipping')->middleware('auth');
Route::get('/shipping/{id}', 'ShippingController@edit')->middleware('auth');
Route::post('/changesmStatus', 'ShippingController@changesmStatus')->name('changesmStatus')->middleware('auth');

// Specimen Results
Route::resource('specimens', 'SpecimenResultsController')->middleware('auth');
Route::get('/add_specimenresult', 'SpecimenResultsController@create')->name('add_specimenresult')->middleware('auth');
Route::get('/specimenresult/{id}', 'SpecimenResultsController@edit')->middleware('auth');
Route::get('/add_results/{id}', 'SpecimenResultsController@add_results')->name('add_results')->middleware('auth');
Route::get('/specimen_result/{id}', 'SpecimenResultsController@specimen_result')->name('specimen_result')->middleware('auth');
Route::get('/downloadpdf/{id}', 'SpecimenResultsController@download_pdfresult')->name('download_pdfresult')->middleware('auth');
Route::get('/sendtoemail/{id}', 'SpecimenResultsController@sendresultTomail')->name('sendtoemail')->middleware('auth');

// Drug Resistance
Route::resource('resistances', 'DrugResistanceController')->middleware('auth');
Route::get('/new_drugresistance/{id}', 'DrugResistanceController@create')->middleware('auth');
Route::get('/drug_resistance/{id}', 'DrugResistanceController@edit')->middleware('auth');
