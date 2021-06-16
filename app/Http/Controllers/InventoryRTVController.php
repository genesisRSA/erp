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
use App\Vendor;
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
use App\InventoryRTV;

use Validator;
use Response;
use Auth;
use PDF;
use Image;
class InventoryRTVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::all();
        $vendors = Vendor::all();
        $currency = Currency::all();
        $inventoryLocation = InventoryLocation::all();
        $returnCount = InventoryRTV::count();
 
        $employees = Employee::orderBy('emp_lname')->get();
        $project = Project::where('status','<>','Pending')->get();

        $uom = UnitOfMeasure::all();

        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','RTV')
                        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        $receiving = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','RTV Receiving')
                        ->first();
        $receivingx =  ($receiving ? json_decode($receiving->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.inventory_rtv.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','vendor')
  
                ->with('employee',$employees)
                ->with('vendor',$vendors)
                ->with('projects', $project)
                ->with('sites', $sites)
                ->with('count', $returnCount)
                ->with('currency', $currency)
                ->with('inventloc', $inventoryLocation)
                ->with('permission',$permissionx)
                ->with('receiving',$receivingx);
    }

    public function all($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => InventoryRTV::where('requestor',$idx)
                                    ->with('employee_details:emp_no,emp_lname,emp_fname,emp_mname')
                                    ->with('sites:site_code,site_desc')
                                    ->get()
        ]);
    }

    public function all_approval($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => InventoryRTV::where('current_approver','=',$idx)
            ->where('status','<>','Approved')
            ->where('status','<>','Rejected')
            ->with('employee_details:emp_no,emp_fname,emp_lname')
            ->with('sites:site_code,site_desc')
            ->get()
        ]);
    }

    public function all_process()
    {
        return response()->json([
            "data" => InventoryRTV::where('status','Approved')
                                    ->with('employee_details:emp_no,emp_fname,emp_lname')
                                    ->with('sites:site_code,site_desc')
                                    ->get()
        ]);
    }

    public function all_receiving()
    {
        return response()->json([
            "data" => InventoryRTV::where('status','RTV')
                                    ->with('employee_details:emp_no,emp_fname,emp_lname')
                                    ->with('vendors:ven_code,ven_name')
                                    ->with('sites:site_code,site_desc')
                                    ->get()
        ]);
    }

    public function item_details($trans_code, $item_code)
    {
        return response()->json([
            "data" => InventoryLog::where('trans_code',$trans_code)
                                ->where('item_code',$item_code)
                                ->with('item_details:item_code,item_desc,uom_code')
                                ->first()
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
            return redirect()->route('return.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('status');

            if($request->input('rtv_code') && $request->input('reason') && $request->input('site_code'))
            {
                $invrtv = new InventoryRTV();
                $invrtv->rtv_code =           Str::upper($request->input('rtv_code',''));
                $invrtv->requestor =            Auth::user()->emp_no;
                $invrtv->site_code =             $request->input('site_code','');
                $invrtv->reason =                $request->input('reason','');
                $invrtv->status =                'Pending';

                $matrix = ApproverMatrix::where('module','RTV')
                                        ->where('requestor',Auth::user()->emp_no)
                                        ->first();
                if($matrix)
                {
                    $matrix = json_decode($matrix->matrix);
                    $invrtv->current_sequence = 0;
                    $invrtv->current_approver = $matrix[0]->approver_emp_no;
                    $invrtv->matrix = json_encode($matrix);
                } else {
                    return redirect()->route('issuance.index')->withErrors('Approver list is not defined! Please contact IT for support.');
                }  
    
                if($request->input('itm_item_code'))
                {
                    for($i = 0; $i < count($request->input('itm_item_code')); $i++)
                    {
        
                        $logs = new InventoryLog;
                        $logs->trans_code =              Str::upper($request->input('rtv_code'));
                        $logs->trans_type =              'Return to Vendor';
                        $logs->status =                  'Pending';
                        $logs->trans_date =              date('Y-m-d H:i:s');
                        $logs->item_code =               $request->input('itm_item_code.'.$i);
                        $logs->quantity =                $request->input('itm_quantity.'.$i);
                        
                        $logs->inventory_location_code = "";
                        $logs->sku =                     "";
                        $logs->currency_code =           "";
                        $logs->unit_price =              "";
                        $logs->total_price =             "";
                        $logs->save();
                    }
                }

                if($invrtv->save()){
                    return redirect()->route('rtv.index')->withSuccess('Inventory Return to Vendor Successfully Added');
                }

            } else {
                return redirect()->route('rtv.index')->withErrors('Please fill up all the Inventory Return to Vendor Details!');
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
        return response()
        ->json([
            "data" => InventoryRTV::where('id','=',$id)
                                ->with('employee_details:emp_no,emp_fname,emp_lname')
                                ->with('sites:site_code,site_desc')
                                ->with('vendors:ven_code,ven_name')
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
            return redirect()->route('return.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('rtv_code');

            if($request->input('rtv_code') && $request->input('reason') && $request->input('site_code'))
            {
                $invrtv = InventoryRTV::find($request->input('id'));
                $invrtv->rtv_code =                 Str::upper($request->input('rtv_code',''));
                $invrtv->site_code =                $request->input('site_code','');
                $invrtv->reason =                   $request->input('reason','');

                $matrix = ApproverMatrix::where('module','RTV')
                                        ->where('requestor',Auth::user()->emp_no)
                                        ->first();
                if($matrix)
                {
                    $matrix = json_decode($matrix->matrix);
                    $invrtv->current_sequence = 0;
                    $invrtv->current_approver = $matrix[0]->approver_emp_no;
                    $invrtv->matrix = json_encode($matrix);
                } else {
                    return redirect()->route('issuance.index')->withErrors('Approver list is not defined! Please contact IT for support.');
                }  
    
                if($request->input('e_itm_item_code'))
                {
                        $delLog = InventoryLog::where('trans_code',$invrtv->rtv_code)->delete();

                    for($i = 0; $i < count($request->input('e_itm_item_code')); $i++)
                    {
        
                        $logs = new InventoryLog;
                        $logs->trans_code =              Str::upper($request->input('rtv_code'));
                        $logs->trans_type =              'Return to Vendor';
                        $logs->status =                  'Pending';
                        $logs->trans_date =              date('Y-m-d H:i:s');
                        $logs->item_code =               $request->input('e_itm_item_code.'.$i);
                        $logs->quantity =                $request->input('e_itm_quantity.'.$i);
                        
                        $logs->inventory_location_code = "";
                        $logs->sku =                     "";
                        $logs->currency_code =           "";
                        $logs->unit_price =              "";
                        $logs->total_price =             "";
                        $logs->save();
                    }
                }

                if($invrtv->save()){
                    return redirect()->route('rtv.index')->withSuccess('Inventory Return to Vendor Successfully Updated');
                }

            } else {
                return redirect()->route('rtv.index')->withErrors('Please fill up all the Inventory Return to Vendor Details!');
            }            
        
        }
    }

    public function rtv_item(Request $request)
    {
        $field = [
                    // 'item_cat_code' => 'required',
                    // 'item_subcat_code' => 'required',
                    // 'item_code' => 'required|unique:item_masters',
                    // 'oem_partno' => 'unique:item_masters',
                ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('issuance.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

                $check_count = 0;
                $item_count = count($request->input('i_itm_item_code'));

                for($i = 0; $i < count($request->input('i_itm_item_code')); $i++)
                {
                    if($request->input('i_itm_inventory_location.'.$i) != null)
                    {
                        $check_count += 1;
                    }
                }

                // Inventory Issuance details update
                    $invrtv = InventoryRTV::where('rtv_code',$request->input('rtv_code'))->first();
                    $invrtv->ven_code = $request->input('vendor');
                if($item_count == $check_count){
                    $invrtv->status =               'RTV';
                    $invrtv->updated_by =           Auth::user()->emp_no;
                } else {
                    $invrtv->status =               'RTV with Pending';
                    $invrtv->updated_by =           Auth::user()->emp_no;
                }

                if($request->input('i_itm_item_code'))
                {  
                    for($i = 0; $i < count($request->input('i_itm_item_code')); $i++)
                    {
                        // Inventory logs update
                        $logx = InventoryLog::where('trans_code',$request->input('rtv_code'))
                                            ->where('item_code',$request->input('i_itm_item_code.'.$i))
                                            ->first();

                        // return $logx;

                        if($request->input('i_itm_inventory_location.'.$i) != null)
                        {
                            // Inventory update
                            $inv = Inventory::where('item_code',$request->input('i_itm_item_code.'.$i))
                                            ->where('inventory_location_code',$request->input('i_itm_inventory_location.'.$i))
                                            ->first();
                            $inv->quantity = $inv->quantity - $request->input('i_itm_quantity.'.$i);
                            $inv->updated_by =  Auth::user()->emp_no;
                            $inv->save();


                            $logs = new InventoryLog;
                            $logs->trans_code =              $logx->trans_code;
                            $logs->trans_type =              'RTV';
                            $logs->status =                  'Return to Vendor';
                            $logs->trans_date =              date('Y-m-d H:i:s');
                            $logs->item_code =               $request->input('i_itm_item_code.'.$i);
                            $logs->quantity =                $request->input('i_itm_quantity.'.$i);
    
                            $logs->sku =                     $logx->sku;
                            $logs->inventory_location_code = $request->input('i_itm_inventory_location.'.$i);
                            $logs->currency_code =           $logx->currency_code;
                            $logs->unit_price =              $logx->unit_price;
                            $logs->total_price =             $logx->total_price;
                            $logs->save();
                        }  
                    }
                }
                
                if($invrtv->save()){
                    return redirect()->route('rtv.index')->withSuccess('Return to Vendor Successfully Processed');
                }
        }
    }

    public function rcv_item(Request $request)
    {
        $field = [
            // 'item_cat_code' => 'required',
            // 'item_subcat_code' => 'required',
            // 'item_code' => 'required|unique:item_masters',
            // 'oem_partno' => 'unique:item_masters',
        ];

        $validator = Validator::make($request->all(), $field);
        
        if ($validator->fails()) {
            return redirect()->route('issuance.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // Inventory Issuance details update
            $invrtv = InventoryRTV::where('rtv_code',$request->get('rtv_code'))->first();
            $invrtv->status = 'Received';
            $invrtv->received_by = $request->get('received_by');
            $invrtv->received_date = date('Y-m-d H:i:s');

            $signature = str_replace('-','',$invrtv->rtv_code);
            
            $image = Image::make($request->get('imgBase64'));
            $image->save('../storage/app/documents/signatures/'.$invrtv->rtv_code.'.jpg'); 
            
            // if($request->input('i_itm_item_code'))
            // {  
            //     for($i = 0; $i < count($request->input('i_itm_item_code')); $i++)
            //     {
            //         // Inventory logs update
            //         $logx = InventoryLog::where('trans_code',$request->input('rtv_code'))
            //                             ->where('item_code',$request->input('i_itm_item_code.'.$i))
            //                             ->first();

            //         // return $logx;

            //         if($request->input('i_itm_inventory_location.'.$i) != null)
            //         {
            //             // Inventory update
            //             $inv = Inventory::where('item_code',$request->input('i_itm_item_code.'.$i))
            //                             ->where('inventory_location_code',$request->input('i_itm_inventory_location.'.$i))
            //                             ->first();
            //             $inv->quantity = $inv->quantity - $request->input('i_itm_quantity.'.$i);
            //             $inv->updated_by =  Auth::user()->emp_no;
            //             $inv->save();


            //             $logs = new InventoryLog;
            //             $logs->trans_code =              $logx->trans_code;
            //             $logs->trans_type =              'RTV';
            //             $logs->status =                  'Return to Vendor';
            //             $logs->trans_date =              date('Y-m-d H:i:s');
            //             $logs->item_code =               $request->input('i_itm_item_code.'.$i);
            //             $logs->quantity =                $request->input('i_itm_quantity.'.$i);

            //             $logs->sku =                     $logx->sku;
            //             $logs->inventory_location_code = $request->input('i_itm_inventory_location.'.$i);
            //             $logs->currency_code =           $logx->currency_code;
            //             $logs->unit_price =              $logx->unit_price;
            //             $logs->total_price =             $logx->total_price;
            //             $logs->save();
            //         }  
            //     }
            // }
            
            if($invrtv->save()){
                return redirect()->route('rtv.index')->withSuccess('Item Successfully Received by Vendor!');
            }
        }
    }

    public function approve(Request $request)
    {
        $field = [
            //'edit_app_module' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
                              
        if ($validator->fails()) {
            return  back()->withInput()
                            ->withErrors($validator);
        }else{

            $app_rtv = InventoryRTV::find($request->input('id'));
            $current_approver = json_decode($app_rtv->matrix)[0];
            $matrix = json_decode($app_rtv->matrix);
            array_splice($matrix,0,1);
            $matrix_h = json_decode($app_rtv->matrix_h) ? json_decode($app_rtv->matrix_h) : array();
            $status = $request->input('btnSubmit');
            $remarks = $request->input('remarks');

            // return $remarks;

            if($status == "Approved"){
            
                if($current_approver->is_gate == "true"){
                    $matrix = [];
                    $app_rtv->matrix = json_encode($matrix);
                    array_push($matrix_h,["sequence" => $app_rtv->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => "Approved",
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $app_rtv->status = "Approved";
                    $app_rtv->last_approved_by = Auth::user()->emp_no;

                    $invlog = InventoryLog::where('trans_code',$app_rtv->rtv_code)->get();
                    $invlog->status = "Approved";
                    $invlog->save();
                }else{
                    $app_rtv->matrix = json_encode($matrix);
                    $status = $matrix ? $current_approver->next_status : "Approved";
                    
                    array_push($matrix_h,["sequence" => $app_rtv->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => $status,
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $app_rtv->status = $status;
    
                    if(count($matrix) > 0){
                        $app_rtv->current_approver = $matrix[0]->approver_emp_no;
                        $app_rtv->current_sequence = $matrix[0]->sequence;
                    }else{
                        $app_rtv->current_approver = "";
                        $app_rtv->current_sequence = "";
                        $app_rtv->status = "Approved";
                        $app_rtv->last_approved_by = Auth::user()->emp_no;

                        // return $app_rtv->rtv_code;
                        // $invlog = InventoryLog::where('trans_code',$app_rtv->rtv_code)->get();
                        // $invlog->status = "Approved";
                        // $invlog->save();
                    }
                }
    
            }else{
                $matrix = [];
                $app_rtv->matrix = json_encode($matrix);
                array_push($matrix_h,["sequence" => $app_rtv->current_sequence,
                                      "approver_emp_no" => Auth::user()->emp_no,
                                      "approver_name" => Auth::user()->employee->full_name,
                                      "status" => "Rejected",
                                      "remarks" => $remarks,
                                      "action_date" => date('Y-m-d H:i:s')]);
                $app_rtv->current_approver = "";
                $app_rtv->current_sequence = "";
                $app_rtv->status = "Rejected";
                $app_rtv->last_approved_by = Auth::user()->emp_no;

            

                // $invlog = InventoryLog::where('trans_code',$app_rtv->rtv_code)->get();
                // $invlog->status = "Rejected";
                // $invlog->save();
            }
    
            $app_rtv->matrix_h = json_encode($matrix_h);
            $app_rtv->save();
        
            if($status=="Approved"){
                return redirect()->route('rtv.index')->withSuccess('Return to Vendor Successfully Approved');
            } else {
                return redirect()->route('rtv.index')->withSuccess('Return to Vendor Successfully Rejected');
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
}
