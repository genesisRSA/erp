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
        $att_punches = DB::connection('mysql_live')->table('att_view')->get();

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
        $my_today_attendance = DB::connection('mysql_live')->select("CALL my_today_attendance('".$emp_id."','".$today."')");
        
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
        $my_attendance = DB::connection('mysql_live')->select("CALL my_attendance('".$emp_id."')");
        
        return response()
        ->json([
            "data" => $my_attendance
        ]);
    }
}
