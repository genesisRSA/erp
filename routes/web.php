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
    Route::get('/hris/attendance', 'PagesController@attendance')->name('hris.attendance');
    Route::get('/hris/{id}/teamattendance', 'PagesController@team_attendance');
    Route::get('/hris/myattendance', 'PagesController@myattendance');
    Route::post('/hris/attendance/alteration', 'AttendancesController@alteration')->name('attendance.alteration');
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
    
    Route::post('/hris/employeeshift/upload', 'EmployeeShiftsController@upload')->name('employeeshift.upload');
    Route::post('/hris/employeeshift/importsubmit', 'EmployeeShiftsController@import_submit')->name('employeeshift.importsubmit');
    Route::get('/hris/employeeshift/import', 'EmployeeShiftsController@import')->name('employeeshift.import');
    Route::get('/hris/employeeshift/delete/{id}', 'EmployeeShiftsController@delete');
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
Route::get('/prtoporeport', 'PagesController@prtoporeport')->name('report.prtoporeport');
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
    Route::get('/ics/signages/{id}/reject', 'SignagesController@rejected')->name('digital.reject');
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
Route::get('/reiss','ERPPageController@index')->name('res.index');

Route::post('/reiss/login', 'Auth\DCSLoginController@login')->name('reiss.login');
    Route::get('/reiss/home','ERPPageController@home')->name('res.home');   
Route::group(['middleware' => ['auth.dcs']], function() {

    // ERP

    Route::resource('/reiss/uom', 'UOMController');
    Route::post('/reiss/uom/patch', 'UOMController@patch')->name('uom.patch');
    Route::post('/reiss/uom/delete', 'UOMController@delete')->name('uom.delete');

    Route::resource('/reiss/currency', 'CurrenciesController');
    Route::post('/reiss/currency/patch', 'CurrenciesController@patch')->name('currency.patch');
    Route::post('/reiss/currency/delete', 'CurrenciesController@delete')->name('currency.delete');

    Route::resource('/reiss/payment_term', 'PaymentTermsController');
    Route::post('/reiss/payment_term/patch', 'PaymentTermsController@patch')->name('payment_term.patch');
    Route::post('/reiss/payment_term/delete', 'PaymentTermsController@delete')->name('payment_term.delete');

    Route::resource('/reiss/customer', 'CustomersController');
    Route::post('/reiss/customer/patch', 'CustomersController@patch')->name('customer.patch');
    Route::post('/reiss/customer/delete', 'CustomersController@delete')->name('customer.delete');

    // start -> jp task
    Route::resource('/reiss/vendor', 'VendorController');
    Route::post('/reiss/vendor/patch', 'VendorController@patch')->name('vendor.patch');
    Route::post('/reiss/vendor/delete', 'VendorController@delete')->name('vendor.delete');

    Route::resource('/reiss/item_category', 'ItemCategoryController');
    Route::post('/reiss/item_category/patch', 'ItemCategoryController@patch')->name('item_category.patch');
    Route::post('/reiss/item_category/delete', 'ItemCategoryController@delete')->name('item_category.delete');

    Route::resource('/reiss/item_subcategory', 'ItemSubCategoryController');
    Route::post('/reiss/item_subcategory/patch', 'ItemSubCategoryController@patch')->name('item_subcategory.patch');
    Route::post('/reiss/item_subcategory/delete', 'ItemSubCategoryController@delete')->name('item_subcategory.delete');

    Route::resource('/reiss/assembly','AssemblyController');
    Route::post('/reiss/assembly/patch', 'AssemblyController@patch')->name('assembly.patch');
    Route::post('/reiss/assembly/delete', 'AssemblyController@delete')->name('assembly.delete');

    Route::resource('/reiss/fabrication','FabricationController');
    Route::post('/reiss/fabrication/patch', 'FabricationController@patch')->name('fabrication.patch');
    Route::post('/reiss/fabrication/delete', 'FabricationController@delete')->name('fabrication.delete');

    Route::resource('/reiss/item_master','ItemMasterController');
    Route::post('/reiss/item_master/patch', 'ItemMasterController@patch')->name('item_master.patch');
    Route::post('/reiss/item_master/delete', 'ItemMasterController@delete')->name('item_master.delete');
    Route::get('/reiss/item_master/getSubCategory/{id}', 'ItemMasterController@getSubCategory');

    Route::resource('/reiss/approver','ApproverMatrixController');
    Route::post('/reiss/approver/delete','ApproverMatrixController@delete')->name('approver.delete');
    Route::post('/reiss/approver/patch','ApproverMatrixController@patch')->name('approver.patch');

    Route::resource('/reiss/forecast','SalesForecastController');
    Route::post('/reiss/forecast/delete', 'SalesForecastController@delete')->name('forecast.delete');
    Route::post('/reiss/forecast/patch', 'SalesForecastController@patch')->name('forecast.patch');
    Route::post('/reiss/forecast/approve', 'SalesForecastController@approve')->name('forecast.approve');
    Route::get('/reiss/forecast/getApprover/{id}/{module}', 'SalesForecastController@getApprover');
    Route::get('/reiss/forecast/getApproverMatrix/{id}', 'SalesForecastController@getApproverMatrix');
    Route::get('/reiss/forecast/getProducts/{id}', 'SalesForecastController@getProducts');
    Route::get('/reiss/forecast/check/{id}/{loc}', 'SalesForecastController@check');

    Route::resource('/reiss/quotation','SalesQuotationController');
    Route::post('/reiss/quotation/delete', 'SalesQuotationController@delete')->name('quotation.delete');
    Route::post('/reiss/quotation/patch', 'SalesQuotationController@patch')->name('quotation.patch');
    Route::post('/reiss/quotation/approve', 'SalesQuotationController@approve')->name('quotation.approve');
    Route::get('/reiss/quotation/getApprover/{id}/{module}', 'SalesQuotationController@getApprover');
    Route::get('/reiss/quotation/getApproverMatrix/{id}', 'SalesQuotationController@getApproverMatrix');
    Route::get('/reiss/quotation/getForecast/{id}', 'SalesQuotationController@getForecast');
    Route::get('/reiss/quotation/getProducts/{id}', 'SalesQuotationController@getProducts');
    Route::get('/reiss/quotation/getAllEdit/{id}', 'SalesQuotationController@getAllEdit');
    Route::get('/reiss/quotation/check/{id}/{loc}', 'SalesQuotationController@check');

    Route::resource('/reiss/visit', 'SalesVisitController');
    Route::post('/reiss/visit/delete', 'SalesVisitController@delete')->name('visit.delete');

    Route::get('/reiss/visit/new', 'SalesVisitController@new')->name('visit.new');


    // end -> jp task

    Route::resource('/reiss/product_category', 'ProductCategoriesController');
    Route::post('/reiss/product_category/patch', 'ProductCategoriesController@patch')->name('product_category.patch');
    Route::post('/reiss/product_category/delete', 'ProductCategoriesController@delete')->name('product_category.delete');

    Route::resource('/reiss/product', 'ProductsController');
    Route::post('/reiss/product/patch', 'ProductsController@patch')->name('product.patch');
    Route::post('/reiss/product/delete', 'ProductsController@delete')->name('product.delete');


});