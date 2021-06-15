<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\SitePermission;
 
use App\Site;
use App\Employee;
use App\ApproverMatrix;
use App\Customer;
use App\Currency;
use App\Product;
use App\ItemMaster;
use App\ItemCategory;
use App\UnitOfMeasure;

use App\Project;
use App\Inventory;
use App\InventoryLog;
use App\InventoryLocation;
use App\InventoryLocationType;
use App\InventoryIssuance;

use Validator;
use Response;
use Auth;
use PDF;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('res.inventory_list.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','inventory');
    }

    public function all()
    {
        return response()->json([
            "data" => Inventory::with('loctype:location_code,location_name')
                                ->with('item_details:item_code,item_desc,uom_code,safety_stock,maximum_stock,warning_level')
                                ->get()
        ]);
    }
 
    
    public function items($trans_code)
    {
        return response()->json([
            "data" => InventoryLog::where('trans_code',$trans_code)
                                ->where('status','<>','Voided')
                                ->with('currency:currency_code,currency_name,symbol')   
                                ->with('item_details:item_code,item_desc') 
                                ->get()
        ]);
    }

    public function items_issued($trans_code)
    {
        return response()->json([
            "data" => InventoryLog::select(DB::raw('item_code, uom_conv_id, uom_code, SUM(quantity) as issued_qty'))
                                ->where('trans_code',$trans_code)
                                ->where('status','=','Issued with Pending')
                                ->groupBy('item_code')
                                ->groupBy('uom_code')
                                ->groupBy('uom_conv_id')
                                ->get()
        ]);
    }

    public function item_details($item_code, $loc_code)
    {
        return response()->json([
            "data" => Inventory::where('item_code',$item_code)
                                ->where('inventory_location_code',$loc_code)
                                ->with('item_details:item_code,item_desc,uom_code,cat_code,safety_stock,maximum_stock,warning_level,length,width,thickness,radius')
                                ->with('loctype:location_code,location_name')
                                // ->with(DB::select())
                                ->first()
        ]);
    }

    public function voided($trans_code)
    {
        return response()->json([
            "data" => InventoryLog::where('trans_code',$trans_code)
                                ->where('status','Voided')
                                ->with('currency:currency_code,currency_name,symbol')   
                                ->with('item_details:item_code,item_desc') 
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
}
