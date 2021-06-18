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
                ->with('sites', $sites)
                ->with('count', $rfqcount)
                ->with('currency', $currency)
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
    
    public function all_approval($id)
    {
        $idx = Crypt::decrypt($id);
        return response()->json([
            "data" => RFQHeader::where('current_approver','=',$idx)
            ->where('status','<>','Approved')
            ->where('status','<>','Rejected')
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
            return redirect()->route('issuance.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            // return $request->input('project_code');

            if($request->input('rfq_code') &&  $request->input('purpose') && $request->input('remarks'))
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

    public function destroy($id)
    {
        //
    }
}
