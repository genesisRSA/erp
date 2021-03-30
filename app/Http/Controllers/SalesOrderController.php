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
use App\ApproverMatrix;
use App\Currency;
use App\Customer;
use App\Employee;
use App\PaymentTerm;
use App\Product;
use App\SalesForecast;
use App\SalesOrder;
use App\SalesProductList;
use App\SalesQuotation;
use App\Site;
use App\UnitOfMeasure;
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
        $site = Site::where('site_code',Auth::user()->employee->site_code)->get();
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


    public function all_approval($emp_no)
    {
        
        $emp_no = Crypt::decrypt($emp_no);

        return response()
        ->json([
            "data" => SalesOrder::where('current_approver','=',$emp_no)
                        ->whereNotIn('status',['Approved','Delivered','Project Ongoing','Voided'])
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
            'customer_code' => 'required',
            'currency_code' => 'required',
            'payment_term' => 'required',
            'customer_po_specs' => 'required',
            'customer_po_no' => 'required'
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
            if($request->input('quotation_code')){
                $quot = SalesQuotation::where('quot_code',$request->input('quotation_code'))->first();
                $quot->status = "Ordered";
                $forecast = SalesForecast::where('forecast_code',$quot->forecast_code)->first();
                $forecast->status = "Ordered";
                $forecast->save();
                $quot->save();
            }
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
                
            $sales_order->customer_po_specs = $filename;
            $sales_order->customer_po_no = $request->input('customer_po_no');
            $sales_order->status = 'Pending';

            if($request->input('details_prod_code')){
                $product_details = array();
                $product_details_display = array();

                for( $i = 0 ; $i < count($request->input('details_prod_code')) ; $i++ ){
                    array_push($product_details_display, [ 'code' => $lastid,
                                                'prod_code' => $request->input('details_prod_code.'.$i),
                                                'prod_name' => $request->input('details_prod_name.'.$i),
                                                'uom' => $request->input('details_uom.'.$i),
                                                'uom_code' => $request->input('details_uom_code.'.$i),
                                                'currency' => $request->input('details_currency.'.$i),
                                                'currency_code' => $request->input('details_currency_code.'.$i),
                                                'unit_price' => $request->input('details_unit_price.'.$i),
                                                'quantity' => $request->input('details_quantity.'.$i),
                                                'total_price' => $request->input('details_total_price.'.$i)
                                            ]);
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
                $product_details = json_encode($product_details_display);
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
    
    public function approve(Request $request)
    {
        $sales_order = SalesOrder::find($request->input('id'));
        $current_approver = json_decode($sales_order->matrix)[0];
        $current_matrix = json_decode($sales_order->matrix);
        array_splice($current_matrix,0,1);
        $matrix_h = json_decode($sales_order->matrix_h) ? json_decode($sales_order->matrix_h) : array();
        $status = $request->input('btnSubmit');
        $remarks = $request->input('remarks');

        if($status = "Approved"){
            
            if($current_approver->is_gate == "true"){
                $sales_order->matrix = null;
                array_push($matrix_h,["sequence" => $sales_order->current_sequence,
                                      "approver_emp_no" => Auth::user()->emp_no,
                                      "approver_name" => Auth::user()->employee->full_name,
                                      "status" => "Approved",
                                      "remarks" => $remarks,
                                      "action_date" => date('Y-m-d H:i:s')]);
                $sales_order->status = "Approved";
            }else{
                $sales_order->matrix = json_encode($current_matrix);
                $status = $current_matrix ? $current_approver->next_status : "Approved";
                
                array_push($matrix_h,["sequence" => $sales_order->current_sequence,
                                      "approver_emp_no" => Auth::user()->emp_no,
                                      "approver_name" => Auth::user()->employee->full_name,
                                      "status" => $status,
                                      "remarks" => $remarks,
                                      "action_date" => date('Y-m-d H:i:s')]);
                $sales_order->status = $status;

                if(count($current_matrix) > 0){
                    $sales_order->current_approver = $current_matrix[0]->approver_emp_no;
                    $sales_order->current_sequence = $current_matrix[0]->sequence;
                }else{
                    $sales_order->current_approver = "";
                    $sales_order->current_sequence = 0;
                    $sales_order->status = "Approved";
                }
            }

        }else{
            $sales_order->matrix = [];
            array_push($matrix_h,["sequence" => $sales_order->current_sequence,
                                  "approver_emp_no" => Auth::user()->emp_no,
                                  "approver_name" => Auth::user()->employee->full_name,
                                  "status" => "Rejected",
                                  "remarks" => $remarks,
                                  "action_date" => date('Y-m-d H:i:s')]);
            $sales_order->status = "Rejected";
        }

        $sales_order->matrix_h = json_encode($matrix_h);
        $sales_order->save();

        return $sales_order;


    }
    
    public function pospecs($filepath)
    {
        return Storage::disk('sales_order')->download($filepath);
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
        return response()
                ->json([
                        "data" => SalesOrder::where('id','=',$id)
                        ->with('sites:site_code,site_desc')
                        ->with('currency:currency_code,currency_name,symbol')
                        ->with('customers:cust_code,cust_name')
                        ->with('payment:id,term_name')
                        ->get()
                ]);
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
        $sales_order = SalesOrder::find($request->input('id'));
        $sales_order->status = 'Voided';
        if($sales_order->quot_code){
            $sales_quotation = SalesQuotation::where('quot_code', $sales_order->quot_code)->first();
            $sales_quotation->status = 'Voided';
            if($sales_quotation->forecast_code){
                $sales_forecast = SalesForecast::where('forecast_code', $sales_quotation->forecast_code)->first();
                $sales_forecast->status = 'Voided';
                $sales_forecast->save();
            }
            $sales_quotation->save();
        }

        if($sales_order->save()){
            return redirect()->route('order.index')->withSuccess('Sales Forecast Details Successfully Voided');
        }
    }
}
