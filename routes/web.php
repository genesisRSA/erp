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

    Route::get('/hris/home', 'PagesController@hris_home')->name('hris.home');
    Route::get('/hris/attendance', 'PagesController@attendance');
    Route::get('/hris/{id}/teamattendance', 'PagesController@team_attendance');
    Route::get('/hris/myattendance', 'PagesController@myattendance');
    Route::get('/hris/timekeeping', 'PagesController@timekeeping')->name('timekeeping');
    Route::resource('/hris/employees', 'EmployeesController');
    Route::get('/hris/employees/{id}/resign', 'EmployeesController@resign')->name('employees.resign');
    
    Route::get('/hris/employees/{id}/account', 'EmployeesController@account')->name('account.create');
    Route::post('/hris/employees/account/store', 'EmployeesController@account_store')->name('account.store');
    Route::post('/hris/employees/account/update', 'EmployeesController@account_update')->name('account.update');
    Route::post('/hris/employees/account/change_password', 'EmployeesController@change_password')->name('account.changepassword');

    Route::resource('/hris/leave', 'LeavesController');
    Route::get('/hris/leave/{ref_no}/posting', 'LeavesController@for_posting');
    Route::post('/hris/leave/{leave}', 'LeavesController@post')->name('leave.post');
    Route::get('/hris/leave/{ref_no}/posted', 'LeavesController@show_posted');
    
    Route::resource('/hris/employeeshift', 'EmployeeShiftsController');

    Route::get('/hris/mytimekeeping', 'PagesController@mytimekeeping')->name('mytimekeeping');
    Route::get('/hris/leaves/my', 'LeavesController@my');
    Route::get('/hris/leaves/my_posted', 'LeavesController@my_posted');
    Route::get('/hris/leaves/approval', 'LeavesController@approval');
    Route::get('/hris/leaves/{ref_no}/approval', 'LeavesController@for_approval');

    Route::resource('/hris/ob', 'OBController');
    Route::get('/hris/obs/my', 'OBController@my');
    Route::get('/hris/obs/approval', 'OBController@approval');
    Route::get('/hris/obs/{ref_no}/approval', 'OBController@for_approval');
    Route::get('/hris/obs/{ref_no}/posting', 'OBController@posting');
    Route::post('/hris/obs/{ob}', 'OBController@posted')->name('ob.posted');

    Route::resource('/hris/cs', 'CSController');
    Route::get('/hris/css/my', 'CSController@my');
    Route::get('/hris/css/approval', 'CSController@approval');
    Route::get('/hris/css/{ref_no}/approval', 'CSController@for_approval');
    Route::get('/hris/css/{ref_no}/posting', 'CSController@posting');
    Route::post('/hris/css/{cs}', 'CSController@posted')->name('cs.posted');

    Route::resource('/hris/ot', 'OTController');
    Route::get('/hris/ots/my', 'OTController@my');
    Route::get('/hris/ots/approval', 'OTController@approval');
    Route::get('/hris/ots/{ref_no}/approval', 'OTController@for_approval');
    Route::get('/hris/ots/{ref_no}/posting', 'OTController@posting');
    Route::post('/hris/ots/{ot}', 'OTController@posted')->name('ot.posted');

});


Route::get('/costing', 'PagesController@costing')->name('report.costing');
Route::get('/prreport', 'PagesController@prreport')->name('report.prreport');
Route::get('/signage', 'SignagesController@signage')->name('digital.signage');
Route::get('/signagev', 'SignagesController@signage_vertical')->name('digital.signagev');
Route::get('/signagejo', 'SignagesController@signage_jolist')->name('digital.signagejo');
Route::get('/signagejov', 'SignagesController@signage_jolistv')->name('digital.signagejov');
Route::get('/managesignage', 'PagesController@managesignage')->name('digital.managesignage');
Route::resource('/signages', 'SignagesController');

Route::get('/signages/{id}/disable', 'SignagesController@disable')->name('digital.disable');
Route::get('/signages/{id}/enable', 'SignagesController@enable')->name('digital.enable');
Route::get('/signages/{id}/delete', 'SignagesController@delete')->name('digital.delete');

Route::get('/wfh/attendance','PagesController@wfh')->name('wfh.attendance');
Route::post('/wfh/check','PagesController@wfhcheck')->name('wfhcheck');


//ICS
Route::get('/ics', 'PagesController@ics_index')->name('ics.index');
Route::post('/ics/login', 'Auth\ICSLoginController@login')->name('ics.login');

Route::group(['middleware' => ['auth.ics']], function() {
    Route::post('/ics/logout', 'Auth\ICSLoginController@logout')->name('ics.logout');
    Route::get('/ics/home', 'PagesController@ics_home')->name('ics.home');
    Route::get('/ics/inventory', 'PagesController@inventory');
    Route::resource('/ics/area', 'AreasController');
    Route::get('/ics/barcode', 'PagesController@barcode');
    Route::resource('/ics/signages', 'SignagesController');
    Route::get('/ics/signages/{id}/disable', 'SignagesController@disable')->name('digital.disable');
    Route::get('/ics/signages/{id}/enable', 'SignagesController@enable')->name('digital.enable');
    Route::get('/ics/signages/{id}/approve', 'SignagesController@enable')->name('digital.approve');
    Route::get('/ics/signages/{id}/reject', 'SignagesController@reject')->name('digital.reject');
    Route::get('/ics/signages/{id}/delete', 'SignagesController@delete')->name('digital.delete');
    Route::post('/ics/home', 'EmployeesController@ics_change_password')->name('icsaccount.changepassword');
});


Route::get('/dcs', 'PagesController@dcs_index')->name('dcs.index'); 
Route::post('/dcs/login', 'Auth\DCSLoginController@login')->name('dcs.login');
Route::group(['middleware' => ['auth.dcs']], function() {
    Route::get('/dcs/home', 'PagesController@dcs_home')->name('dcs.home');
});


Route::get('/phpinfo', 'PagesController@phpinfo')->name('php.info');
Route::get('/jolist', 'SignagesController@jolist')->name('jo.list');


Route::get('/rgc_entsys/home','ERPPageController@home')->name('res.home');
Route::get('/rgc_entsys/uom','UOMController@index')->name('res.params.uom');