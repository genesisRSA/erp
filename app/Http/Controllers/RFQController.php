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

use Validator;
use Response;
use Auth;
use PDF;

class RFQController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        $currency = Currency::all();
        $vendor = Vendor::all();
        $rfqcount = RFQHeader::count();
        $employee = Employee::where('emp_no', Auth::user()->emp_no)->first();
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','RFQ')
        ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.purchasing_rfq.index')
                ->with('site','res')
                ->with('page','purchasing')
                ->with('subpage','rfq')
                ->with('sites',$sites)
                ->with('count',$rfqcount)
                ->with('currency',$currency)
                ->with('vendor',$vendor)
                ->with('permission',$permissionx)
                ->with('employee',$employee);
    }

    public function all($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => RFQHeader::where('requestor','=',$idx)
            ->get()
        ]);
    }
    
    public function all_for_rfq()
    {
        return response()->json([
            "data" => RFQHeader::where('status','Pending')
            ->with('employee_details:emp_no,emp_fname,emp_lname')
            ->get()
        ]);
    }

    public function all_for_rev($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => RFQHeader::where('status','For User Review')
                                ->where('current_approver','=',$idx)
                                ->get()
        ]);
    }

    public function all_approval($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => RFQHeader::where('current_approver','=',$idx)
            ->where('status','<>','Pending')
            ->where('status','<>','Approved')
            ->where('status','<>','Rejected')
            ->where('status','<>','For User Review')
            ->with('employee_details:emp_no,emp_fname,emp_lname')
            ->get()
        ]);
    }

    public function items_user($rfq_code)
    {
        return response()->json([
            "data" => RFQUser::where('rfq_code',$rfq_code)
                                ->with('item_details:item_code,item_desc') 
                                ->with('uoms:uom_code,uom_name') 
                                ->with('rfq_status:rfq_code,status')
                                ->get()
        ]);
    }

    public function items_purch($rfq_code)
    {
        return response()->json([
            "data" => RFQPurchasing::where('rfq_code',$rfq_code)
                                ->with('item_details:item_code,item_desc') 
                                ->with('uoms:uom_code,uom_name') 
                                ->with('ven_details:ven_code,ven_name')
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
            // 'rfq_code' => 'required',
            // 'purpose' => 'required',
            // 'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('rfq.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('project_code');

            if($request->input('rfq_code') && $request->input('purpose') && $request->input('remarks'))
            {
                        $rfqheader = new RFQHeader();
                        $rfqheader->rfq_code =         Str::upper($request->input('rfq_code',''));
                        $rfqheader->date_requested =   date('Y-m-d H:i:s');
                        $rfqheader->requestor =        Auth::user()->emp_no;
                        $rfqheader->remarks =          $request->input('remarks','');      
                        $rfqheader->status =           'Pending';

                if($request->input('purpose') == 'Project')
                {
                    if($request->input('project_code'))
                    {
                        $rfqheader->purpose =          $request->input('purpose','');
                        $rfqheader->project_code =     $request->input('project_code','');
 
                    } else {
                        return redirect()->route('rfq.index')->withErrors('Please fill up all the Request for Quotation Details!');
                    }
                } else {
                        $rfqheader->purpose =          $request->input('purpose','');
                }

                $matrix = ApproverMatrix::where('module','RFQ')
                                        ->where('requestor',Auth::user()->emp_no)
                                        ->first();
                if($matrix)
                {
                    $matrix = json_decode($matrix->matrix);
                    $rfqheader->current_sequence = 0;
                    $rfqheader->current_approver = $matrix[0]->approver_emp_no;
                    $rfqheader->matrix = json_encode($matrix);
                } else {
                    return redirect()->route('rfq.index')->withErrors('Approver list is not defined! Please contact IT for support.');
                }  
    
                if($request->input('itm_item_code'))
                {
                    for($i = 0; $i < count($request->input('itm_item_code')); $i++)
                    {
        
                        $rfqUser = new RFQUser;
                        $rfqUser->rfq_code =                Str::upper($request->input('rfq_code'));
                        
                        ($request->input('purpose') == 'Project' ? 
                        $rfqUser->assy_code =               $request->input('itm_assy_code.'.$i) : "");
        
                        $rfqUser->item_code =               $request->input('itm_item_code.'.$i);
                        $rfqUser->uom_code =                $request->input('itm_uom_code.'.$i);
                        $rfqUser->required_qty =            $request->input('itm_quantity.'.$i);
                        $rfqUser->required_delivery_date =  $request->input('itm_delivery_date.'.$i);
                        $rfqUser->save();
                    }
                }

                if($rfqheader->save()){
                    return redirect()->route('rfq.index')->withSuccess('Request for Quotation Successfully Added');
                }

            } else {
                return redirect()->route('rfq.index')->withErrors('Please fill up all the Request for Quotation Details!');
            }            
        
        }
    }

    public function store_quote(Request $request)
    {
        $field = [
            // 'rfq_code' => 'required',
            // 'purpose' => 'required',
            // 'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('rfq.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
 

            $rfqheader = RFQHeader::where('rfq_code',$request->input('rfq_code'))->first();
            $rfqheader->status = "For User Review";


            if($request->input('qt_item_code'))
            {
                for($i = 0; $i < count($request->input('qt_item_code')); $i++)
                {
    
                    $rfqPurch = new RFQPurchasing;
                    $rfqPurch->rfq_code =                Str::upper($request->input('rfq_code'));
                    
                    ($request->input('purpose') == 'Project' ? 
                    $rfqPurch->assy_code =               $request->input('qt_assy_code.'.$i) : "");
    
                    $rfqPurch->item_code =               $request->input('qt_item_code.'.$i);
                    $rfqPurch->uom_code =                $request->input('qt_uom_code.'.$i);
                    $rfqPurch->required_qty =            $request->input('qt_required_qty.'.$i);
                    $rfqPurch->required_delivery_date =  $request->input('qt_required_delivery_date.'.$i);
                    $rfqPurch->status =                  $request->input('qt_status.'.$i);
                    $rfqPurch->ven_code =                $request->input('qt_ven_code.'.$i);
                    $rfqPurch->spq =                     $request->input('qt_spq.'.$i);
                    $rfqPurch->moq =                     $request->input('qt_moq.'.$i);
                    $rfqPurch->ven_delivery =            $request->input('qt_ven_delivery.'.$i);
                    $rfqPurch->leadtime =                $request->input('qt_leadtime.'.$i);
                    $rfqPurch->currency_code =           $request->input('qt_currency_code.'.$i);
                    $rfqPurch->unit_price =              $request->input('qt_unit_price.'.$i);
                    $rfqPurch->total_price =             $request->input('qt_spq.'.$i) *                                    $request->input('qt_moq.'.$i) *                                    $request->input('qt_unit_price.'.$i);
                    $rfqPurch->save();
                }
            }

            if($rfqheader->save()){
                return redirect()->route('rfq.index')->withSuccess('Request for Quotation Successfully Added');
            }

          
        
        }
    }

    public function show($id)
    {
        return response()
        ->json([
            "data" => RFQHeader::where('id','=',$id)
                                        // ->with('sites:site_code,site_desc')
                                        ->with('projects:project_code,project_name')
                                        // ->with('assy:assy_code,assy_desc')
                                        // ->with('employee_details:emp_no,emp_fname,emp_lname')
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

            $apprfq = RFQHeader::find($request->input('id'));
            $current_approver = json_decode($apprfq->matrix)[0];
            $matrix = json_decode($apprfq->matrix);
            array_splice($matrix,0,1);
            $matrix_h = json_decode($apprfq->matrix_h) ? json_decode($apprfq->matrix_h) : array();
            $status = $request->input('btnSubmit');
            $remarks = $request->input('remarks');
            // return $status;
            if($status == "Approved"){
            
                if($current_approver->is_gate == "true"){
                    $matrix = [];
                    $apprfq->matrix = json_encode($matrix);
                    array_push($matrix_h,["sequence" => $apprfq->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => "Approved",
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $apprfq->status = "Approved";
                    $apprfq->last_approved_by = Auth::user()->emp_no;
                }else{
                    $apprfq->matrix = json_encode($matrix);
                    $statux = $matrix ? $current_approver->next_status : "Approved";
                    
                    array_push($matrix_h,["sequence" => $apprfq->current_sequence,
                                          "approver_emp_no" => Auth::user()->emp_no,
                                          "approver_name" => Auth::user()->employee->full_name,
                                          "status" => $statux,
                                          "remarks" => $remarks,
                                          "action_date" => date('Y-m-d H:i:s')]);
                    $apprfq->status = $statux;
                    
                    // return count($matrix) ; 
                    if(count($matrix) > 0){
                        $apprfq->current_approver = $matrix[0]->approver_emp_no;
                        $apprfq->current_sequence = $matrix[0]->sequence;
                    }else{
                        $apprfq->current_approver = "";
                        $apprfq->current_sequence = "";
                        $apprfq->status = "Approved";
                        $apprfq->last_approved_by = Auth::user()->emp_no;
                    }
                }
    
            }else{
                $matrix = [];
                $apprfq->matrix = json_encode($matrix);
                array_push($matrix_h,["sequence" => $apprfq->current_sequence,
                                      "approver_emp_no" => Auth::user()->emp_no,
                                      "approver_name" => Auth::user()->employee->full_name,
                                      "status" => "Rejected",
                                      "remarks" => $remarks,
                                      "action_date" => date('Y-m-d H:i:s')]);
                $apprfq->current_approver = "";
                $apprfq->current_sequence = "";
                $apprfq->status = "Rejected";
                $apprfq->last_approved_by = Auth::user()->emp_no;

            }
    
            $apprfq->matrix_h = json_encode($matrix_h);
            $apprfq->save();
            // return $status;
            if($status == "Approved"){
                return redirect()->route('rfq.index')->withSuccess('Request for Quotation Successfully Approved');
            } else {
                return redirect()->route('rfq.index')->withSuccess('Request for Quotation Successfully Rejected');
            }
        
        }
    }

    public function patch(Request $request)
    {
        $field = [
            // 'rfq_code' => 'required',
            // 'purpose' => 'required',
            // 'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('rfq.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('purpose');

            if($request->input('rfq_code') && $request->input('purpose') && $request->input('remarks'))
            {
                $rfqheader = RFQHeader::find($request->input('id'));
                $rfqheader->remarks =          $request->input('remarks','');      
   
                if($request->input('purpose') == 'Project')
                {
                    if($request->input('project_code'))
                    {
                        $rfqheader->purpose =          $request->input('purpose','');
                        $rfqheader->project_code =     $request->input('project_code','');
 
                    } else {
                        return redirect()->route('rfq.index')->withErrors('Please fill up all the Request for Quotation Details!');
                    }
                } else {
                        $rfqheader->purpose =          $request->input('purpose','');
                }

                if($request->input('e_itm_item_code'))
                {
                    $delRFQUser = RFQUser::where('rfq_code',$request->input('rfq_code'))->delete();
                    for($i = 0; $i < count($request->input('e_itm_item_code')); $i++)
                    {
        
                        $rfqUser = new RFQUser;
                        $rfqUser->rfq_code =                Str::upper($request->input('rfq_code'));
                        
                        ($request->input('purpose') == 'Project' ? 
                        $rfqUser->assy_code =               $request->input('e_itm_assy_code.'.$i) : "");
        
                        $rfqUser->item_code =               $request->input('e_itm_item_code.'.$i);
                        $rfqUser->uom_code =                $request->input('e_itm_uom_code.'.$i);
                        $rfqUser->required_qty =            $request->input('e_itm_quantity.'.$i);
                        $rfqUser->required_delivery_date =  $request->input('e_itm_delivery_date.'.$i);
                        $rfqUser->save();
                    }
                }

                if($rfqheader->save()){
                    return redirect()->route('rfq.index')->withSuccess('Request for Quotation Successfully Updated');
                }

            } else {
                return redirect()->route('rfq.index')->withErrors('Please fill up all the Request for Quotation Details!');
            }            
        
        }
    }

    public function destroy($id)
    {
        //
    }
}
