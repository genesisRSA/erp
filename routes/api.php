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




//ICS
Route::get('/areas/all', 'AreasController@all');