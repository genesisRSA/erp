<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Validator;
use App\SalesVisit;
use App\Site;
// use Request;


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
        $lastVisit = DB::table('sales_visits')->count();
        $today = date('Ymd');
        $lastVisitx = str_pad($lastVisit+1,4,"0",STR_PAD_LEFT);
        $curr_ip = getHostByName(getHostName());
        $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        $myIPx = \Request::ip();
        // $myIP = getClientIPaddress(request::ip());

        $getip = $_SERVER['REMOTE_ADDR'];

        return view('res.visit.index')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','visit')
                ->with('visits',$visit)
                ->with('sites',$site)
                ->with('visit','VISIT')
                ->with('today',$today)
                ->with('lastVisit',$lastVisitx)
                ->with('myIP', $myIPx);
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
        $site = Site::all();
        return view('res.visit.new')
                ->with('site','res')
                ->with('page','sales')
                ->with('subpage','visit')
                ->with('sites',$site);
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
