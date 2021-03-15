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
use App\ApproverMatrix;
use App\Product;
use App\Site;
use App\Currency;
use App\UnitOfMeasure;
use App\Employee;
use Validator;
use Auth;


class SalesForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site = Site::all();
        $product = Product::all();
        $uom = UnitOfMeasure::all();
        $currency = Currency::select('currency_code', 'currency_name', 'symbol')->get();
        $lastForecast = DB::table('sales_forecasts')->count();
        $today = date('Ymd');
        $foreCast = 'FORECAST';
        $lastForecastLeadZ = str_pad($lastForecast+1,4,"0",STR_PAD_LEFT);

        return view('res.forecast.index')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','forecast')
                ->with('sites', $site)
                ->with('products', $product)
                ->with('uoms', $uom)
                ->with('currencies', $currency)
                ->with('forecast', $foreCast)
                ->with('today', $today)
                ->with('lastforecast', $lastForecastLeadZ);
    }

    public function all()
    {
        return response()
        ->json([
            "data" => SalesForecast::with('products:prod_code,prod_name')
                        ->with('sites:site_code,site_desc')
                        ->get()
        ]); 
    }

    public function all_approval()
    {
        return response()
        ->json([
            "data" => SalesForecast::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                                  ->with('sites:site_code,site_desc')
                                  ->where('status','<>','Approved')
                                  ->where('status','!=','Rejected')
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

    public function getApproverMatrix($id)
    {   
        $data = SalesForecast::where('id','=',$id)->first();
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
            'currency_code' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
            'app_seq' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('forecast.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $forecast = new SalesForecast();
            $forecast->forecast_code = $request->input('forecast_code','');
            $forecast->forecast_month = $request->input('forecast_month','');
            $forecast->forecast_year = $request->input('forecast_year','');
            $forecast->site_code =  Str::upper($request->input('site_code',''));
            $forecast->prod_code = Str::upper($request->input('prod_code',''));
            $forecast->currency_code = Str::upper($request->input('currency_code',''));
            $forecast->uom_code = $request->input('uom_code','');
            $forecast->unit_price= $request->input('unit_price','');
            $forecast->quantity = $request->input('quantity','');
            $forecast->total_price = $request->input('total_price','');
            $forecast->status = 'Pending';
            $forecast->created_by = Auth::user()->employee->emp_no;

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
                            $forecast->current_sequence = $request->input('app_seq.'.$i);
                            $forecast->current_approver = $request->input('app_id.'.$i);
                            $approverID = $request->input('app_id.'.$i);
                        }
                    }

                    $approvers = json_encode($approvers);            
                    $forecast->matrix = $approvers;
            }

            // $forecast_details = $forecast;
            $lastid = DB::table('sales_forecasts')->latest('id')->first();

            if($lastid){
                $lastid = $lastid->id + 1;
            }else{
                $lastid = 0;
            }
            $approver = Employee::where('emp_no','=',$approverID)->first();

            $maildetails = new SalesMailable('REISS - Sales Forecast Approval',
                                            'forecast',
                                            'Pending',
                                            'approver',
                                            $approver->emp_fname,
                                            $request->input('forecast_code',''),
                                            Auth::user()->employee->full_name, // full_name
                                            '',
                                            $lastid); // remarks here

            if($forecast->save()){
                Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                // Mail::to($approver->work_email, $approver->full_name)

                return redirect()->route('forecast.index')->withSuccess('Sales Forecast Details Successfully Added');
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
            "data" => SalesForecast::where('id','=',$id)
                        ->with('currency:currency_code,currency_name')
                        ->with('products:prod_code,prod_name')
                        ->with('sites:site_code,site_desc')
                        ->with('currency:currency_code,currency_name,symbol')
                        ->with('uoms:uom_code,uom_name')
                        ->first()
        ]);
    }

    public function check($id,$loc)
    {
        $locx = $loc;
        $forecast = SalesForecast::where('forecast_code','=',$id)->first();
        $forecastID = $forecast->id;
        return redirect()->route('forecast.index', ['forecastID' => Crypt::encrypt($forecastID), 'loc' => $locx]);
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
            $forecast = SalesForecast::find($request->input('id',''));
            $forecast->forecast_code = $request->input('forecast_code','');
            $forecast->forecast_month = $request->input('forecast_month','');
            $forecast->forecast_year = $request->input('forecast_year','');
            $forecast->site_code =  Str::upper($request->input('site_code',''));
            $forecast->prod_code = Str::upper($request->input('prod_code',''));
            $forecast->currency_code = Str::upper($request->input('currency_code',''));
            $forecast->uom_code = $request->input('uom_code','');
            $forecast->unit_price= $request->input('unit_price','');
            $forecast->quantity = $request->input('quantity','');
            $forecast->total_price = $request->input('total_price','');
            $forecast->status = 'Pending';
            $forecast->created_by = '0204-2021';

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
                            $forecast->current_sequence = $request->input('app_seq.'.$i);
                            $forecast->current_approver = $request->input('app_id.'.$i);
                            $approverID = $request->input('app_id.'.$i);
                        }
                    }

                    $approvers = json_encode($approvers);            
                    $forecast->matrix = $approvers;
            }

            if($forecast->save()){
                return redirect()->route('forecast.index')->withSuccess('Sales Forecast Details Successfully Updated');
            }
        }
    }

    public function approve(Request $request)
    {
        $field = [
            //'edit_app_module' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
                              
        if ($validator->fails()) {
            return  back()->withInput()
                            ->withErrors($validator);
        }else{

            $forecast_app = SalesForecast::find($request->input('id', ''));
    
            $curr_id = $request->input('id','');
            $curr_seq = $request->input('seq','');
            $curr_app = $request->input('appid','');
            $curr_status = $forecast_app->status;
            $status = $request->input('status','');
            $remarks = $request->input('remarks','');
            
            $date = date('Y-m-d H:i:s');
            $curr_seq_db = $forecast_app->current_sequence;
            $matrix = json_decode($forecast_app->matrix, true);
            $matrixh = json_decode($forecast_app->matrix_h) ? json_decode($forecast_app->matrix_h) : array();

            $gate = $matrix[0]['is_gate'];
            $next_status = $matrix[0]['next_status'];

            $lastid = DB::table('sales_forecasts')->latest('id')->first();
            if($lastid){
                $lastid = $lastid->id + 1;
            }else{
                $lastid = 0;
            }
           
            $next_seq = $curr_seq + 1;
            $matlen = count($matrix);

            $empID = "";

            if($matlen!=1)
            {
                foreach ($matrix as $matrx) {
                    if($matrx['sequence']==$next_seq)
                    {
                        $empID = $matrx['approver_emp_no'];
                    }
                }
            }
            else 
            {
              $empID = $matrix[0]['approver_emp_no'];
            }

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
                    $forecast_app->status = 'Approved';
                    $forecast_app->approved_by = $curr_app;
                    $forecast_app->updated_by = $curr_app;
                    $matrix = [];
                    $approver = Employee::where('emp_no','=',$empID)->first();
                    $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                                                    'forecast', // location
                                                    'Approved', // next status val
                                                    'filer', // who to receive
                                                    $approver->emp_fname, // approver name
                                                    $forecast_app->forecast_code, // forecast code
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
                    $forecast_app->status = $next_status;
                    $forecast_app->approved_by = $curr_app;
                    $forecast_app->updated_by = $curr_app;
                    
                    $approver = Employee::where('emp_no','=',$empID)->first();
                    $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                                                    'forecast', // location
                                                    $next_status, // next status val
                                                    'approver', // who to receive
                                                    $approver->emp_fname, // approver name
                                                    $forecast_app->forecast_code, // forecast code
                                                    Auth::user()->employee->full_name, // full_name
                                                    $remarks, // remarks
                                                    $lastid); // last id + 1
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
                $forecast_app->status = 'Rejected';
                $forecast_app->approved_by = 'N/A';
                $forecast_app->updated_by = $curr_app;
                $matrix = [];
                
                $approver = Employee::where('emp_no','=',$empID)->first();
                $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                                                'forecast', // location
                                                'Rejected', // next status val
                                                'filer', // who to receive
                                                $approver->emp_fname, // approver name
                                                $forecast_app->forecast_code, // forecast code
                                                Auth::user()->employee->full_name, // full_name
                                                $remarks, // remarks
                                                $lastid); // last id + 1
            }
            
            $forecast_app->current_sequence = $curr_seq;
            $forecast_app->matrix = json_encode($matrix);
            $forecast_app->matrix_h = json_encode($matrixh);

            if($forecast_app->save()){
                if($status=='Approved'){
                    Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('forecast.index')->withSuccess('Sales Forecast Successfully Approved');
                } else {
                    Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('forecast.index')->withSuccess('Sales Forecast Successfully Rejected');
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
        if(SalesForecast::destroy($request->input('id',''))){
            return redirect()->route('forecast.index')->withSuccess('Sales Forecast Details Successfully Deleted');
        }
    }
}
