<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
use Validator;

class SalesQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        return view('res.quotation.index')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','quotation')
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

    public function all()
    {
        return response()
        ->json([
            "data" => SalesQuotation::with('sites:site_code,site_desc')
                                    ->with('customers:cust_code,cust_name')
                                    ->get()
        ]); 
    }

    public function all_approval()
    {
        return response()
        ->json([
            "data" => SalesQuotation::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                                    ->with('sites:site_code,site_desc')
                                    ->with('customers:cust_code,cust_name')
                                    ->where('status','=','Pending')
                                    ->get()
        ]); 
    }

    public function getApprover($id,$module)
    {   
        return response()
        ->json([
            "data" => DB::table('approver_matrices')
                            ->where([ 
                                ['id','=',$id],
                                ['module','=',$module],
                                ])
                            ->first()
         
        ]);
    }

    public function getForecast($id)
    {   
        $data = SalesForecast::where('forecast_code','=',$id)
                                ->with('products:prod_code,prod_name')
                                ->with('currency:currency_code,currency_name,symbol')
                                ->with('sites:site_code,site_desc')
                                ->with('uoms:uom_code,uom_name')
                                ->first();
        return response()->json(['data' => $data]);
    }

    public function getApproverMatrix($id)
    {   
        $data = SalesQuotation::where('id','=',$id)->first();
        return response()->json(['data' => $data]);
    }

    public function getProducts($id)
    {
        $data = Product::where('site_code',$id)->get();
        return response()->json(['data' => $data]);
    }

    public function getAllEdit($id)
    {
        return response()
        ->json([
            "data" => SalesQuotation::where('quot_code','=',$id)
                        ->with('currency:currency_code,currency_name,symbol')
                        ->with('customers:cust_code,cust_name')
                        ->with('payment:id,term_name')
                        ->first()
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
        $today = date('Ymd');
        $field = [
            'site_code' => 'required',
            'prod_code' => 'required',
            'uom_code' => 'required',
            'payment_term' => 'required',
            'currency_code' => 'required',
            'grand_total' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('quotation.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            $check = $request->input('forecast_code','x');

            if($check!='x')
            {
                $quotation = new SalesQuotation();
                $quotation->site_code = $request->input('site_code','');
                $quotation->quot_code = $request->input('quotation_code','');
                $quotation->cust_code = '4024';
                $quotation->forecast_code = $request->input('forecast_code','');
                $quotation->payment_term_id = $request->input('payment_term','');
                $quotation->currency_code = $request->input('currency_code','');
                $quotation->status = 'Pending';
                $quotation->created_by = '0204-2021';  
                if($request->input('app_seq'))
                {
                    $approvers = array();
                    $productlist = array();

                        for( $i = 0 ; $i < count($request->input('app_seq')) ; $i++ )
                        {
                            array_push($approvers, [
                                                    'sequence' => $request->input('app_seq.'.$i),
                                                    'approver_emp_no' => $request->input('app_id.'.$i),
                                                    'approver_name' => $request->input('app_fname.'.$i),
                                                    'next_status' => $request->input('app_nstatus.'.$i),
                                                    'is_gate' => $request->input('app_gate.'.$i)
                                                    ]);
                            if($request->input('app_seq.'.$i)==0) {
                                $quotation->current_sequence = $request->input('app_seq.'.$i);
                                $quotation->current_approver = $request->input('app_id.'.$i);
                            }
                        }
                        $approvers = json_encode($approvers);       
                        $quotation->matrix = $approvers;     

                        $products = new SalesProductList;
                        
                        for( $q = 0 ; $q < count($request->input('f_prod_code')) ; $q++ )
                        {
                             array_push($productlist, [
                                        'seq'           => $request->input('f_seq_code.'.$q),
                                        'quot_code'     => $request->input('quotation_code',''),
                                        'prod_code'     => $request->input('f_prod_code.'.$q),
                                        'prod_name'     => $request->input('f_prod_name.'.$q),
                                        'uom_code'      => $request->input('f_uom.'.$q),
                                        'currency_code' => $request->input('f_currency_code.'.$q),
                                        'unit_price'    => $request->input('f_unit_price.'.$q),
                                        'quantity'      => $request->input('f_quantity.'.$q),
                                        'total_price'   => $request->input('f_total_price.'.$q),
                                        'created_at'    => $today,
                                        'updated_at'    => $today,
                            ]);
                        }  

 
                        SalesProductList::insert($productlist);
                        $productlist = json_encode($productlist);
                        $quotation->products = $productlist;     
                }
                if($quotation->save()){
                    return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Added');
                }
            }
            else
            {
                $quotationx = new SalesQuotation();
                $quotationx->site_code = $request->input('site_code','');
                $quotationx->quot_code = $request->input('quotation_code','');
                $quotationx->cust_code = '4024';
                $quotationx->forecast_code = $request->input('forecast_code','');
                $quotationx->payment_term_id = $request->input('payment_term','');
                $quotationx->currency_code = $request->input('currency_code','');
                $quotationx->status = 'Pending';
                $quotationx->created_by = '0204-2021';  
                if($request->input('app_seq'))
                {
                    //return $request->input('app_seq');
                    $approverx = array();
                    $productlistx = array();

                        for( $i = 0 ; $i < count($request->input('app_seq')) ; $i++ )
                        {
                            array_push($approverx, [
                                                    'sequence' => $request->input('app_seq.'.$i),
                                                    'approver_emp_no' => $request->input('app_id.'.$i),
                                                    'approver_name' => $request->input('app_fname.'.$i),
                                                    'next_status' => $request->input('app_nstatus.'.$i),
                                                    'is_gate' => $request->input('app_gate.'.$i)
                                                    ]);
                            if($request->input('app_seq.'.$i)==0) {
                                $quotationx->current_sequence = $request->input('app_seq.'.$i);
                                $quotationx->current_approver = $request->input('app_id.'.$i);
                            }
                        }
                        $approverx = json_encode($approverx);       
                        $quotationx->matrix = $approverx;     

           
                        for( $i = 0 ; $i < count($request->input('prod_code')) ; $i++ )
                        {
                             array_push($productlistx, [
                                        'seq'           => $request->input('seq_code.'.$i),
                                        'quot_code'     => $request->input('quotation_code',''),
                                        'prod_code'     => $request->input('prod_code.'.$i),
                                        'prod_name'     => $request->input('prod_name.'.$i),
                                        'uom_code'      => $request->input('uom.'.$i),
                                        'currency_code' => $request->input('curr_code.'.$i),
                                        'unit_price'    => $request->input('unit_price.'.$i),
                                        'quantity'      => $request->input('quantity.'.$i),
                                        'total_price'   => $request->input('total_price.'.$i),
                                        'created_at'    => $today,
                                        'updated_at'    => $today,
                            ]);
                        }
                        
   
                        SalesProductList::insert($productlistx);
                        $productlistx = json_encode($productlistx);
                        $quotationx->products = $productlistx;     
                }
                if($quotationx->save()){
                    return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Added');
                }
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()
        ->json([
            "data" => SalesQuotation::where('id','=',$id)
                        ->with('currency:currency_code,currency_name,symbol')
                        ->with('customers:cust_code,cust_name')
                        ->with('payment:id,term_name')
                        ->first()
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
        $field = [
            'currency_code' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator);
        }else{
            $quotx = SalesForecast::find($request->input('id',''));
            $quotx->forecast_code = $request->input('forecast_code','');
            $quotx->forecast_month = $request->input('forecast_month','');
            $quotx->forecast_year = $request->input('forecast_year','');
            $quotx->site_code =  Str::upper($request->input('site_code',''));
            $quotx->prod_code = Str::upper($request->input('prod_code',''));
            $quotx->currency_code = Str::upper($request->input('currency_code',''));
            $quotx->uom_code = $request->input('uom_code','');
            $quotx->unit_price= $request->input('unit_price','');
            $quotx->quantity = $request->input('quantity','');
            $quotx->total_price = $request->input('total_price','');
            $quotx->status = 'Pending';
            $quotx->created_by = '0204-2021';

            if($quotx->save()){
                return redirect()->route('quotation.index')->withSuccess('Sales Forecast Details Successfully Updated');
            }
        }
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
        if(SalesQuotation::destroy($request->input('id',''))){
            if(SalesProductList::destroy($request->input('quot',''))){
                return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Deleted');
            }
        }
    }
}
