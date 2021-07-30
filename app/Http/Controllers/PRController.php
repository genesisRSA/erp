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

use App\RFQHeader;
use App\RFQUser;
use App\RFQPurchasing;

use App\PRHeader;
use App\PRUser;

use Validator;
use Response;
use Auth;
use PDF;

class PRController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        $currency = Currency::all();
        $vendor = Vendor::all();
        $prcount = PRHeader::count();
        $employee = Employee::where('emp_no', Auth::user()->emp_no)->first();

        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Purchase Request')
        ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.purchasing_pr.index')
                ->with('site','res')
                ->with('page','purchasing')
                ->with('subpage','pr')
                ->with('sites',$sites)
                ->with('count',$prcount)
                ->with('currency',$currency)
                ->with('vendor',$vendor)
                ->with('permission',$permissionx)
                ->with('employee',$employee);
    }

    public function all($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => PRHeader::where('requestor','=',$idx)
            ->get()
        ]);
    }

    public function all_approval($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => PRHeader::where('current_approver','=',$idx)
            ->where('status','<>','Approved')
            ->where('status','<>','Rejected')
            ->with('employee_details:emp_no,emp_fname,emp_lname')
            ->get()
        ]);
    }

    public function all_items($pr_code)
    {
        return response()->json([
            "data" => PRUser::where('pr_code', $pr_code)
                            ->with('item_details:item_code,item_desc')
                            ->with('uoms:uom_code,uom_name')
                            ->with('currency:currency_code,currency_name,symbol')
                            ->get()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $field = [
            // 'pr_code' => 'required',
            // 'purpose' => 'required',
            // 'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('pr.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            if($request->input('pr_code') && $request->input('purpose') && $request->input('remarks'))
            {
                        $prHeader = new PRHeader();
                        $prHeader->pr_code =         Str::upper($request->input('pr_code',''));
                        $prHeader->date_requested =   date('Y-m-d H:i:s');
                        $prHeader->requestor =        Auth::user()->emp_no;
                        $prHeader->remarks =          $request->input('remarks','');      
                        $prHeader->status =           'Pending';

                if($request->input('purpose') == 'Project')
                {
                    if($request->input('project_code'))
                    {
                        $prHeader->purpose =          $request->input('purpose','');
                        $prHeader->project_code =     $request->input('project_code','');
 
                    } else {
                        return redirect()->route('pr.index')->withErrors('Please fill up all the Request for Quotation Details!');
                    }
                } else {
                        $prHeader->purpose =          $request->input('purpose','');
                }

                $matrix = ApproverMatrix::where('module','Purchase Request')
                                        ->where('requestor',Auth::user()->emp_no)
                                        ->first();
                if($matrix)
                {
                    $matrix = json_decode($matrix->matrix);
                    $prHeader->current_sequence = 0;
                    $prHeader->current_approver = $matrix[0]->approver_emp_no;
                    $prHeader->matrix = json_encode($matrix);
                } else {
                    return redirect()->route('pr.index')->withErrors('Approver list is not defined! Please contact IT for support.');
                }  
    
                if($request->input('itm_rfq_code'))
                {
                    for($i = 0; $i < count($request->input('itm_rfq_code')); $i++)
                    {
        
                        $prUser = new PRUser;
                        $prUser->pr_code =                 Str::upper($request->input('pr_code'));
                        $prUser->rfq_code =                $request->input('itm_rfq_code.'.$i);
                        
                        ($request->input('purpose') == 'Project' ? 
                        $prUser->assy_code =               $request->input('itm_assy_code.'.$i) : "");
        
                        $prUser->item_code =               $request->input('itm_item_code.'.$i);
                        $prUser->uom_code =                $request->input('itm_uom_code.'.$i);
                        $prUser->required_qty =            $request->input('itm_quantity.'.$i);
                        $prUser->unit_price =              $request->input('itm_unit_price.'.$i);
                        $prUser->currency_code =           $request->input('itm_curency_code.'.$i);
                        $prUser->save();
                    }
                }

                if($prHeader->save()){
                    return redirect()->route('pr.index')->withSuccess('Purchase Request Successfully Added!');
                }

            } else {
                return redirect()->route('pr.index')->withErrors('Please fill up all the Purchase Request Details!');
            }            
        
        }
    }

    public function show($id)
    {
        return response()
        ->json([
            "data" => PRHeader::where('id','=',$id)
                                ->with('projects:project_code,project_name')
                                ->get()
        ]);
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

            $appPR = PRHeader::find($request->input('id'));
            $current_approver = json_decode($appPR->matrix)[0];
            $matrix = json_decode($appPR->matrix);
            array_splice($matrix,0,1);
            $matrix_h = json_decode($appPR->matrix_h) ? json_decode($appPR->matrix_h) : array();
            $status = $request->input('btnSubmit');
            $remarks = $request->input('remarks');
            $type = $request->input('types');
    
            if($status == "Approved"){
            
                if($current_approver->is_gate == "true"){
                    $matrix = [];
                    $appPR->matrix = json_encode($matrix);
                    array_push($matrix_h,["sequence" => $appPR->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => "Approved",
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $appPR->status = "Approved";
                    $appPR->last_approved_by = Auth::user()->emp_no;
                }else{
                    $appPR->matrix = json_encode($matrix);
                    $statux = $matrix ? $current_approver->next_status : "Approved";
                    
                    array_push($matrix_h,["sequence" => $appPR->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => $statux,
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $appPR->status = $statux;
                    
                    if(count($matrix) > 0){
                        $appPR->current_approver = $matrix[0]->approver_emp_no;
                        $appPR->current_sequence = $matrix[0]->sequence;
                    }else{
                        $appPR->current_approver = "";
                        $appPR->current_sequence = "";
                        $appPR->status = "Approved";
                        $appPR->last_approved_by = Auth::user()->emp_no;
                    }
                }
    
            }else{
                $matrix = [];
                $appPR->matrix = json_encode($matrix);
                array_push($matrix_h,["sequence" => $appPR->current_sequence,
                                      "approver_emp_no" => Auth::user()->emp_no,
                                      "approver_name" => Auth::user()->employee->full_name,
                                      "status" => "Rejected",
                                      "remarks" => $remarks,
                                      "action_date" => date('Y-m-d H:i:s')]);
                $appPR->current_approver = "";
                $appPR->current_sequence = "";
                $appPR->status = "Rejected";
                $appPR->last_approved_by = Auth::user()->emp_no;

            }
    
            $appPR->matrix_h = json_encode($matrix_h);
            $appPR->save();

            if($status == "Approved"){
                return redirect()->route('pr.index')->withSuccess('Purchase Request Successfully Approved');
            } else {
                return redirect()->route('pr.index')->withSuccess('Purchase Request Successfully Rejected');
            }
        
        }
    }

    public function patch(Request $request)
    {
        $field = [
            // 'pr_code' => 'required',
            // 'purpose' => 'required',
            // 'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('pr.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            if($request->input('pr_code') && $request->input('purpose') && $request->input('remarks'))
            {
                $prheader = PRHeader::find($request->input('id'));
                $prheader->remarks =          $request->input('remarks','');      
   
                if($request->input('purpose') == 'Project')
                {
                    if($request->input('project_code'))
                    {
                        $prheader->purpose =          $request->input('purpose','');
                        $prheader->project_code =     $request->input('project_code','');
 
                    } else {
                        return redirect()->route('pr.index')->withErrors('Please fill up all the Request for Quotation Details!');
                    }
                } else {
                        $prheader->purpose =          $request->input('purpose','');
                }

 
                if($request->input('e_itm_rfq_code'))
                {
                    $delPRUser = PRUser::where('pr_code',$request->input('pr_code'))->delete();
                    for($i = 0; $i < count($request->input('e_itm_rfq_code')); $i++)
                    {
        
                        $prUser = new PRUser;
                        $prUser->pr_code =                 Str::upper($request->input('pr_code'));
                        $prUser->rfq_code =                $request->input('e_itm_rfq_code.'.$i);
                        
                        ($request->input('purpose') == 'Project' ? 
                        $prUser->assy_code =               $request->input('e_itm_assy_code.'.$i) : "");
        
                        $prUser->item_code =               $request->input('e_itm_item_code.'.$i);
                        $prUser->uom_code =                $request->input('e_itm_uom_code.'.$i);
                        $prUser->required_qty =            $request->input('e_itm_quantity.'.$i);
                        $prUser->unit_price =              $request->input('e_itm_unit_price.'.$i);
                        $prUser->currency_code =           $request->input('e_itm_curency_code.'.$i);
                        $prUser->save();
                    }
                }

                if($prheader->save()){
                    return redirect()->route('pr.index')->withSuccess('Request for Quotation Successfully Updated');
                }

            } else {
                return redirect()->route('pr.index')->withErrors('Please fill up all the Request for Quotation Details!');
            }            
        
        }
    }

    public function destroy($id)
    {
        //
    }
}
