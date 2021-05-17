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
use App\Product;
use App\ItemMaster;
use App\ItemCategory;

use App\InventoryLocation;
use App\InventoryLocationType;
use App\InventoryReceiving;

use Validator;
use Response;
use Auth;
use PDF;

class InventoryReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
        $sites = Site::all();
        $receivingcount = InventoryReceiving::count();
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','Projects')
                        ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.inventory_receiving.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','location')
                ->with('site', $sites) 
                ->with('count', '00'.$receivingcount)
                ->with('permission',$permissionx);
    }
    
    public function all($id)
    {
        return response()->json([
            "data" => InventoryReceiving::get()
        ]);
    }

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
            return redirect()->route('receiving.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
        
            $invrcv = new InventoryReceiving();
            $invrcv->receiving_code =            Str::upper($request->input('receiving_code',''));
            $invrcv->site_code =                 Str::upper($request->input('site_code',''));
            $invrcv->delivery_no =               $request->input('delivery_no','');
            $invrcv->delivery_date =             $request->input('delivery_date','');
            $invrcv->po_no =                     $request->input('po_no','');
            $invrcv->status =                    'Received';
            $invrcv->created_by =                Auth::user()->emp_no;

            if($invrcv->save()){
                return redirect()->route('receiving.index')->withSuccess('Inventory Receiving Successfully Added');
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
        $data = InventoryReceiving::find($id);
        return response()
            ->json([
                "data" => $data
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
        
            $invrcv = InventoryReceiving::find($request->input('id'));
            $invrcv->receiving_code =            Str::upper($request->input('receiving_code',''));
            $invrcv->site_code =                 Str::upper($request->input('site_code',''));
            $invrcv->delivery_no =               $request->input('delivery_no','');
            $invrcv->delivery_date =             $request->input('delivery_date','');
            $invrcv->po_no =                     $request->input('po_no','');
            // $invrcv->status =                    'Received';
            $invrcv->updated_by =                Auth::user()->emp_no;

            if($invrcv->save()){
                return redirect()->route('receiving.index')->withSuccess('Inventory Receiving Successfully Updated');
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
        if(InventoryReceiving::destroy($request->input('id'))){
            return redirect()->route('receiving.index')->withSuccess('Inventory Receiving Successfully Deleted');
        }
    }
}
