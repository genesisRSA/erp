<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SalesMailable;
use App\SalesForecast;
use App\SalesQuotation;
use App\SalesProductList;
use App\Customer;
use App\PaymentTerm;
use App\ApproverMatrix;
use App\Product;
use App\Site;
use App\Currency;
use App\UnitOfMeasure;
use App\Employee;
use Validator;
use Auth;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Quotation = SalesQuotation::all();
        $forecast_code = SalesForecast::all()
                            ->where('status','=','Approved');
        $payment = PaymentTerm::all();
        $site = Site::all();
        $customer = Customer::all();
        $product = Product::all();
        $uom = UnitOfMeasure::all();
        $currency = Currency::select('currency_code', 'currency_name', 'symbol')->get();
        $lastQuotation = DB::table('sales_quotations')->count();
        $today = date('Ymd');
        $lastQuotationleadZ = str_pad($lastQuotation+1,4,"0",STR_PAD_LEFT);

        return view('res.sales_order.index')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','order')
                ->with('sites', $site)
                ->with('customers', $customer)
                ->with('products', $product)
                ->with('uoms', $uom)
                ->with('currencies', $currency)
                ->with('forecast_code', $forecast_code)
                ->with('payment', $payment)
                ->with('quot','QUOT')
                ->with('today', $today)
                ->with('lastquotation', $lastQuotationleadZ)
                ->with('quotation', $Quotation);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function patch(Request $request)
    {
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        //
        if(SalesForecast::destroy($request->input('id',''))){
            return redirect()->route('forecast.index')->withSuccess('Sales Forecast Details Successfully Deleted');
        }
    }
}
