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


Auth::routes();

//HRIS
Route::get('/hris', 'PagesController@hris_index')->name('hris.index');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/hris/home', 'PagesController@hris_home');
    Route::get('/hris/attendance', 'PagesController@attendance');
    Route::get('/hris/myattendance', 'PagesController@myattendance');
    Route::get('/hris/timekeeping', 'PagesController@timekeeping');
    Route::resource('/hris/employees', 'EmployeesController');
    
    Route::get('/hris/employees/{id}/account', 'EmployeesController@account')->name('account.create');
    Route::post('/hris/employees/account/store', 'EmployeesController@account_store')->name('account.store');
    Route::post('/hris/employees/account/update', 'EmployeesController@account_update')->name('account.update');
    Route::resource('/hris/leave', 'LeavesController');

    Route::get('/hris/mytimekeeping', 'PagesController@mytimekeeping')->name('mytimekeeping');
    Route::get('/hris/leaves/my', 'LeavesController@my');
    Route::get('/hris/leaves/approval', 'LeavesController@approval');
    Route::get('/hris/leaves/{ref_no}/approval', 'LeavesController@for_approval');
});


//ICS
Route::get('/ics', 'PagesController@ics_index');
Route::get('/ics/home', 'PagesController@ics_home')->middleware('auth');
Route::get('/ics/inventory', 'PagesController@inventory');
Route::resource('/ics/area', 'AreasController');
Route::get('/ics/barcode', 'PagesController@barcode');

