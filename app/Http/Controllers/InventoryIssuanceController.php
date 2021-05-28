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

class InventoryIssuanceController extends Controller
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
        $issuanceCount = InventoryIssuance::count();
 
        $employees = Employee::orderBy('emp_lname')->get();
        $project = Project::where('status','<>','Pending')->get();

        $uom = UnitOfMeasure::all();

        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','Projects')
                        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.inventory_issuance.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','issuance')
                ->with('employee',$employees)
                ->with('projects', $project)
                ->with('sites', $sites)
                ->with('count', $issuanceCount)
                ->with('currency', $currency)
                ->with('inventloc', $inventoryLocation)
                ->with('permission',$permissionx);
    }

    public function all($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => InventoryIssuance::where('requestor','=',$idx)
            ->get()
        ]);
    }

    public function all_approval($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => InventoryIssuance::where('current_approver','=',$idx)
            ->where('status','<>','Approved')
            ->where('status','<>','Rejected')
            ->with('employee_details:emp_no,emp_fname,emp_lname')
            ->get()
        ]);
    }

    public function issuance()
    {
        return response()->json([
            "data" => InventoryIssuance::where('status','<>','Pending')
            ->where('status','<>','For Approval')
            ->where('status','<>','For Review')
            ->where('status','<>','Issued')
            ->where('status','<>','Rejected')
            ->with('employee_details:emp_no,emp_fname,emp_lname')
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
            return redirect()->route('issuance.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            if($request->input('issuance_code') && $request->input('site_code') && $request->input('purpose'))
            {
                        $inviss = new InventoryIssuance();
                        $inviss->issuance_code =    Str::upper($request->input('issuance_code',''));
                        $inviss->site_code =        Str::upper($request->input('site_code',''));
                        $inviss->requestor =        Auth::user()->emp_no;
                        $inviss->status =           'Pending';
                        $inviss->created_by =       Auth::user()->emp_no;

                if($request->input('purpose') == 'Project')
                {
                    if($request->input('project_code') && $request->input('assy_code'))
                    {
                        $inviss->purpose =          $request->input('purpose','');
                        $inviss->project_code =     $request->input('project_code','');
                        $inviss->assy_code =        $request->input('assy_code','');
                    } else {
                        return redirect()->route('issuance.index')->withErrors('Please fill up all the Issuance Request Details!');
                    }
                } else {
                        $inviss->purpose =          $request->input('purpose','');
                }

                $matrix = ApproverMatrix::where('module','Issuance')
                                        ->where('requestor',Auth::user()->emp_no)
                                        ->first();
                if($matrix)
                {
                    $matrix = json_decode($matrix->matrix);
                    $inviss->current_sequence = 0;
                    $inviss->current_approver = $matrix[0]->approver_emp_no;
                    $inviss->matrix = json_encode($matrix);
                } else {
                    return redirect()->route('issuance.index')->withErrors('Approver list is not defined! Please contact IT for support.');
                }  
    
                if($request->input('itm_item_code'))
                {
                    for($i = 0; $i < count($request->input('itm_item_code')); $i++)
                    {
        
                        $logs = new InventoryLog;
                        $logs->trans_code =              Str::upper($request->input('issuance_code'));
                        $logs->trans_type =              'Issuance';
                        $logs->status =                  'Pending';
                        $logs->trans_date =              date('Y-m-d H:i:s');
                        $logs->item_code =               $request->input('itm_item_code.'.$i);
                        $logs->quantity =                $request->input('itm_quantity.'.$i);

                        $logs->sku =                     "";
                        $logs->inventory_location_code = "";
                        $logs->currency_code =           "";
                        $logs->unit_price =              "";
                        $logs->total_price =             "";
                        $logs->save();
                    }
                }

                if($inviss->save()){
                    return redirect()->route('issuance.index')->withSuccess('Issuance Request Successfully Added');
                }

            } else {
                return redirect()->route('issuance.index')->withErrors('Please fill up all the Issuance Request Details!');
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
                "data" => InventoryIssuance::where('id','=',$id)
                                            ->with('sites:site_code,site_desc')
                                            ->with('projects:project_code,project_name')
                                            ->with('assy:assy_code,assy_desc')
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

            $app_issuance = InventoryIssuance::find($request->input('id'));
            $current_approver = json_decode($app_issuance->matrix)[0];
            $matrix = json_decode($app_issuance->matrix);
            array_splice($matrix,0,1);
            $matrix_h = json_decode($app_issuance->matrix_h) ? json_decode($app_issuance->matrix_h) : array();
            $status = $request->input('btnSubmit');
            $remarks = $request->input('remarks');

            // return $remarks;

            if($status == "Approved"){
            
                if($current_approver->is_gate == "true"){
                    $matrix = [];
                    $app_issuance->matrix = json_encode($matrix);
                    array_push($matrix_h,["sequence" => $app_issuance->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => "Approved",
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $app_issuance->status = "Approved";
                    $app_issuance->last_approved_by = Auth::user()->emp_no;
                }else{
                    $app_issuance->matrix = json_encode($matrix);
                    $status = $matrix ? $current_approver->next_status : "Approved";
                    
                    array_push($matrix_h,["sequence" => $app_issuance->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => $status,
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $app_issuance->status = $status;
    
                    if(count($matrix) > 0){
                        $app_issuance->current_approver = $matrix[0]->approver_emp_no;
                        $app_issuance->current_sequence = $matrix[0]->sequence;
                    }else{
                        $app_issuance->current_approver = "";
                        $app_issuance->current_sequence = "";
                        $app_issuance->status = "Approved";
                        $app_issuance->last_approved_by = Auth::user()->emp_no;
                    }
                }
    
            }else{
                $matrix = [];
                $app_issuance->matrix = json_encode($matrix);
                array_push($matrix_h,["sequence" => $app_issuance->current_sequence,
                                      "approver_emp_no" => Auth::user()->emp_no,
                                      "approver_name" => Auth::user()->employee->full_name,
                                      "status" => "Rejected",
                                      "remarks" => $remarks,
                                      "action_date" => date('Y-m-d H:i:s')]);
                $app_issuance->current_approver = "";
                $app_issuance->current_sequence = "";
                $app_issuance->status = "Rejected";
                $app_issuance->last_approved_by = Auth::user()->emp_no;

                $invlog = InventoryLog::where('trans_code',$app_issuance->issuance_code)->first();
                $invlog->status = "Rejected";
                $invlog->save();
            }
    
            $app_issuance->matrix_h = json_encode($matrix_h);
            $app_issuance->save();
        
            if($status=="Approved"){
                return redirect()->route('issuance.index')->withSuccess('Issuance Request Successfully Approved');
            } else {
                return redirect()->route('issuance.index')->withSuccess('Issuance Request Successfully Rejected');
            }
        
        }
    }

    public function mail()
    {
            // $approver = Employee::where('emp_no','=',$empID)->first();
            // $maildetails = new SalesMailable('REISS - Sales issuance Approval', // subject
            //                                 'issuance', // location
            //                                 'Rejected', // next status val
            //                                 'filer', // who to receive
            //                                 $approver->emp_fname, // approver name
            //                                 $issuance_app->issuance_code, // issuance code
            //                                 Auth::user()->employee->full_name, // full_name
            //                                 $remarks, // remarks
            //                                 $lastid); // last id + 1
            // Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
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
            return redirect()->route('issuance.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            if($request->input('issuance_code') && $request->input('site_code') && $request->input('purpose'))
            {
                        $inviss = InventoryIssuance::find($request->input('id'));
                        $inviss->issuance_code =        Str::upper($request->input('issuance_code',''));
                        $inviss->site_code =            Str::upper($request->input('site_code',''));
                        $inviss->requestor =            Auth::user()->emp_no;
                        $inviss->status =               'Pending';
                        $inviss->created_by =           Auth::user()->emp_no;

                if($request->input('purpose') == 'Project')
                {
                    if($request->input('project_code') && $request->input('assy_code'))
                    {
                        $inviss->purpose =              $request->input('purpose','');
                        $inviss->project_code =         $request->input('project_code','');
                        $inviss->assy_code =            $request->input('assy_code','');
                    } else {
                        return redirect()->route('issuance.index')->withErrors('Please fill up all the Issuance Request Details!');
                    }
                } else {
                        $inviss->purpose =              $request->input('purpose','');
                        $inviss->project_code =         '';
                        $inviss->assy_code =            '';
                }


                if($request->input('e_itm_item_code'))
                {
                        $delLog = InventoryLog::where('trans_code',$request->input('issuance_code'))->delete();
                    for($i = 0; $i < count($request->input('e_itm_item_code')); $i++)
                    {
                        $sku = Str::random('100');
                        $item =                          ItemMaster::where('item_code',$request->input('e_itm_item_code.'.$i))->first();
                        
                        $logs = new InventoryLog;
                        $logs->trans_code =              Str::upper($request->input('issuance_code'));
                        $logs->trans_type =              'Issuance';
                        $logs->status =                  'Pending';
                        $logs->trans_date =              date('Y-m-d H:i:s');
                        $logs->item_code =               $request->input('e_itm_item_code.'.$i);
                        $logs->quantity =                $request->input('e_itm_quantity.'.$i);

                        $logs->sku =                     "";
                        $logs->inventory_location_code = "";
                        $logs->currency_code =           "";
                        $logs->unit_price =              "";
                        $logs->total_price =             "";
                        $logs->save();
                    }
                }

                if($inviss->save()){
                    return redirect()->route('issuance.index')->withSuccess('Issuance Request Successfully Added');
                }

            } else {
                return redirect()->route('issuance.index')->withErrors('Please fill up all the Issuance Request Details!');
            }            
        
        }
    }

    public function issue_item(Request $request)
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
                if($item_count == $check_count){
                    $inviss = InventoryIssuance::where('issuance_code',$request->input('issuance_code'))->first();
                    $inviss->status =               'Issued';
                    $inviss->updated_by =           Auth::user()->emp_no;
                } else {
                    $inviss = InventoryIssuance::where('issuance_code',$request->input('issuance_code'))->first();
                    $inviss->status =               'Issued with Pending';
                    $inviss->updated_by =           Auth::user()->emp_no;
                }

                if($request->input('i_itm_item_code'))
                {  
                    for($i = 0; $i < count($request->input('i_itm_item_code')); $i++)
                    {
                        // Inventory logs update
                        $logs = InventoryLog::where('trans_code',$request->input('issuance_code'))
                                            ->where('item_code',$request->input('i_itm_item_code.'.$i))
                                            ->first();

                        $logs->trans_date =              date('Y-m-d H:i:s');
                        if($request->input('i_itm_inventory_location.'.$i) != null)
                        {
                            // Inventory update
                            $inv = Inventory::where('item_code',$request->input('i_itm_item_code.'.$i))
                                            ->where('inventory_location_code',$request->input('i_itm_inventory_location.'.$i))
                                            ->first();
                            $inv->quantity = $inv->quantity - $request->input('i_itm_quantity.'.$i);
                            $inv->updated_by =  Auth::user()->emp_no;
                            $inv->save();

                            $logs->status =                  'Issued';
                            $logs->inventory_location_code = $request->input('i_itm_inventory_location.'.$i);
                            $logs->save();
                        } else {
                            $logs->status =                  'Pending';
                            $logs->inventory_location_code = "";
                            $logs->save();
                        }
                    }
                }
                
                if($inviss->save()){
                    return redirect()->route('issuance.index')->withSuccess('Issuance Request Successfully Added');
                }

           
        
        }
    }

    public function destroy($id)
    {
        //
    }
}
