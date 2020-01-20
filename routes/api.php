<?php

use Illuminate\Http\Request;

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

//HRIS

Route::get('/hris/attendances/all', 'AttendancesController@all');
Route::get('/hris/attendances/access_details/{id}', 'AttendancesController@access_details');
Route::get('/hris/attendances/my_today/{emp_id}/{today}', 'AttendancesController@my_today');
Route::get('/hris/attendances/my_attendance/{emp_id}', 'AttendancesController@my_attendance');

Route::get('/hris/employees/all', 'EmployeesController@all');
Route::get('/hris/sites/{id}/domain', 'SitesController@domain');
Route::get('/hris/sites/{id}/departments/', 'DepartmentsController@all');
Route::get('/hris/departments/{id}/sections/', 'SectionsController@all');
Route::get('/hris/sections/{id}/positions/', 'PositionsController@all');

Route::get('/hris/leaves/all', 'LeavesController@all');
Route::get('/hris/leaves/all_posted', 'LeavesController@all_posted');

Route::get('/hris/shifts/{shift_code}/days', 'ShiftsController@shift_days');
Route::get('/hris/employeeshifts/all', 'EmployeeShiftsController@all');

Route::get('/hris/obs/all', 'OBController@all');
Route::get('/hris/obs/all_posted', 'OBController@all_posted');

Route::get('/hris/css/all', 'CSController@all');
Route::get('/hris/css/all_posted', 'CSController@all_posted');

Route::get('/hris/ots/all', 'OTController@all');
Route::get('/hris/ots/all_posted', 'OTController@all_posted');

Route::get('/report/costing', 'AttendancesController@costing');

//ICS
Route::get('/areas/all', 'AreasController@all');
Route::get('/ics/users/', 'ICSController@users');
Route::post('/ics/users/authbycode', 'ICSController@authbycode');
Route::post('/ics/users/auth', 'ICSController@auth');
Route::post('/ics/items/search', 'ICSController@search');
Route::post('/ics/items/createstock', 'ICSController@create_stock');

