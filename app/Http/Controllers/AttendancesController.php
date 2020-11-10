<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    //
    public function index(){
        $att_punches = DB::connection('mysql_live')->table('att_view')->get();

        return response()
            ->json([
                "data" => $att_punches
            ]);
    }

    public function all(){
        $att_punches = DB::connection('mysql_live')->table('att_view')->where('att_date','>=',date('Y').'-01-01')->get();

        return response()
            ->json([
                "data" => $att_punches
            ]);
    }

    public function calc_all(){
        $att_punches = DB::connection('mysql_live')->select("CALL calc_att('".date('Y')."-01-01')");

        return response()
            ->json([
                "data" => $att_punches
            ]);
    }

    public function access_details($id){
        $access_details = DB::connection('mysql_live')->select("SELECT id as access_id,CONCAT(emp_lastname,', ',emp_firstname) as emp_name from hr_employee WHERE emp_active = 1 and id = ? ORDER BY emp_lastname",[$id]);


        return response()
            ->json([
                "data" => $access_details
            ]);
    }
    
    public function my_today($emp_id,$today){
        $my_today_attendance = DB::connection('mysql')->select("SELECT date_log, TIME_FORMAT(time_in,'%H:%i') as time_in, TIME_FORMAT(time_out,'%H:%i') as time_out,TIMEDIFF(time_out,time_in) as hours_work,TIMEDIFF(TIME_FORMAT(time_in,'%H:%i'),'08:00:00') as late FROM rgc_webportal.attendance WHERE emp_code = '$emp_id' AND date_log = '$today'");
        
        if(count($my_today_attendance) <= 0){
            return response()
            ->json([
                "error" => "No record found!"
            ]); 
        }else{
            return response()
            ->json([
                "data" => $my_today_attendance[0]
            ]);
        }
    }
    
    public function my_attendance($emp_id){
        $my_attendance = DB::connection('mysql')->select("SELECT date_log, TIME_FORMAT(time_in,'%H:%i') as time_in, TIME_FORMAT(time_out,'%H:%i') as time_out,TIMEDIFF(time_out,time_in) as hours_work,TIMEDIFF(TIME_FORMAT(time_in,'%H:%i'),'08:00:00') as late FROM rgc_webportal.attendance WHERE emp_code = '$emp_id' ORDER BY date_log DESC");
        
        return response()
        ->json([
            "data" => $my_attendance
        ]);
    }

    public function costing(){
        $costing = DB::connection('sqlsrv')->table("dbo.costing")->get();
        
        return response()
        ->json([
            "data" => $costing
        ]);
    }

    public function prreport(){
        $prreport = DB::connection('sqlsrv')->table("dbo.pr")->get();
        
        return response()
        ->json([
            "data" => $prreport
        ]);
    }

    public function av_attendance($date_from,$date_to){
        $my_attendance = DB::connection('mysql')->select("SELECT a.emp_code,CONCAT(b.emp_lname,', ',b.emp_fname) as emp_name,a.date_log,TIME_FORMAT(time_in,'%H:%i') as time_in,temp_time_in,TIME_FORMAT(lunch_in,'%H:%i') as lunch_in,temp_lunch_in,TIME_FORMAT(lunch_out,'%H:%i') as lunch_out,temp_lunch_out,TIME_FORMAT(time_out,'%H:%i') as time_out,temp_time_out FROM rgc_webportal.attendance a LEFT JOIN rgc_webportal.employees b ON b.emp_no = a.emp_code WHERE a.date_log  BETWEEN '".$date_from."' AND '".$date_to."'");
        
        return response()
        ->json([
            "data" => $my_attendance
        ]);
    }
}
