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
Route::get('/hris/attendances/calc_all', 'AttendancesController@calc_all');
Route::get('/hris/attendances/access_details/{id}', 'AttendancesController@access_details');
Route::get('/hris/attendances/my_today/{emp_id}/{today}', 'AttendancesController@my_today');
Route::get('/hris/attendances/my_attendance/{emp_id}', 'AttendancesController@my_attendance');
Route::get('/hris/attendances/av_attendance/{date_from}/{date_to}', 'AttendancesController@av_attendance');

Route::get('/hris/employees/all', 'EmployeesController@all');
Route::get('/hris/employees/all_resign', 'EmployeesController@all_resign');
Route::get('/hris/sites/{id}/domain', 'SitesController@domain');
Route::get('/hris/sites/{id}/departments/', 'DepartmentsController@all');
Route::get('/hris/departments/{id}/sections/', 'SectionsController@all');
Route::get('/hris/sections/{id}/positions/', 'PositionsController@all');
Route::get('/signages/all/{emp_no}', 'SignagesController@all');
Route::get('/signages/forapproval/{emp_no}', 'SignagesController@forapproval');

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

//CANTIER
Route::get('/report/costing', 'AttendancesController@costing');
Route::get('/report/prreport', 'AttendancesController@prreport');
Route::get('/report/prtoporeport', 'AttendancesController@prtoporeport');

//ICS
Route::get('/areas/all', 'AreasController@all');
Route::get('/ics/users/', 'ICSController@users');
Route::post('/ics/users/authbycode', 'ICSController@authbycode');
Route::post('/ics/users/auth', 'ICSController@auth');
Route::post('/ics/items/search', 'ICSController@search');
Route::post('/ics/items/createstock', 'ICSController@create_stock');

//RGC ENT SYS
Route::get('/rgc_entsys/uom/all', 'UOMController@all');
Route::get('/rgc_entsys/currency/all', 'CurrenciesController@all');
Route::get('/rgc_entsys/payment_term/all', 'PaymentTermsController@all');
Route::get('/rgc_entsys/customer/all', 'CustomersController@all');
Route::get('/rgc_entsys/product_category/all', 'ProductCategoriesController@all');
Route::get('/rgc_entsys/product/all', 'ProductsController@all');
