<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\Employee;

class PagesController extends Controller
{

    //HRIS
    public function hris_index(){
        if (Auth::check()) {
            return redirect('/hris/home');
        }
        return view("pages.hris.index");
    }

    public function hris_home(){
        $bday = Employee::where('emp_no', '<>', 'admin')
                        ->whereMonth('dob', date('m'))
                        ->with('site:site_code,site_desc')
                        ->with('department:dept_code,dept_desc')
                        ->with('section:sect_code,sect_desc')
                        ->orderBy('emp_lname','ASC')
                        ->get()
                        ->each
                        ->append(['full_name','id_no']);

        $anniv = Employee::where('emp_no', '<>', 'admin')
                        ->where(DB::raw('YEAR(now())-YEAR(date_hired)'), '>=', '1')
                        ->whereMonth('date_hired', date('m'))
                        ->whereDay('date_hired', date('d'))
                        ->with('site:site_code,site_desc')
                        ->with('department:dept_code,dept_desc')
                        ->with('section:sect_code,sect_desc')
                        ->orderBy('emp_lname','ASC')
                        ->get()
                        ->each
                        ->append(['full_name','id_no']);

        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
            
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
            
        $this_week_sd = date("Y-m-d",$monday);
        $this_week_ed = date("Y-m-d",$sunday);
        $week_late = DB::connection('mysql_live')->select("CALL week_late('".$this_week_sd."','".$this_week_ed."')");
        $week_early = DB::connection('mysql_live')->select("CALL week_early('".$this_week_sd."','".$this_week_ed."')");
        
        return view("pages.hris.dashboard.home")
                    ->with(array('site'=> 'hris', 'page'=>'home'))
                    ->with('bday_celebrants',$bday)
                    ->with('anniv_celebrants',$anniv)
                    ->with('week_late',$week_late)
                    ->with('week_early',$week_early);
    }

    public function attendance(){
        if(Auth::user()->is_hr || Auth::user()->is_admin){
            return view("pages.hris.dashboard.attendance")
                    ->with(array('site'=> 'hris', 'page'=>'attendance'));
        }else{
            return redirect(route('hris.index'));
        }
    }

    public function myattendance(){
        return view("pages.hris.dashboard.myattendance")
                    ->with(array('site'=> 'hris', 'page'=>'my attendance'));  
    }

    public function team_attendance($id)
    {
        $employee = Employee::find(Crypt::decrypt($id));
        return view("pages.hris.dashboard.teamattendance")
                    ->with(array('site'=> 'hris', 
                                 'page'=>'team attendance',
                                 'name'=> $employee->full_name,
                                 'emp_photo'=> $employee->emp_photo,
                                 'access_id'=> $employee->access_id));  
    }

    public function timekeeping(){
        if(Auth::user()->is_hr || Auth::user()->is_admin){
            return view("pages.hris.dashboard.timekeeping")
                    ->with(array('site'=> 'hris', 'page'=>'timekeeping'));  
        }else{
            return redirect(route('hris.index'));
        }
    }

    public function costing(){
        return view("report");  
    }

    public function prreport(){
        return view("prreport");  
    }

    public function signage(){
        return view("signage");  
    }

    public function managesignage(){
        return view("managesignage");  
    }

    public function phpinfo(){
        return view("info");
    }

    public function wfh(){
        return view("wfhattendance")
                ->with('user',"")
                ->with('found', false);  
    }

    public function wfhcheck(Request $request){
        if($request->input('cancel','')){
            return redirect(route('wfh.attendance'));
        }

        if($request->input('transact','')){
            $trans_type = $request->input('transact','');

            if($trans_type == "time_in"){
                DB::connection('mysql_live')->table('rgc_webportal.attendance_wfh')->insert(
                    ['emp_code' => $request->input('emp_code',''), 'date_log' => date('Y-m-d'),
                    'time_in' => date('Y-m-d H:i:s'), 'temp_time_in' => 'MOBILEWFH']
                );
            }else{
                DB::connection('mysql_live')->table('rgc_webportal.attendance_wfh')
                ->where('emp_code', $request->input('emp_code'))
                ->where('date_log', date('Y-m-d'))
                ->update(
                    [$trans_type => date('Y-m-d H:i:s'), 'temp_'.$trans_type => 'MOBILEWFH']
                );
            }

            return redirect(route('wfh.attendance'));
        }

        $user = DB::connection('mysql_live')->table('rgc_webportal.temp_emp')->where('emp_code','=', $request->input('emp_no',''))->get();
        if(count($user)>0){
            $today_log = DB::connection('mysql_live')->table('rgc_webportal.attendance_wfh')
                        //->select('SELECT emp_code,date_log,, , , , , , , ')
                        ->select('emp_code','date_log',
                        DB::raw('TIME_FORMAT(time_in,"%h:%i %p") as time_in'),
                        DB::raw('TIME_FORMAT(ambreak_in,"%h:%i %p") as ambreak_in'),
                        DB::raw('TIME_FORMAT(ambreak_out,"%h:%i %p") as ambreak_out'),
                        DB::raw('TIME_FORMAT(lunch_in,"%h:%i %p") as lunch_in'),
                        DB::raw('TIME_FORMAT(lunch_out,"%h:%i %p") as lunch_out'),
                        DB::raw('TIME_FORMAT(pmbreak_in,"%h:%i %p") as pmbreak_in'),
                        DB::raw('TIME_FORMAT(pmbreak_out,"%h:%i %p") as pmbreak_out'),
                        DB::raw('TIME_FORMAT(time_out,"%h:%i %p") as time_out'))
                        ->where('emp_code','=', $request->input('emp_no',''))
                        ->where('date_log','=', date('Y-m-d'))->get();
            if(count($today_log) > 0){
                return view("wfhattendance")
                ->with('user',$user[0])
                ->with('found',true)
                ->with('today_log',$today_log[0]); 
            }else{
                return view("wfhattendance")
                ->with('user',$user[0])
                ->with('found',true); 
            }

            
        }else{
            return view("wfhattendance")
                ->with('user',"")
                ->with('found', false);  
        }

         
    }

    public function reports(){
        return view("pages.hris.dashboard.reports")
                    ->with(array('site'=> 'hris', 'page'=>'reports'));  
    }

    public function mytimekeeping(){
        return view("pages.hris.dashboard.mytimekeeping")
                    ->with(array('site'=> 'hris', 'page'=>'my timekeeping'));  
    }
    
    //AIS
    public function ics_index(){
        if (Auth::check()) {
            return redirect('/ics/home');
        }
        return view("pages.ics.index");
    }

    public function ics_home(){
        return view("pages.ics.home")
                    ->with(array('site'=> 'ics', 'page'=>'home'));
    }

    public function inventory(){
        return view("pages.ics.inventory")
                    ->with(array('site'=> 'ics', 'page'=>'inventory management'));
    }

    public function barcode(){
        return view("pages.ics.barcode")
                    ->with(array('site'=> 'ics', 'page'=>'item barcoding'));
    }


    //DCS
    public function dcs_index(){
        if (Auth::check()) {
            return redirect('/dcs/home');
        }
        return view("pages.dcs.index");
    }

    public function dcs_home(){
        return view("pages.dcs.home")
                    ->with(array('site'=> 'dcs', 'page'=>'home'));
    }




}
