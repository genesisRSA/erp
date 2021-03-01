<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\SalesForecast;
use App\ApproverMatrix;
use App\Product;
use App\Site;
use App\Currency;
use App\UnitOfMeasure;
use Validator;

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
            "data" => SalesForecast::all()
        ]); 
    }

    public function all_approval()
    {
        return response()
        ->json([
            "data" => SalesForecast::all()
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
        $field = [
            'unit_price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
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
                    }

                    $approvers = json_encode($approvers);            
                    $forecast->matrix = $approvers;
            }

            if($forecast->save()){
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
        $data = SalesForecast::find($id);
        return response()
        ->json([
            "data" => $data
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
            'unit_price' => 'required',
            'add_quantity' => 'required',
            'total_price' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator);
        }else{
            $forcas = SalesForecast::find($request->input('id',''));
            $forcas->forecast_code = $request->input('forecast_code','');
            $forcas->forecast_month = $request->input('forecast_month','');
            $forcas->forecast_year = $request->input('forecast_year','');
            $forcas->site_code =  Str::upper($request->input('site_code',''));
            $forcas->prod_code = Str::upper($request->input('prod_code',''));
            $forcas->currency_code = Str::upper($request->input('currency_code',''));
            $forcas->uom_code = $request->input('uom_code','');
            $forcas->unit_price= $request->input('unit_price','');
            $forcas->quantity = $request->input('quantity','');
            $forcas->total_price = $request->input('total_price','');
            $forcas->status = 'Pending';
            $forcas->created_by = '0204-2021';

            if($forcas->save()){
                return redirect()->route('forecast.index')->withSuccess('Sales Forecast Details Successfully Updated');
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
