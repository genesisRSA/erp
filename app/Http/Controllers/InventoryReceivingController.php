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
use App\Customer;
use App\Currency;
use App\Product;
use App\ItemMaster;
use App\ItemCategory;

use App\Inventory;
use App\InventoryLog;
use App\InventoryLocation;
use App\InventoryLocationType;
use App\InventoryReceiving;

use Validator;
use Response;
use Auth;
use PDF;

class InventoryReceivingController extends Controller
{
    public function index()
    {
        // $sku\ = Str::upper(Str::random(25));
        $sites = Site::all();
        $currency = Currency::all();
        $inventoryLocation = InventoryLocation::all();
        $receivingcount = InventoryReceiving::count();
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','Projects')
                        ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        $employees = Employee::where('emp_no',Auth::user()->emp_no)->first();
        return view('res.inventory_receiving.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','receiving')
                ->with('site', $sites) 
                ->with('currency', $currency)
                ->with('count', '00'.$receivingcount)
                ->with('inventloc', $inventoryLocation)
                ->with('permission',$permissionx)
                ->with('employee',$employees);
    }
    
    public function all($id)
    {
        $idx = Crypt::decrypt($id);
        $employee = Employee::where('emp_no', $idx)->first();
        return response()->json([
            "data" => InventoryReceiving::where('site_code',$employee->site_code)
                                        ->with('sites:site_code,site_desc')
                                        ->get()
        ]);
    }

    public function DR($dr_no)
    {
        return response()->json([
            "data" => InventoryReceiving::where('delivery_no',$dr_no)->get()
        ]);
    }

    public function create()
    {
        //
    }

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
            return redirect()->route('receiving.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('site_code');

            if($request->input('receiving_code') && $request->input('delivery_no') && $request->input('delivery_date') && $request->input('po_no'))
            {
                $invrcv = new InventoryReceiving();
                $invrcv->receiving_code =            Str::upper($request->input('receiving_code',''));
                $invrcv->site_code =                 Str::upper($request->input('site_code',''));
                $invrcv->invoice_no =                $request->input('invoice_no','');
                $invrcv->invoice_date =              $request->input('invoice_date','');
                $invrcv->delivery_no =               $request->input('delivery_no','');
                $invrcv->delivery_date =             $request->input('delivery_date','');
                $invrcv->po_no =                     $request->input('po_no','');
                $invrcv->remarks =                   $request->input('remarks','');
                $invrcv->status =                    'Received';
                $invrcv->created_by =                Auth::user()->emp_no;

                if($request->input('itm_item_code'))
                {
                    for($i = 0; $i < count($request->input('itm_item_code')); $i++)
                    {
                        $sku = Str::random('100');
                        $item = ItemMaster::where('item_code',$request->input('itm_item_code.'.$i))->first();
                        $item_exist = Inventory::where('item_code',$request->input('itm_item_code.'.$i))
                                                ->where('inventory_location_code', $request->input('itm_inventory_location.'.$i))
                                                ->first();
                        if($item_exist)
                        {
                            $item_exist->quantity =  $item_exist->quantity + $request->input('itm_quantity.'.$i);
                            $item_exist->updated_by = Auth::user()->emp_no;
                            $item_exist->save();
                        } else {
                            $inventory = new Inventory;
                            if($item){($item->is_serialized == 1 ? $inventory->sku = $sku : '' );};
                            $inventory->item_code = $request->input('itm_item_code.'.$i);
                            $inventory->inventory_location_code = $request->input('itm_inventory_location.'.$i);
                            $inventory->quantity = $request->input('itm_quantity.'.$i);
                            $inventory->created_by =  Auth::user()->emp_no;
                            $inventory->save();
                        }

                        $logs = new InventoryLog;
                        $logs->trans_code = Str::upper($request->input('receiving_code'));
                        $logs->trans_type = 'Receiving';
                        $logs->status = 'Received';
                        $logs->trans_date = date('Y-m-d H:i:s');
                        if($item){($item->is_serialized == 1 ? $logs->sku = $sku : '' );};
                        $logs->item_code = $request->input('itm_item_code.'.$i);
                        $logs->inventory_location_code = $request->input('itm_inventory_location.'.$i);
                        $logs->currency_code = $request->input('itm_currency_code.'.$i);
                        $logs->quantity = $request->input('itm_quantity.'.$i);
                        $logs->unit_price = $request->input('itm_unit_price.'.$i);
                        $logs->total_price = $request->input('itm_total_price.'.$i);
                        $logs->save();
                    }
                }

                if($invrcv->save()){
                    return redirect()->route('receiving.index')->withSuccess('Inventory Receiving Successfully Added');
                }
            } else {
                return redirect()->route('receiving.index')->withErrors('Please fill up all the Inventory Receiving details!');
            }            
        
        }
    }

    public function show($id)
    {
        $data = InventoryReceiving::find($id);
        return response()
            ->json([
                "data" => $data
            ]);
    }

    public function getCurrentStock($item_code, $item_loc_code)
    {
        $data = Inventory::where('item_code',$item_code)
                            ->where('inventory_location_code',$item_loc_code)
                            ->sum('quantity');

        return response()->json([
            "data" => ($data ? $data : 0)
        ]);
    }

    public function items($rcv_code)
    {
        return response()->json([
            "data" => InventoryLog::where('trans_code',$rcv_code)
                                ->with('currency:currency_code,currency_name,symbol')    
                                ->get()
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function patch(Request $request)
    {
        $field = [
            // 'item_cat_code' => 'required',
            // 'item_subcat_code' => 'required',
            // 'item_code' => 'required|unique:item_masters',
            // 'oem_partno' => 'unique:item_masters',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('receiving.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            if($request->input('delivery_no') && $request->input('delivery_date') && $request->input('po_no'))
            {
                $invrcv = InventoryReceiving::find($request->input('id'));
                $invrcv->receiving_code =            Str::upper($request->input('receiving_code',''));
                $invrcv->site_code =                 Str::upper($request->input('site_code',''));
                $invrcv->invoice_no =                $request->input('invoice_no','');
                $invrcv->invoice_date =              $request->input('invoice_date','');
                $invrcv->delivery_no =               $request->input('delivery_no','');
                $invrcv->delivery_date =             $request->input('delivery_date','');
                $invrcv->po_no =                     $request->input('po_no','');
                $invrcv->remarks =                   $request->input('remarks','');
                $invrcv->updated_by =                Auth::user()->emp_no;

                if($request->input('e_itm_item_code'))
                {
                    
                    for($i = 0; $i < count($request->input('e_itm_item_code')); $i++)
                    {
                        $sku = Str::random('100');
                        $item = ItemMaster::where('item_code',$request->input('e_itm_item_code.'.$i))->first();

                        $log_exist = InventoryLog::where('trans_code',$request->input('receiving_code',''))
                                                ->where('item_code',$request->input('e_itm_item_code.'.$i))
                                                ->where('inventory_location_code', $request->input('e_itm_inventory_location.'.$i))
                                                ->first();
                        // return $log_exist;

                        if($log_exist){ } else { 
                            $item = Inventory::where('item_code',$request->input('e_itm_item_code.'.$i))
                                        ->where('inventory_location_code', $request->input('e_itm_inventory_location.'.$i))
                                        ->first();
                            $item->quantity = $item->quantity + $request->input('e_itm_quantity.'.$i);
                            $item->save();

                            $logs = new InventoryLog;
                            $logs->trans_code = Str::upper($request->input('receiving_code'));
                            $logs->trans_type = 'Update Receiving';
                            $logs->status = 'Received';
                            $logs->trans_date = date('Y-m-d H:i:s');
                            if($item){($item->is_serialized == 1 ? $logs->sku = $sku : '' );};
                            $logs->item_code = $request->input('e_itm_item_code.'.$i);
                            $logs->inventory_location_code = $request->input('e_itm_inventory_location.'.$i);
                            $logs->currency_code = $request->input('e_itm_currency_code.'.$i);
                            $logs->quantity = $request->input('e_itm_quantity.'.$i);
                            $logs->unit_price = $request->input('e_itm_unit_price.'.$i);
                            $logs->total_price = $request->input('e_itm_total_price.'.$i);
                            $logs->save();
                        }
                            
                    }
                }

                if($invrcv->save()){
                    return redirect()->route('receiving.index')->withSuccess('Inventory Receiving Successfully Updated');
                }
            } else {
                return redirect()->route('receiving.index')->withErrors('Please fill up all the Inventory Receiving details!');
            }
        }
    }

    public function destroy($id)
    {
        //
    }
    
    public function delete(Request $request)
    {
        if(InventoryReceiving::destroy($request->input('id'))){
            return redirect()->route('receiving.index')->withSuccess('Inventory Receiving Successfully Deleted');
        }
    }
}
