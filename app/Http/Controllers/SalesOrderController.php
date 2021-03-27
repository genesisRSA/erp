<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\SalesMailable;
use App\SalesQuotation;
use App\SalesProductList;
use App\SalesOrder;
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
        $quotation = SalesQuotation::all()
                    ->where('status','=','Approved');
        $payment = PaymentTerm::all();
        $site = Site::all();
        $customer = Customer::all();
        $uom = UnitOfMeasure::all();
        $currency = Currency::select('currency_code', 'currency_name', 'symbol')->get();
        $lastid = DB::table('sales_orders')->latest('order_code')->first();

        if($lastid){
            $lastid = intval(explode('-',$lastid->order_code)[1]);
        }else{
            $lastid = 0;
        }

        $lastid = "ORDER".date('Ymd').'-'.str_pad(($lastid+1), 3, '0', STR_PAD_LEFT);

        return view('res.sales_order.index')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','order')
                ->with('sites', $site)
                ->with('customers', $customer)
                ->with('uoms', $uom)
                ->with('currencies', $currency)
                ->with('payment', $payment)
                ->with('lastid', $lastid);
    }


    public function all($emp_no)
    {
        
        $emp_no = Crypt::decrypt($emp_no);

        return response()
        ->json([
            "data" => SalesOrder::where('created_by','=',$emp_no)
                        ->with('sites:site_code,site_desc')
                        ->with('currency:currency_code,currency_name,symbol')
                        ->with('customers:cust_code,cust_name')
                        ->with('payment:id,term_name')
                        ->get()
        ]);
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

        $field = [
            'customer_code' => 'required|string',
            // 'site_code' => 'required',
            // 'access_id' => 'required',
            // 'emp_no' => 'required|string|unique:employees',
            // 'work_email' => 'required',
            // 'dept_code' => 'required|string',
            // 'sect_code' => 'required|string',
            // 'position' => 'required|string',
            // 'date_hired' => 'date',
            // 'emp_cat' => 'required|string',
            // 'date_regularized' => 'date',
            // 'sss_no' => 'required|string|unique:employees',
            // 'phil_no' => 'required|string|unique:employees',
            // 'pagibig_no' => 'required|string|unique:employees',
            // 'tin_no' => 'required|string|unique:employees',
            // 'emp_fname' => 'required|string',
            // 'emp_lname' => 'required|string',
            // 'dob' => 'date',
            // 'current_address' => 'required|string',
            // 'home_address' => 'required|string',
            // 'emergency_person' => 'required|string',
            // 'emergency_address' => 'required|string',
            // 'emergency_contact' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $field);

        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{

            $lastid = DB::table('sales_orders')->latest('order_code')->first();
            if($lastid){
                $lastid = intval(explode('-',$lastid->order_code)[1]);
            }else{
                $lastid = 0;
            }

            $lastid = "ORDER".date('Ymd').'-'.str_pad(($lastid+1), 3, '0', STR_PAD_LEFT);

            $sales_order = new SalesOrder();
            $sales_order->site_code = Auth::user()->employee->site_code;
            $sales_order->quotation_code = $request->input('quotation_code') ? $request->input('quotation_code') : null;
            $sales_order->order_code = $lastid;
            $sales_order->cust_code = $request->input('customer_code');
            $sales_order->payment_term_id = $request->input('payment_term');
            $sales_order->currency_code = $request->input('currency_code');

            if($request->hasfile('customer_po_specs')) 
            { 
                $file = $request->file('customer_po_specs');
                $extension = $file->getClientOriginalExtension();
                $filename = $lastid.'.'.$extension;
                Storage::disk('sales_order')->put($filename, file_get_contents($file));
            }
                
            $sales_order->customer_po_specs = "storage/attachments/sales_order/".$filename;
            $sales_order->customer_po_no = $request->input('customer_po_no');
            $sales_order->status = 'Pending';

            if($request->input('details_prod_code')){
                $product_details = array();

                for( $i = 0 ; $i < count($request->input('details_prod_code')) ; $i++ ){
                    array_push($product_details, [ 'code' => $lastid,
                                                'prod_code' => $request->input('details_prod_code.'.$i),
                                                'prod_name' => $request->input('details_prod_name.'.$i),
                                                'uom_code' => $request->input('details_uom_code.'.$i),
                                                'currency_code' => $request->input('details_currency_code.'.$i),
                                                'unit_price' => $request->input('details_unit_price.'.$i),
                                                'quantity' => $request->input('details_quantity.'.$i),
                                                'total_price' => $request->input('details_total_price.'.$i)
                                            ]);
                }

                SalesProductList::insert($product_details);
                $product_details = json_encode($product_details);
                $sales_order->products = $product_details;
            }

            $matrix = ApproverMatrix::where('module','Sales Order')
                                    ->where('requestor',Auth::user()->emp_no)
                                    ->first();
            $matrix = json_decode($matrix->matrix);

            $sales_order->created_by = Auth::user()->emp_no;
            $sales_order->current_sequence = 0;
            $sales_order->current_approver = $matrix[0]->approver_emp_no;
            $sales_order->matrix = json_encode($matrix);

            if($sales_order->save()){
                return redirect()->route('order.index')->withSuccess('Sales Order Successfully Added!');
            }

        }
    }

    
    public function test(Request $request)
    {
        //
        return $request->input('test');
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
