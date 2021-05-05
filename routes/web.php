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
Route::get('/reiss','ERPPageController@index')->name('res.index');

Route::post('/reiss/login', 'Auth\DCSLoginController@login')->name('reiss.login');
Route::group(['middleware' => ['auth.dcs']], function() {

    // ERP

    Route::get('/reiss/home','ERPPageController@home')->name('res.home');   
    Route::post('/reiss/logout', 'Auth\DCSLoginController@logout')->name('reiss.logout');
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
    Route::get('/reiss/approver/{requestor}/{module}/my_matrix','ApproverMatrixController@my_matrix')->name('approver.my_matrix');
    
    Route::resource('/reiss/permission','SitePermissionsController');
    Route::post('/reiss/permission/delete','SitePermissionsController@delete')->name('permission.delete');
    Route::post('/reiss/permission/patch','SitePermissionsController@patch')->name('permission.patch');

    Route::resource('/reiss/forecast','SalesForecastController');
    Route::post('/reiss/forecast/delete', 'SalesForecastController@delete')->name('forecast.delete');
    Route::post('/reiss/forecast/void', 'SalesForecastController@void')->name('forecast.void');
    Route::post('/reiss/forecast/patch', 'SalesForecastController@patch')->name('forecast.patch');
    Route::post('/reiss/forecast/approve', 'SalesForecastController@approve')->name('forecast.approve');
    Route::get('/reiss/forecast/getApprover/{id}/{module}', 'SalesForecastController@getApprover');
    Route::get('/reiss/forecast/getApproverMatrix/{id}', 'SalesForecastController@getApproverMatrix');
    Route::get('/reiss/forecast/getProducts/{id}', 'SalesForecastController@getProducts');
    Route::get('/reiss/forecast/check/{id}/{loc}', 'SalesForecastController@check');

    Route::resource('/reiss/quotation','SalesQuotationController');
    Route::post('/reiss/quotation/delete', 'SalesQuotationController@delete')->name('quotation.delete');
    Route::post('/reiss/quotation/void', 'SalesQuotationController@void')->name('quotation.void');
    Route::post('/reiss/quotation/patch', 'SalesQuotationController@patch')->name('quotation.patch');
    Route::post('/reiss/quotation/approve', 'SalesQuotationController@approve')->name('quotation.approve');
    Route::get('/reiss/quotation/getApprover/{id}/{module}', 'SalesQuotationController@getApprover');
    Route::get('/reiss/quotation/getApproverMatrix/{id}', 'SalesQuotationController@getApproverMatrix');
    Route::get('/reiss/quotation/getForecast/{id}', 'SalesQuotationController@getForecast');
    Route::get('/reiss/quotation/getProducts/{id}', 'SalesQuotationController@getProducts');
    Route::get('/reiss/quotation/getAllEdit/{id}', 'SalesQuotationController@getAllEdit');
    Route::get('/reiss/quotation/check/{id}/{loc}', 'SalesQuotationController@check');
    Route::get('/reiss/quotation/{cust_code}/allbycustomer', 'SalesQuotationController@allbycustomer')->name('quotation.allbycustomer');

    Route::resource('/reiss/visit', 'SalesVisitController');
    Route::post('/reiss/visit/delete', 'SalesVisitController@delete')->name('visit.delete');
    Route::post('/reiss/visit/patch', 'SalesVisitController@patch')->name('visit.patch');
    Route::get('/reiss/visit/view/{id}', 'SalesVisitController@view')->name('visit.view');

    Route::resource('/reiss/procedure', 'ProceduresController');
    Route::post('/reiss/procedure/revision', 'ProceduresController@revision')->name('procedure.revision');
    Route::post('/reiss/procedure/receive', 'ProceduresController@receive')->name('procedure.receive');
    Route::post('/reiss/procedure/orient', 'ProceduresController@orient')->name('procedure.orient');
    Route::post('/reiss/procedure/approve', 'ProceduresController@approve')->name('procedure.approve');
    Route::post('/reiss/procedure/makemaster', 'ProceduresController@makeMaster')->name('procedure.makemaster');
    Route::post('/reiss/procedure/makecopy', 'ProceduresController@makeCopy')->name('procedure.makecopy');
    Route::post('/reiss/procedure/delete', 'ProceduresController@delete')->name('procedure.delete');
    Route::get('/reiss/procedure/check/{id}/{loc}', 'ProceduresController@check');
    Route::get('/reiss/procedure/view/{id}/{loc}/', 'ProceduresController@view')->name('procedure.view');
    Route::get('/reiss/procedure/view_fcc/{id}/{loc}', 'ProceduresController@view_fcc')->name('procedure.view_fcc');
    Route::get('/reiss/procedure/view_cc/{id}/{loc}', 'ProceduresController@view_cc')->name('procedure.view_cc');
    Route::get('/reiss/procedure/revise/{id}', 'ProceduresController@revise')->name('procedure.revise');
    Route::get('/reiss/procedure/getDocument/{id}/{stat}/{loc}/{cc}', 'ProceduresController@getDocument')->name('procedure.getDocument');
    Route::get('/reiss/procedure/pdf/{id}/{loc}', 'ProceduresController@pdf')->name('procedure.pdf');
    Route::get('/reiss/procedure/pdfx/{id}/{loc}', 'ProceduresController@pdfx')->name('procedure.pdfx');
    Route::get('/reiss/procedure/master/{id}/{loc}', 'ProceduresController@master_view')->name('procedure.master');
    Route::get('/reiss/procedure/copy/{id}/{loc}', 'ProceduresController@copy_view')->name('procedure.copy');
    Route::get('/reiss/procedure/approval/{id}/{loc}', 'ProceduresController@approval_view')->name('procedure.approval');
    Route::get('/reiss/procedure/getApprover/{id}', 'ProceduresController@getApprover');
    Route::get('/reiss/procedure/getApproverMatrix/{id}', 'ProceduresController@getApproverMatrix');

    Route::resource('/reiss/drawing', 'DrawingsController');
    Route::post('/reiss/drawing/revision', 'DrawingsController@revision')->name('drawing.revision');
    Route::post('/reiss/drawing/receive', 'DrawingsController@receive')->name('drawing.receive');
    Route::post('/reiss/drawing/approve', 'DrawingsController@approve')->name('drawing.approve');
    Route::post('/reiss/drawing/makemaster', 'DrawingsController@makeMaster')->name('drawing.makemaster');
    Route::post('/reiss/drawing/makecopy', 'DrawingsController@makeCopy')->name('drawing.makecopy');
    Route::post('/reiss/drawing/delete', 'DrawingsController@delete')->name('drawing.delete');
    Route::get('/reiss/drawing/check/{id}/{loc}', 'DrawingsController@check');
    Route::get('/reiss/drawing/view/{id}/{loc}/', 'DrawingsController@view')->name('drawing.view');
    Route::get('/reiss/drawing/view_fcc/{id}/{loc}', 'DrawingsController@view_fcc')->name('drawing.view_fcc');
    Route::get('/reiss/drawing/view_cc/{id}/{loc}', 'DrawingsController@view_cc')->name('drawing.view_cc');
    Route::get('/reiss/drawing/revise/{id}', 'DrawingsController@revise')->name('drawing.revise');
    Route::get('/reiss/drawing/getDocument/{id}/{stat}/{loc}/{cc}', 'DrawingsController@getDocument')->name('drawing.getDocument');
    Route::get('/reiss/drawing/pdf/{id}/{loc}', 'DrawingsController@pdf')->name('drawing.pdf');
    Route::get('/reiss/drawing/pdfx/{id}/{loc}', 'DrawingsController@pdfx')->name('drawing.pdfx');
    Route::get('/reiss/drawing/master/{id}/{loc}', 'DrawingsController@master_view')->name('drawing.master');
    Route::get('/reiss/drawing/copy/{id}/{loc}', 'DrawingsController@copy_view')->name('drawing.copy');
    Route::get('/reiss/drawing/approval/{id}/{loc}', 'DrawingsController@approval_view')->name('drawing.approval');
    Route::get('/reiss/drawing/getApprover/{id}', 'DrawingsController@getApprover');
    Route::get('/reiss/drawing/getApproverMatrix/{id}', 'DrawingsController@getApproverMatrix');

    
    Route::resource('/reiss/projects', 'ProjectListController');
    Route::post('/reiss/projects/revision', 'ProjectListController@revision')->name('projects.revision');
    Route::get('/reiss/projects/{item_code}/item_details','ProjectListController@item_details')->name('projects.item_details');
    Route::get('/reiss/projects/{site_code}/orders','ProjectListController@all_orders')->name('projects.all_orders');
    Route::get('/reiss/projects/{order_code}/allproducts','ProjectListController@all_products')->name('projects.all_products');
    Route::get('/reiss/projects/{cust_code}/count','ProjectListController@count_per_type')->name('projects.count_per_type');
    Route::get('/reiss/projects/{prod_code}/assy','ProjectListController@prod_assy')->name('projects.prod_assy');
    Route::get('/reiss/projects/{assy_code}/fab','ProjectListController@assy_fab')->name('projects.assy_fab');

    Route::get('/reiss/projects/view/{project_code}/view_assy','ProjectListController@view_assy')->name('projects.view_assy');
    Route::get('/reiss/projects/view/{project_code}/{assy_code}/fab','ProjectListController@view_fabs')->name('projects.view_fabs');
    Route::get('/reiss/projects/view/{project_code}/adtl','ProjectListController@view_adtl')->name('projects.view_adtl');
    Route::get('/reiss/projects/view/{id}', 'ProjectListController@view')->name('projects.view');

    Route::get('/reiss/projects/edit/{item_code}/item_details','ProjectListController@item_details')->name('projects.item_details');
    Route::get('/reiss/projects/edit/{project_code}/edit_assy','ProjectListController@edit_assy')->name('projects.edit_assy');
    Route::get('/reiss/projects/edit/{project_code}/{assy_code}/fab','ProjectListController@edit_fabs')->name('projects.edit_fabs');
    Route::get('/reiss/projects/edit/{project_code}/adtl','ProjectListController@edit_adtl')->name('projects.edit_adtl');
    Route::get('/reiss/projects/edit/{id}', 'ProjectListController@edit')->name('projects.edit');
    
    Route::get('/reiss/dashboard/{parent}', 'ReissDashboardController@index');

    // end -> jp task
    
    Route::resource('/reiss/order','SalesOrderController');
    Route::post('/reiss/order/delete', 'SalesOrderController@delete')->name('order.delete');
    Route::post('/reiss/order/patch', 'SalesOrderController@patch')->name('order.patch');
    Route::post('/reiss/order/test', 'SalesOrderController@test')->name('order.test');
    Route::post('/reiss/order/approve', 'SalesOrderController@approve')->name('order.approve');
    Route::get('/reiss/order/pospecs/{filepath}', 'SalesOrderController@pospecs')->name('order.pospecs');

    Route::resource('/reiss/product_category', 'ProductCategoriesController');
    Route::post('/reiss/product_category/patch', 'ProductCategoriesController@patch')->name('product_category.patch');
    Route::post('/reiss/product_category/delete', 'ProductCategoriesController@delete')->name('product_category.delete');

    Route::resource('/reiss/product', 'ProductsController');
    Route::get('/reiss/product/{site_code}/allbysite', 'ProductsController@allbysite')->name('product.allbysite');
    Route::post('/reiss/product/patch', 'ProductsController@patch')->name('product.patch');
    Route::post('/reiss/product/delete', 'ProductsController@delete')->name('product.delete');


});