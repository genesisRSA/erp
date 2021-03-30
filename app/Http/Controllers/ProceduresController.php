<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Storage;
use App\Mail\SalesMailable;
use App\SitePermission;
use App\ApproverMatrix;
use App\Procedure;
use App\ProceduresRevision;
use App\Site;
use App\Employee;
use Validator;
use Response;
use Storage;
use Auth;

class ProceduresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                                    ->where('module','=','Procedures')
                                    ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));

        return view('res.procedure.index')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('permission',$permissionx);
    }

    public function all($id)
    {
 
        $idx = Crypt::decrypt($id);
 
        $data =  Procedure::where('created_by','=',$idx)
                                ->get();
                    
        return response()
        ->json([
            "data" => $data
        ]); 
    }

    public function all_revision($id)
    {
 
        $idx = Crypt::decrypt($id);
 
        $data =  ProceduresRevision::where('created_by','=',$idx)
                                ->get();
                    
        return response()
        ->json([
            "data" => $data
        ]); 
    }

    public function all_approval($id)
    {
        
        $idx = Crypt::decrypt($id);

        $data = Procedure::where('status','<>','x')
                            ->where('status','<>','Rejected')
                            ->where('status','<>','Voided')
                            ->where('current_approver','=',$idx)
                            ->get();

        return response()
        ->json([
            "data" => $data
        ]); 
    }

    public function getApprover($id)
    {   
        $idx = Crypt::decrypt($id);
        $data = ApproverMatrix::where('requestor','=',$idx)
                            ->where('module','=','Procedures')
                            ->first();
        return response()->json(['data' => $data]);
    }

    public function getApproverMatrix($id)
    {
        $data = Procedure::where('id','=',$id)->first();
        return response()->json(['data' => $data]);
    }

    public function create()
    {
        $employee = Employee::where('emp_no','=','0204-2021');
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
                                ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  "RSA-ITS-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Procedures')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));

        return view('res.procedure.new')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('permission',$permissionx)
                ->with('docNo', $docNo)
                ->with('lastDoc', $lastDocx);
    }

    public function store(Request $request)
    {
        $field = [
            // 'dpr_code' => 'required',
            // 'doctitle' => 'required',
            // 'docno' => 'required',
            // 'revno' => 'required',
            // 'desc' => 'required',
            // 'reas' => 'required',
            // 'file' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('procedure.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            $procedure = new Procedure();
            $procedure->dpr_code = $request->input('dpr_code','');
            $procedure->requested_date = $request->input('requested_date','');
            $procedure->document_title = $request->input('document_title','');
            $procedure->document_no = $request->input('document_no','');
            $procedure->revision_no = $request->input('revision_no','');
            $procedure->change_description = $request->input('change_description','');
            $procedure->change_reason = $request->input('change_reason','');
            $procedure->created_by = Auth::user()->emp_no;
            if($request->input('app_seq'))
            {
                $approvers = array();

                    for( $i = 0 ; $i < count($request->input('app_seq')) ; $i++ )
                    {
                        array_push($approvers, [
                                                'sequence' => $request->input('app_seq.'.$i),
                                                'approver_emp_no' => $request->input('app_id.'.$i),
                                                'approver_name' => $request->input('app_fname.'.$i),
                                                'next_status' => $request->input('app_nstatus.'.$i),
                                                'is_gate' => $request->input('app_gate.'.$i)
                                                ]);
                        if($request->input('app_seq.'.$i)==0) {
                            $procedure->current_sequence = $request->input('app_seq.'.$i);
                            $procedure->current_approver = $request->input('app_id.'.$i);
                            // $approverID = $request->input('app_id.'.$i);
                        }
                    }

                    $approvers = json_encode($approvers);            
                    $procedure->matrix = $approvers;
            }

            $procedure->reviewed_by = $request->input('','');
            $procedure->approved_by = $request->input('','');
            $procedure->status = 'For Review';

            if($request->hasFile('file'))
            {
                //$filename = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->store('documents');
                // $path = str_replace('public', '/storage', $path);
                $url = env('APP_URL') . Storage::url($path);
            } 
            // return $url;
            $procedure->file_name = $path;

            if($procedure->save()){
                return redirect()->route('procedure.index')->withSuccess('Procedure Successfully Added');
            }
        }
    }

    public function revision(Request $request)
    {
        $field = [
            // 'dpr_code' => 'required',
            // 'doctitle' => 'required',
            // 'docno' => 'required',
            // 'revno' => 'required',
            // 'desc' => 'required',
            // 'reas' => 'required',
            // 'file' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('procedure.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            // return  $request->input('change_description_h');
            $procedure_h = new ProceduresRevision();
            $procedure_h->dpr_code =            $request->input('dpr_code_h');
            $procedure_h->requested_date =      $request->input('requested_date_h');
            $procedure_h->document_title =      $request->input('document_title');
            $procedure_h->document_no =         $request->input('document_no_h');
            $procedure_h->revision_no =         $request->input('revision_no_h');
            $procedure_h->change_description =  $request->input('change_description_h');
            $procedure_h->change_reason =       $request->input('change_reason_h');
            $procedure_h->created_by =          Auth::user()->emp_no;
            $procedure_h->reviewed_by =         $request->input('reviewed_by');
            $procedure_h->approved_by =         $request->input('approved_by');
            $procedure_h->status =              $request->input('status_h');
            $procedure_h->file_name =           $request->input('file_h');
            $procedure_h->save();

            $procedure = new ProceduresRevision();
            $procedure->dpr_code =              $request->input('dpr_code','');
            $procedure->requested_date =        $request->input('requested_date','');
            $procedure->document_title =        $request->input('document_title','');
            $procedure->document_no =           $request->input('document_no','');
            $procedure->revision_no =           $request->input('revision_no','');
            $procedure->change_description =    $request->input('change_description','');
            $procedure->change_reason =         $request->input('change_reason','');
            $procedure->created_by =            Auth::user()->emp_no;
            $procedure->reviewed_by =           $request->input('','');
            $procedure->approved_by =           $request->input('','');
            $procedure->status =                'For Review';

            if($request->hasFile('file'))
            {
                $path = $request->file('file')->store('documents');
            } 

            $procedure->file_name = $path;

            if($procedure->save()){
                return redirect()->route('procedure.index')->withSuccess('Procedure Revision Successfully Added');
            }
        }
    }

    public function show($id)
    {
        //
    }
    
    public function view($id)
    {    
        $procedures = Procedure::find($id);
        return view('res.procedure.view')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('idx', $procedures->id);
    }

    public function view_revision($id)
    {    
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
                            ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  "RSA-ITS-".$lastDocx;

        $procedures = ProceduresRevision::find($id);
        return view('res.procedure.view')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('docNo',$docNo)
                ->with('idx', $procedures->id);
    }

    public function getPostDocument(Request $request)
    {
        $document = Procedure::findOrFail($request->input('id'));

        $filename = str_replace("documents/", "", $document->file_name);
        $filePath = $document->file_name;

        if( ! Storage::exists($filePath) ) {
        abort(404);
        }

        $pdfContent = Storage::get($filePath);

        return Response::make($pdfContent, 200, [
        'Content-Type'        =>  'application/pdf',
        'Content-Disposition' => 'inline; filename="'.$filename.''
        ]);
    }

    public function getDocument($id)
    {
        $document = Procedure::findOrFail($id);
        $filename = str_replace("documents/", "", $document->file_name);
        $filePath = $document->file_name;

        if( ! Storage::exists($filePath) ) {
        abort(404);
        }

        $pdfContent = Storage::get($filePath);

        return Response::make($pdfContent, 200, [
            'Content-Type'        =>  'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.''
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function revise($id)
    {
        
        $employee = Employee::where('emp_no','=','0204-2021');
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
                                ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  "RSA-ITS-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Procedures')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));
        $procedure = Procedure::find($id);
        $procedures = Procedure::where('document_no','=',$procedure->document_no)->first();
 

        return view('res.procedure.revise')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('docNo',$docNo)
                ->with('permission',$permissionx)
                ->with('lastDoc', $lastDocx)
                ->with('procedures', $procedures);
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

            $procedure_app = Procedure::find($request->input('id', ''));
            $curr_status = $procedure_app->status;
            $curr_seq_db = $procedure_app->current_sequence;
    
            $curr_id = $request->input('id','');
            $curr_seq = $request->input('seq','');
            $curr_app = $request->input('appid','');
            $status = $request->input('status','');
            $remarks = $request->input('remarks','');
 
            $date = date('Y-m-d H:i:s');

            $matrix = json_decode($procedure_app->matrix, true);
            $matrixh = json_decode($procedure_app->matrix_h) ? json_decode($procedure_app->matrix_h) : array();

            $gate = $matrix[0]['is_gate'];
            $next_status = $matrix[0]['next_status'];

            $lastid = DB::table('procedures')->latest('id')->first();
            if($lastid){
                $lastid = $lastid->id + 1;
            }else{
                $lastid = 0;
            }
           
            $next_seq = $curr_seq + 1;
            $matlen = count($matrix);
            $lastApproval = false;

            $empID = "";

            if($matlen!=1)
            {
                foreach ($matrix as $matrx) {
                    if($matrx['sequence']==$next_seq)
                    {
                        $empID = $matrx['approver_emp_no'];
                        $lastApproval = false;
                    }
                }
            }
            else 
            {
              $empID = $matrix[0]['approver_emp_no'];
              $lastApproval = true;
            }

            if($status=='Approved')
            {
                if($gate=='true')
                { 
                    for($i=0; $i < count($matrix); $i++)
                    {
                        if($curr_seq==$curr_seq_db)
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => $status,
                                'remarks' => $remarks,
                                'action_date' => $date,
                            ]);
                            $curr_seq += 1;
                        }
                        else
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => 'Bypassed',
                                'remarks' => 'Bypassed',
                                'action_date' => $date,
                            ]);
                        }
                    }
                    $procedure_app->status = 'Approved';
                    $procedure_app->approved_by = $curr_app;
                    // $procedure_app->updated_by = $curr_app;
                    $matrix = [];
                    // $approver = Employee::where('emp_no','=',$empID)->first();
                    // $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                    //                                 'forecast', // location
                    //                                 'Approved', // next status val
                    //                                 'filer', // who to receive
                    //                                 $approver->emp_fname, // approver name
                    //                                 $procedure_app->forecast_code, // forecast code
                    //                                 Auth::user()->employee->full_name, // full_name
                    //                                 $remarks, // remarks
                    //                                 $lastid); // last id + 1
                }
                else 
                {
                    if($lastApproval==true)
                    {
                        array_push($matrixh,[
                            'sequence' => $curr_seq,
                            'approver_emp_no' => $curr_app,
                            'approver_name' => $matrix[0]['approver_name'],
                            'status' => $curr_status,
                            'remarks' => $remarks,
                            'action_date' => $date,
                        ]);
                        $curr_seq += 1;
                        array_splice($matrix,0,1);
                        $procedure_app->status = $next_status;
                        $procedure_app->approved_by = $curr_app;
                        // $procedure_app->updated_by = $curr_app;
                        
                        // $approver = Employee::where('emp_no','=',$empID)->first();
                        // $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                        //                                 'forecast', // location
                        //                                 'Approved', // next status val
                        //                                 'filer', // who to receive
                        //                                 $approver->emp_fname, // approver name
                        //                                 $procedure_app->forecast_code, // forecast code
                        //                                 Auth::user()->employee->full_name, // full_name
                        //                                 $remarks, // remarks
                        //                                 $lastid); // last id + 1
                    }
                    else
                    {
                        array_push($matrixh,[
                            'sequence' => $curr_seq,
                            'approver_emp_no' => $curr_app,
                            'approver_name' => $matrix[0]['approver_name'],
                            'status' => $curr_status,
                            'remarks' => $remarks,
                            'action_date' => $date,
                        ]);
                        $curr_seq += 1;
                        array_splice($matrix,0,1);
                        $procedure_app->status = $next_status;
                        $procedure_app->approved_by = $curr_app;
                        // $procedure_app->updated_by = $curr_app;
                        
                        // $approver = Employee::where('emp_no','=',$empID)->first();
                        // $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                        //                                 'forecast', // location
                        //                                 $next_status, // next status val
                        //                                 'approver', // who to receive
                        //                                 $approver->emp_fname, // approver name
                        //                                 $procedure_app->forecast_code, // forecast code
                        //                                 Auth::user()->employee->full_name, // full_name
                        //                                 $remarks, // remarks
                        //                                 $lastid); // last id + 1
                    }
                }
            }
            else
            {
                 for($i=0; $i < count($matrix); $i++)
                    {
                        if($curr_seq==$curr_seq_db)
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => $curr_status,
                                'remarks' => $remarks,
                                'action_date' => $date,
                            ]);
                            $curr_seq += 1;
                        }
                        else
                        {
                            array_push($matrixh, [
                                'sequence' => $matrix[$i]['sequence'],
                                'approver_emp_no' => $matrix[$i]['approver_emp_no'],
                                'approver_name' => $matrix[$i]['approver_name'],
                                'status' => 'Bypassed',
                                'remarks' => 'Bypassed',
                                'action_date' => $date,
                            ]);
                        }
                    }
                $procedure_app->status = 'Rejected';
                $procedure_app->approved_by = 'N/A';
                // $procedure_app->updated_by = $curr_app;
                $matrix = [];
                
                // $approver = Employee::where('emp_no','=',$empID)->first();
                // $maildetails = new SalesMailable('REISS - Sales Forecast Approval', // subject
                //                                 'forecast', // location
                //                                 'Rejected', // next status val
                //                                 'filer', // who to receive
                //                                 $approver->emp_fname, // approver name
                //                                 $procedure_app->forecast_code, // forecast code
                //                                 Auth::user()->employee->full_name, // full_name
                //                                 $remarks, // remarks
                //                                 $lastid); // last id + 1
            }
            
            $procedure_app->current_sequence = $curr_seq;
            $procedure_app->matrix = json_encode($matrix);
            $procedure_app->matrix_h = json_encode($matrixh);

            if($procedure_app->save()){
                if($status=='Approved'){
                    // Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('procedure.index')->withSuccess('Procedure Successfully Approved');
                } else {
                    // Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('procedure.index')->withSuccess('Procedure Successfully Rejected');
                }
            }
        }
    }

    public function approval_view($id)
    {    
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
        ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  "RSA-ITS-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Procedures')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));
        $procedure = Procedure::find($id);
        $procedures = Procedure::where('document_no','=',$procedure->document_no)->first();
 
        return view('res.procedure.approval')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('idx', $procedures->id) 
                ->with('docNo',$docNo)
                ->with('permission',$permissionx)
                ->with('lastDoc', $lastDocx)
                ->with('procedures', $procedures);
    }

    public function destroy($id)
    {
        //
    }
}
