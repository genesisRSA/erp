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

//RGC ENT SYS
Route::get('/reiss/uom/all', 'UOMController@all');
Route::get('/reiss/uom_conversion/all', 'UOMConversionController@all');

Route::get('/reiss/currency/all', 'CurrenciesController@all');
Route::get('/reiss/payment_term/all', 'PaymentTermsController@all');
Route::get('/reiss/customer/all', 'CustomersController@all');

Route::get('/reiss/vendor/all', 'VendorController@all');
Route::get('/reiss/item_category/all','ItemCategoryController@all');
Route::get('/reiss/item_subcategory/all','ItemSubCategoryController@all');
Route::get('/reiss/assembly/all','AssemblyController@all');
Route::get('/reiss/fabrication/all','FabricationController@all');
Route::get('/reiss/item_master/all','ItemMasterController@all');
Route::get('/reiss/approver/all','ApproverMatrixController@all');
Route::get('/reiss/permission/all','SitePermissionsController@all');
Route::get('/reiss/forecast/all/{id}','SalesForecastController@all');
Route::get('/reiss/forecast/all_approval/{id}','SalesForecastController@all_approval');
Route::get('/reiss/quotation/all/{id}','SalesQuotationController@all');
Route::get('/reiss/quotation/all_approval/{id}','SalesQuotationController@all_approval');
Route::get('/reiss/visit/all/{id}','SalesVisitController@all');
Route::get('/reiss/procedure/all/{id}/{loc}','ProceduresController@all');
Route::get('/reiss/procedure/all_revision/{id}','ProceduresController@all_revision');
Route::get('/reiss/procedure/all_approval/{id}','ProceduresController@all_approval');

Route::get('/reiss/drawing/all/{id}/{loc}','DrawingsController@all');
Route::get('/reiss/drawing/all_revision/{id}','DrawingsController@all_revision');
Route::get('/reiss/drawing/all_approval/{id}','DrawingsController@all_approval');

Route::get('/reiss/projects/all/{id}','ProjectListController@all');

Route::get('/reiss/inventory/location/all/{id}','InventoryLocationController@all');
Route::get('/reiss/inventory/receiving/all/{id}','InventoryReceivingController@all');

Route::get('/reiss/inventory/issuance/all/{id}','InventoryIssuanceController@all');
Route::get('/reiss/inventory/issuance/issuance','InventoryIssuanceController@issuance');
Route::get('/reiss/inventory/issuance/all_approval/{id}','InventoryIssuanceController@all_approval');

Route::get('/reiss/inventory/list/all','InventoryController@all');
Route::get('/reiss/inventory/return/all','InventoryReturnController@all');

Route::get('/reiss/inventory/rtv/all/{id}','InventoryRTVController@all');
Route::get('/reiss/inventory/rtv/all_process','InventoryRTVController@all_process');
Route::get('/reiss/inventory/rtv/all_receiving','InventoryRTVController@all_receiving');
Route::get('/reiss/inventory/rtv/all_approval/{id}','InventoryRTVController@all_approval');

Route::get('/reiss/purchasing/rfq/all/{id}','RFQController@all');
Route::get('/reiss/purchasing/rfq/all_approval/{id}','RFQController@all_approval');
Route::get('/reiss/purchasing/rfq/all_for_rfq','RFQController@all_for_rfq');
Route::get('/reiss/purchasing/rfq/all_for_rev/{id}','RFQController@all_for_rev');
Route::get('/reiss/purchasing/rfq/{item_code}/{id}','RFQController@approve_items');

Route::get('/reiss/purchasing/pr/all/{id}','PRController@all');
Route::get('/reiss/purchasing/pr/all_approval/{id}','PRController@all_approval');

Route::get('/reiss/product_category/all', 'ProductCategoriesController@all');
Route::get('/reiss/product/all', 'ProductsController@all');

Route::get('/reiss/order/all/{emp_no}','SalesOrderController@all');
Route::get('/reiss/order/all_approval/{emp_no}','SalesOrderController@all_approval');

