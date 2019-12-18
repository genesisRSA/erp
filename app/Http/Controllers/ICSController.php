<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class ICSController extends Controller
{
    //
    public function users(){
        $datas = DB::connection('mysql_ics')->select("SELECT * from ics_db.users");

        return $datas;
    }

    public function authbycode(Request $request){
        $qrcode = $request->input('qr_code');
        $datas = DB::connection('mysql_ics')->select("CALL ics_db.auth_user_by_code('".$qrcode."')");
        if(count($datas)>0){
            return response()->json(json_encode($datas[0]));
        }else{
            return response()->json(json_encode(array('error' => 'Not Found')));
        }
    }

    public function auth(Request $request){
        $username = $request->input('user_name');
        $password = $request->input('user_pass');
        $datas = DB::connection('mysql_ics')->select("CALL ics_db.auth_user('".$username."','".$password."')");
        if(count($datas)>0){
            return response()->json(json_encode($datas[0]));
        }else{
            return response()->json(json_encode(array('error' => 'Not Found')));
        }
    }
}
