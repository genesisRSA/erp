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
            "data" => SalesQuotation::all()
        ]); 
    }

    public function all_approval()
    {
        return response()
        ->json([
            "data" => SalesForecast::where('status','=','Pending')
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
                                ->with('product:prod_code,prod_name')
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
            'site_code' => 'required',
            'prod_code' => 'required',
            'uom_code' => 'required',
            'payment_term' => 'required',
            'currency_code' => 'required',
            'grand_total' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('forecast.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            $check = $request->input('f_forecast_code','');

            if($check)
            {

                $quotation = new SalesQuotation();
                $quotation->site_code = $request->input('f_site_code','');
                $quotation->quot_code = $request->input('f_quotation_code','');
                $quotation->cust_code = $request->input('4024','');
                $quotation->forecast_code = $request->input('f_forecast_code','');
                $quotation->payment_term_id = $request->input('f_payment_term','');
                $quotation->status = 'Pending';
                $quotation->created_by = '0204-2021';
                $quotation->current_sequence = $request->input('','');
                $quotation->current_approver = $request->input('','');
                
                if($request->input('app_seq'))
                {
                    $approvers = array();

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
                }

                if($quotation->save()){
                    return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Added');
                }

            }
            else
            {
                
                
                $quotation = new SalesQuotation();
                $quotation->site_code = $request->input('f_site_code','');
                $quotation->quot_code = $request->input('f_quotation_code','');
                $quotation->cust_code = $request->input('4024','');
                $quotation->forecast_code = $request->input('f_forecast_code','');
                $quotation->payment_term_id = $request->input('f_payment_term','');
                $quotation->status = 'Pending';
                $quotation->created_by = '0204-2021';
                $quotation->current_sequence = $request->input('','');
                $quotation->current_approver = $request->input('','');
                
                if($request->input('app_seq'))
                {
                    $approvers = array();

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
                }

                if($quotation->save()){
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
}
