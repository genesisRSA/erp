<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SalesMailable;
use App\SitePermission;
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
        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $site = Site::where('site_code','=',$employee->site_code)->get();

 
        $customer = Customer::all();
        $product = Product::all();
        $uom = UnitOfMeasure::all();
        $currency = Currency::select('currency_code', 'currency_name', 'symbol')->get();
        $lastQuotation = DB::table('sales_quotations')->count();
        $today = date('Ymd');
        $lastQuotationleadZ = str_pad($lastQuotation+1,4,"0",STR_PAD_LEFT);

        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                                    ->where('module','=','Sales Quotation')
                                    ->first();
                                    
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false}]', true));


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
                ->with('quotation', $Quotation)
                ->with('permission',$permissionx);
    }

    public function all($id)
    {
        $idx = Crypt::decrypt($id);

        return response()
        ->json([
            "data" => SalesQuotation::where('created_by','=',$idx)
                                    ->with('sites:site_code,site_desc')
                                    ->with('customers:cust_code,cust_name')
                                    ->get()
        ]); 
    }

    public function all_approval($id)
    {
        $idx = Crypt::decrypt($id);

        return response()
        ->json([
            "data" => SalesQuotation::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                                    ->with('sites:site_code,site_desc')
                                    ->with('customers:cust_code,cust_name')
                                    ->where('status','<>','Approved')
                                    ->where('status','<>','Rejected')
                                    ->where('status','<>','Voided')
                                    ->where('current_approver','=', $idx)
                                    ->get()
        ]); 
    }

    public function getApprover($id,$module)
    {   
        return response()
        ->json([
            "data" => DB::table('approver_matrices')
                            ->where([ 
                                ['requestor','=',$id],
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
            'ct_code' => 'required',
            'pt_code' => 'required',
            'c_code' => 'required',
            'grand_total' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('quotation.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            $check = $request->input('fc_code','x');

            if($check!='x')
            {
                $quotation = new SalesQuotation();
                $quotation->site_code = $request->input('site_code','');
                $quotation->quot_code = $request->input('quotation_code','');
                $quotation->cust_code = $request->input('ct_code','');
                $quotation->forecast_code = $request->input('fc_code','');
                $quotation->payment_term_id = $request->input('pt_code','');
                $quotation->currency_code = $request->input('c_code','');
                $quotation->status = 'Pending';
                $quotation->created_by = Auth::user()->employee->emp_no;
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
                                $approverID = $request->input('app_id.'.$i);
                            }
                        }
                        $approvers = json_encode($approvers);       
                        $quotation->matrix = $approvers;     

                        $products = new SalesProductList;
                        
                        for( $q = 0 ; $q < count($request->input('f_prod_code')) ; $q++ )
                        {
                             array_push($productlist, [
                                        'seq'           => $request->input('f_seq_code.'.$q),
                                        'code'          => $request->input('quotation_code',''),
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
                $lastid = DB::table('sales_quotations')->latest('id')->first();
                $approver = Employee::where('emp_no','=',$approverID)->first();
                if($lastid){
                    $lastid = $lastid->id + 1;
                }else{
                    $lastid = 0;
                }

                $forecast = SalesForecast::where('forecast_code','=',$request->input('fc_code'))->first();
                $forecast->status = 'Quoted';
                $forecast->save();
                
                $maildetails = new SalesMailable('REISS - Sales Quotation Approval',
                                            'quotation',
                                            'Pending',
                                            'approver',
                                            $approver->emp_fname,
                                            $request->input('quotation_code',''),
                                            Auth::user()->employee->full_name, // full_name
                                            '',
                                            $lastid); // remarks here
                if($quotation->save()){
                    Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Added');
                }
            }
            else
            {
                $quotationx = new SalesQuotation();
                $quotationx->site_code = $request->input('site_code','');
                $quotationx->quot_code = $request->input('quotation_code','');
                $quotationx->cust_code = $request->input('ct_code','');
                // $quotationx->forecast_code = $request->input('forecast_code','');
                $quotationx->payment_term_id = $request->input('pt_code','');
                $quotationx->currency_code = $request->input('c_code','');
                $quotationx->status = 'Pending';
                $quotationx->created_by = Auth::user()->employee->emp_no;
                if($request->input('app_seq'))
                {
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
                                $approverID  = $request->input('app_id.'.$i);
                            }
                        }
                        $approverx = json_encode($approverx);       
                        $quotationx->matrix = $approverx;     

           
                        for( $i = 0 ; $i < count($request->input('prod_code')) ; $i++ )
                        {
                             array_push($productlistx, [
                                        'seq'           => $request->input('seq_code.'.$i),
                                        'code'          => $request->input('quotation_code',''),
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
                $lastid = DB::table('sales_quotations')->latest('id')->first();
                $approver = Employee::where('emp_no','=',$approverID)->first();
                if($lastid){
                    $lastid = $lastid->id + 1;
                }else{
                    $lastid = 0;
                }

                $maildetails = new SalesMailable('REISS - Sales Quotation Approval',
                                            'quotation',
                                            'Pending',
                                            'approver',
                                            $approver->emp_fname,
                                            $request->input('quotation_code',''),
                                            Auth::user()->employee->full_name, // full_name
                                            '',
                                            $lastid); // remarks here
                if($quotationx->save()){
                    Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
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

    public function check($id,$loc)
    {
        $locx = $loc;
        $quotationX = SalesQuotation::where('quot_code','=',$id)
                                    ->where('current_approver','=',Auth::user()->emp_no)
                                    ->first();
        if($quotationX)
        {
            $quotationCode = $quotationX->id;
            return redirect()->route('quotation.index', ['quot_code' => Crypt::encrypt($quotationCode), 'loc' => $locx]);
        }
        else
        {
            return redirect()->route('quotation.index');
        }
    
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
        $today = date('Ymd');
        $field = [
            'currency_code' => 'required',
            'payment_term' => 'required',
            'grand_total' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator);
        }else{
            $quotex = SalesQuotation::find($request->input('id',''));
 
            $quotex->cust_code = $request->input('customer_code','');
            $quotex->forecast_code = $request->input('forecast_code','');
            $quotex->payment_term_id = $request->input('payment_term','');
            $quotex->currency_code = $request->input('currency_code','');
 
            if($request->input('app_seq'))
            {
       
                $approver_e = array();
                $productlist_e = array();

                    for( $i = 0 ; $i < count($request->input('app_seq')) ; $i++ )
                    {
                        array_push($approver_e, [
                                                'sequence' => $request->input('app_seq.'.$i),
                                                'approver_emp_no' => $request->input('app_id.'.$i),
                                                'approver_name' => $request->input('app_fname.'.$i),
                                                'next_status' => $request->input('app_nstatus.'.$i),
                                                'is_gate' => $request->input('app_gate.'.$i)
                                                ]);
                        if($request->input('app_seq.'.$i)==0) {
                            $quotex->current_sequence = $request->input('app_seq.'.$i);
                            $quotex->current_approver = $request->input('app_id.'.$i);
                        }
                    }

                    $approver_e = json_encode($approver_e);     
                    $quotex->matrix = $approver_e;     

       
                    for( $i = 0 ; $i < count($request->input('e_prod_code')) ; $i++ )
                    {
                         array_push($productlist_e, [
                                    'seq'           => $request->input('e_seq_code.'.$i),
                                    'quot_code'     => $request->input('quotation_code',''),
                                    'prod_code'     => $request->input('e_prod_code.'.$i),
                                    'prod_name'     => $request->input('e_prod_name.'.$i),
                                    'uom_code'      => $request->input('e_uom.'.$i),
                                    'currency_code' => $request->input('e_curr_code.'.$i),
                                    'unit_price'    => $request->input('e_unit_price.'.$i),
                                    'quantity'      => $request->input('e_quantity.'.$i),
                                    'total_price'   => $request->input('e_total_price.'.$i),
                                    'created_at'    => $today,
                                    'updated_at'    => $today,
                        ]);
                    }

                    SalesProductList::destroy($request->input('quotation_code',''));
                    SalesProductList::insert($productlist_e);
                    $productlist_e = json_encode($productlist_e);
                    $quotex->products = $productlist_e;     
            }
            if($quotex->save()){
                return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Updated');
            }
        }
    }

    public function approve(Request $request)
    {
        $field = [
            'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
                              
        if ($validator->fails()) {
            return  back()->withInput()
                            ->withErrors($validator);
        }else{

            $quotation_app = SalesQuotation::find($request->input('id', ''));
    
            $curr_id = $request->input('id','');
            $curr_seq = $request->input('seq','');
            $curr_app = $request->input('appid','');
            $curr_status = $quotation_app->status;
            $status = $request->input('status','');
            $remarks = $request->input('remarks','');
            
            $date = date('Y-m-d H:i:s');
            $curr_seq_db = $quotation_app->current_sequence;
            $matrix = json_decode($quotation_app->matrix, true);
            $matrixh = json_decode($quotation_app->matrix_h) ? json_decode($quotation_app->matrix_h) : array();

            $gate = $matrix[0]['is_gate'];
            $next_status = $matrix[0]['next_status'];

            $lastid = DB::table('sales_quotations')->latest('id')->first();
            if($lastid){
                $lastid = $lastid->id + 1;
            }else{
                $lastid = 0;
            }

            $next_seq = $curr_seq + 1;
            $matlen = count($matrix);
            $lastApproval = false;

            $empID = "";

            if($matlen!=1)
            {
                foreach ($matrix as $matrx) {
                    if($matrx['sequence']==$next_seq)
                    {
                        $empID = $matrx['approver_emp_no'];
                        $lastApproval = false;
                    }
                }
            }
            else 
            {
              $empID = $matrix[0]['approver_emp_no'];
              $lastApproval = true;
            }

            // return $lastApproval;
            
            if($status=='Approved')
            {
                if($gate=='true')
                { 
                    for($i=0; $i < count($matrix); $i++)
                    {
                        if($curr_seq==$curr_seq_db)
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => $status,
                                'remarks' => $remarks,
                                'action_date' => $date,
                            ]);
                            $curr_seq += 1;
                        }
                        else
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => 'Bypassed',
                                'remarks' => 'Bypassed',
                                'action_date' => $date,
                            ]);
                        }
                    }
                    $quotation_app->status = 'Approved';
                    $quotation_app->approved_by = $curr_app;
                    $quotation_app->updated_by = $curr_app;
                    $matrix = [];
                    $approver = Employee::where('emp_no','=',$empID)->first();
                    $maildetails = new SalesMailable('REISS - Sales Quotation Approval', // subject
                                                    'quotation', // location
                                                    'Approved', // next status val
                                                    'filer', // who to receive
                                                    $approver->emp_fname, // approver name
                                                    $quotation_app->quot_code, // quotation code
                                                    Auth::user()->employee->full_name, // full_name
                                                    $remarks, // remarks
                                                    $lastid); // last id + 1
                }
                else 
                {
                    if($lastApproval==true)
                    {
                        array_push($matrixh,[
                            'sequence' => $curr_seq,
                            'approver_emp_no' => $curr_app,
                            'approver_name' => $matrix[0]['approver_name'],
                            'status' => $curr_status,
                            'remarks' => $remarks,
                            'action_date' => $date,
                        ]);
                        $curr_seq += 1;
                        array_splice($matrix,0,1);
                        $quotation_app->status = $next_status;
                        $quotation_app->approved_by = $curr_app;
                        $quotation_app->updated_by = $curr_app;
    
                        $approver = Employee::where('emp_no','=',$empID)->first();
                        $maildetails = new SalesMailable('REISS - Sales Quotation Approval', // subject
                                                        'quotation', // location
                                                        'Approved', // next status val
                                                        'filer', // who to receive
                                                        $approver->emp_fname, // approver name
                                                        $quotation_app->quot_code, // quotation code
                                                        Auth::user()->employee->full_name, // full_name
                                                        $remarks, // remarks
                                                        $lastid); // last id + 1
                    }
                    else
                    {
                        array_push($matrixh,[
                            'sequence' => $curr_seq,
                            'approver_emp_no' => $curr_app,
                            'approver_name' => $matrix[0]['approver_name'],
                            'status' => $curr_status,
                            'remarks' => $remarks,
                            'action_date' => $date,
                        ]);
                        $curr_seq += 1;
                        array_splice($matrix,0,1);
                        $quotation_app->status = $next_status;
                        $quotation_app->approved_by = $curr_app;
                        $quotation_app->updated_by = $curr_app;
    
                        $approver = Employee::where('emp_no','=',$empID)->first();
                        $maildetails = new SalesMailable('REISS - Sales Quotation Approval', // subject
                                                        'quotation', // location
                                                        $next_status, // next status val
                                                        'approver', // who to receive
                                                        $approver->emp_fname, // approver name
                                                        $quotation_app->quot_code, // quotation code
                                                        Auth::user()->employee->full_name, // full_name
                                                        $remarks, // remarks
                                                        $lastid); // last id + 1
                    }
                }
            }
            else
            {
                for($i=0; $i < count($matrix); $i++)
                    {
                        if($curr_seq==$curr_seq_db)
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => $curr_status,
                                'remarks' => $remarks,
                                'action_date' => $date,
                            ]);
                            $curr_seq += 1;
                        }
                        else
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => 'Bypassed',
                                'remarks' => 'Bypassed',
                                'action_date' => $date,
                            ]);
                        }
                    }
                $quotation_app->status = 'Rejected';
                $quotation_app->approved_by = 'N/A';
                $quotation_app->updated_by = $curr_app;
                $matrix = [];

                $approver = Employee::where('emp_no','=',$empID)->first();
                $maildetails = new SalesMailable('REISS - Sales Quotation Approval', // subject
                                                'quotation', // location
                                                'Rejected', // next status val
                                                'filer', // who to receive
                                                $approver->emp_fname, // approver name
                                                $quotation_app->quot_code, // quotation code
                                                Auth::user()->employee->full_name, // full_name
                                                $remarks, // remarks
                                                $lastid); // last id + 1
            }
            
            $quotation_app->current_sequence = $curr_seq;
            $quotation_app->matrix = json_encode($matrix);
            $quotation_app->matrix_h = json_encode($matrixh);

            if($quotation_app->save()){
                if($status=='Approved'){
                    Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('quotation.index')->withSuccess('Sales Quotation Successfully Approved');
                } else {
                    Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('quotation.index')->withSuccess('Sales Quotation Successfully Rejected');
                }
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

    public function void(Request $request)
    {
        $quotation = SalesQuotation::find($request->input('id'));
        $quotation->status = 'Voided';
        $quotation->updated_by = Auth::user()->emp_no;

        if($quotation->save()){
            return redirect()->route('quotation.index')->withSuccess('Sales Quotation Details Successfully Voided');
        }
    }

    
}
