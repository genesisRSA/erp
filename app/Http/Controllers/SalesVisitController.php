<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Validator;
use App\SalesVisit;
use App\Site;
use Auth;


class SalesVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visit = SalesVisit::all();
        $site = Site::all();

        // $curr_ip = getHostByName(getHostName());
        // $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        // $myIPx = \Request::ip();
        // $myIP = getClientIPaddress(request::ip());
        // $getip = $_SERVER['REMOTE_ADDR'];

        return view('res.visit.index')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','visit')
                ->with('visits',$visit)
                ->with('sites',$site);
                // ->with('visit','VISIT')
                // ->with('today',$today)
                // ->with('lastVisit',$lastVisitx)
                // ->with('myIP', $myIPx);
    }

    public function all()
    {
        return response()
        ->json([
            "data" => SalesVisit::with('sites:site_code,site_desc')
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

        $today = date('Ymd');
        $lastVisit = DB::table('sales_visits')->count();
        $lastVisitx = str_pad($lastVisit+1,4,"0",STR_PAD_LEFT);
        $lastVisity = "VISIT".$today."-".$lastVisitx;

        $site = Site::all();
        return view('res.visit.new')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','visit')
                ->with('sites',$site)
                ->with('visit',$lastVisity);
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
            'visit_code' => 'required',
            'site_code' => 'required',
            'complete_address' => 'required',
            'visit_purpose' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('visit.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $today = date('Ymd');
            $visit = new SalesVisit();
            $visit->site_code =         $request->input('site_code','');
            $visit->visit_code =        $request->input('visit_code','');
            $visit->complete_address =  $request->input('complete_address','');
            $visit->visit_purpose =     $request->input('visit_purpose','');
            $visit->created_by =        Auth::user()->employee->emp_no;
            $visit->current_location =  $request->input('current_loc','');
            $visit->loc_longhitude =    $request->input('long','');
            $visit->loc_latitude =      $request->input('lat','');
            $visit->date_visit   =      $today;

            // return $today;

            if($visit->save()){
                return redirect()->route('visit.index')->withSuccess('Sales Visit Details Successfully Added');
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
            "data" => SalesVisit::where('id','=',$id)
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
        $visit = SalesVisit::where('id','=',$id)->first();
        $site = Site::all();
        return view('res.visit.edit')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','visit')
                ->with('sites',$site)
                ->with('visits',$visit);
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
        //
        $field = [
            // 'site_code' => 'required',
            // 'complete_address' => 'required',
            // 'visit_purpose' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
            ->withErrors($validator);
        }else{
            // return $request->input('visit_code');

            
            $e_visit =   SalesVisit::where('visit_code','=',$request->input('visit_code',''))->first();
            $e_visit->site_code =         $request->input('site_code','');
            $e_visit->complete_address =  $request->input('complete_address','');
            $e_visit->visit_purpose =     $request->input('visit_purpose','');
          
            if($e_visit->save()){
                return redirect()->route('visit.index')->withSuccess('Sales Visit Details Successfully Updated');
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
        if(SalesVisit::destroy($request->input('id',''))){
            return redirect()->route('visit.index')->withSuccess('Sales Visit Details Successfully Deleted');
        }
    }
}
