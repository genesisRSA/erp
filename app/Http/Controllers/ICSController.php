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
            return response()->json($datas[0],200);
        }else{
            return response()->json(array('error' => true, 'message' => 'No Record Found'));
        }
    }

    public function auth(Request $request){
        $username = $request->input('user_name');
        $password = $request->input('user_pass');
        $datas = DB::connection('mysql_ics')->select("CALL ics_db.auth_user('".$username."','".$password."')");
        if(count($datas)>0){
            return response()->json($datas[0], 200);
        }else{
            return response()->json(array('error' => true, 'message' => 'No Record Found'),501);
        }
    }

    public function search(Request $request){
        $search = $request->input('search');
        $datas = DB::connection('mysql_ics')->select("CALL ics_db.get_item_search('".$search."')");
        if(count($datas)>0){
            return response()->json(array('item_list' => $datas), 200);
        }else{
            return response()->json(array('error' => true, 'message' => 'No Record Found'),501);
        }
    }

    public function create_stock(Request $request){
        $qr_code = $request->input('qr_code');
        $item_id = $request->input('item_id');
        $item_qty = $request->input('item_qty');
        $item_location = $request->input('item_location');
        $last_updatedby = $request->input('last_updatedby');
        DB::connection('mysql_ics')->insert("CALL ics_db.create_stock('".$qr_code."','".$item_id."','".$item_qty."','".$item_location."','".$last_updatedby."')");
        return response()->json(array('success' => "Item received!"), 200);
    }

}
