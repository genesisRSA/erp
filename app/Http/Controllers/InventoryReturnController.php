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
use App\InventoryReturn;

use Validator;
use Response;
use Auth;
use PDF;
class InventoryReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::all();
        $currency = Currency::all();
        $inventoryLocation = InventoryLocation::all();
        $returnCount = InventoryReturn::count();
 
        $employees = Employee::orderBy('emp_lname')->get();
        $project = Project::where('status','<>','Pending')->get();

        $uom = UnitOfMeasure::all();

        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','Projects')
                        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.inventory_return.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','store')
  
                ->with('employee',$employees)
                ->with('projects', $project)
                ->with('sites', $sites)
                ->with('count', $returnCount)
                ->with('currency', $currency)
                ->with('inventloc', $inventoryLocation)
                ->with('permission',$permissionx);
    }

    public function all()
    {
        return response()->json([
            "data" => InventoryReturn::with('sites:site_code,site_desc')->get()
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
        $field = [
            // 'item_cat_code' => 'required',
            // 'item_subcat_code' => 'required',
            // 'item_code' => 'required|unique:item_masters',
            // 'oem_partno' => 'unique:item_masters',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('return.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('status');

            if($request->input('return_code') && $request->input('reason') && $request->input('site_code'))
            {
                        $invrtn = new InventoryReturn();
                        $invrtn->return_code =           Str::upper($request->input('return_code',''));
                        $invrtn->reason =                $request->input('reason','');
                        $invrtn->status =                'Returned';
                        $invrtn->site_code =             $request->input('site_code','');
                        $invrtn->created_by =            Auth::user()->emp_no;
    
                if($request->input('itm_item_code'))
                {
                    for($i = 0; $i < count($request->input('itm_item_code')); $i++)
                    {
        
                        $logs = new InventoryLog;
                        $logs->trans_code =              Str::upper($request->input('return_code'));
                        $logs->trans_type =              'Return to Store';
                        $logs->status =                  'Returned';
                        $logs->trans_date =              date('Y-m-d H:i:s');
                        $logs->item_code =               $request->input('itm_item_code.'.$i);
                        $logs->quantity =                $request->input('itm_quantity.'.$i);
                        $logs->inventory_location_code = $request->input('itm_inventory_location.'.$i);

                        $logs->sku =                     "";
                        $logs->currency_code =           "";
                        $logs->unit_price =              "";
                        $logs->total_price =             "";
                        $logs->save();

                        $upInv = Inventory::where('item_code',$request->input('itm_item_code.'.$i))
                                        ->where('inventory_location_code',$request->input('itm_inventory_location.'.$i))
                                        ->first();
                        // return $request->input('itm_inventory_location.'.$i);


                        $upInv->quantity = $upInv->quantity + $request->input('itm_quantity.'.$i);
                        $upInv->save();
                    }
                }

                if($invrtn->save()){
                    return redirect()->route('return.index')->withSuccess('Inventory Return Successfully Added');
                }

            } else {
                return redirect()->route('return.index')->withErrors('Please fill up all the Inventory Return Details!');
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
        return response()->json([
            "data" => InventoryReturn::where('id','=',$id)
                                    ->with('sites:site_code,site_desc')
                                    ->get()
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

    public function void(Request $request)
    {
        $voidrtn = InventoryReturn::find($request->input('id'));
        $voidrtn->status = 'Voided';

          if($request->input('vd_itm_item_code'))
                {
                    for($i = 0; $i < count($request->input('vd_itm_item_code')); $i++)
                    {
        
                        $logs = new InventoryLog;
                        $logs->trans_code =              Str::upper($request->input('return_code'));
                        $logs->trans_type =              'Void';
                        $logs->status =                  'Voided';
                        $logs->trans_date =              date('Y-m-d H:i:s');
                        $logs->item_code =               $request->input('vd_itm_item_code.'.$i);
                        $logs->quantity =                $request->input('vd_itm_quantity.'.$i);
                        $logs->inventory_location_code = $request->input('vd_itm_inventory_location.'.$i);

                        $logs->sku =                     "";
                        $logs->currency_code =           "";
                        $logs->unit_price =              "";
                        $logs->total_price =             "";
                        $logs->save();

                        $upInv = Inventory::where('item_code',$request->input('vd_itm_item_code.'.$i))
                                        ->where('inventory_location_code',$request->input('vd_itm_inventory_location.'.$i))
                                        ->first();
                        $upInv->quantity = $upInv->quantity - $request->input('vd_itm_quantity.'.$i);
                        $upInv->save();
                    }
                }

        if($voidrtn->save()){
            return redirect()->route('return.index')->withSuccess('Return Details Successfully Voided');
        }
    }
}
