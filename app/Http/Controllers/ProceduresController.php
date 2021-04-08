<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\SalesMailable;
use App\SitePermission;
use App\ApproverMatrix;
use App\Procedure;
use App\ProceduresRevision;
use App\ProceduresMasterCopy;
use App\ProceduresControlledCopy;
use App\Site;
use App\Employee;
use App\Department;
use Validator;
use Response;
use Auth;
use PDF;
// use Elibyy\TCPDF\Facades\TCPDF;

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

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true,"masterlist":true}]', true));

        return view('res.procedure.index')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('permission',$permissionx);
    }
 
    public function pdf($id)
    {
        $procedure = Procedure::find($id);
        $pdf = 'file://'.realpath('../storage/app/'.$procedure->file_name);
        $signature = realpath('../storage/app/assets/copy.png');
        $pageCount = PDF::setSourceFile($pdf);
        for($i=1; $i <= $pageCount; $i++){
            PDF::AddPage();
            $page = PDF::importPage($i);
            PDF::useTemplate($page, 0, 0);
            PDF::setPrintHeader(false);
            PDF::setPrintFooter(true);
            PDF::setFooterCallback(function($pdf) {
                $signature = realpath('../storage/app/assets/copy_m_nv.png');
                $pdf->SetY(-15);
                $pdf->Cell(0, 40, $pdf->Image($signature, 10, 315 - 50, 90, 30, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');

            });
            PDF::SetMargins(false, false);
        }
        PDF::Output('hello_world.pdf', 'I');
    }

    public function pdfx($id,$loc)
    {
        $procedure = Procedure::find($id);
        $newFile = ($loc == "master" ? 'documents/master/master_'.str_replace("documents/draft/","",$procedure->file_name) : 'documents/controlled/cc_'.str_replace("documents/draft/","",$procedure->file_name));
        Storage::copy($procedure->file_name,$newFile);
        $pdf = 'file://'.realpath('../storage/app/'.$newFile);
        $signature = realpath('../storage/app/assets/copy.png');
        $pageCount = PDF::setSourceFile($pdf);
        for($i=1; $i <= $pageCount; $i++){
            PDF::AddPage();
            $page = PDF::importPage($i);
            PDF::useTemplate($page, 0, 0);
            PDF::setPrintHeader(false);
            PDF::setPrintFooter(true);
            PDF::setFooterCallback(function($pdf) {
                $signature = realpath('../storage/app/assets/copy_m_nv.png');
                $pdf->SetY(-15);
                $pdf->Cell(0, 40, $pdf->Image($signature, 10, 315 - 50, 90, 30, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
            });
            PDF::SetMargins(false, false);
        }
        PDF::Output(realpath('../storage/app/'.$newFile), 'F');
        return realpath('../storage/app/'.$newFile);
    }

    public function all($id, $loc)
    {
        $idx = Crypt::decrypt($id);
        $locx = $loc;
        switch($locx){
            case "procedures":
                $data =  Procedure::where('created_by','=',$idx)
                ->get();
            break;
            case "approval":
                $data = Procedure::where('status','<>','Approved')
                        ->where('status','<>','Rejected')
                        ->where('status','<>','Created')
                        ->where('status','<>','Voided')
                        ->where('current_approver','=',$idx)
                        ->get();
            break;
            case "master":
                $data = Procedure::where('status','<>','Pending')
                        ->where('status','<>','For Review')
                        ->where('status','<>','Approval')
                        ->get();
            break;
            case "controlled":
                $data = ProceduresMasterCopy::with('procedures:document_no,dpr_code,id')
                        ->get();
            break;
        }
            
        return response()
        ->json([
            "data" => $data
        ]); 
    }

    public function all_revision($id)
    {
        $data =  ProceduresRevision::where('document_no','=',$id)
                                ->with('procedures:document_no,id')
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
        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
                                ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  $employee->sect_code."-".$lastDocx;
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
            'app_seq' => 'required',
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
            $procedure->status = 'Pending';

            if($request->hasFile('file'))
            {
                //$filename = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->store('documents/draft');
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

    public function makeMaster(Request $request)
    {
        $field = [
            'id' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('procedure.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
            $department = $employee->dept_code;

            $fileName = self::pdfx($request->input('id'),"master");
            $filePath = str_replace('\\','/', $fileName);
            $newFileName = substr($filePath, -51, 51);

            $master = new ProceduresMasterCopy();
            $master->document_title = $request->input('document_title','');
            $master->file_name = $newFileName;
            $master->revision_no = $request->input('revision_no','');
            $master->document_no = $request->input('document_no','');
            $master->department = $department;
            $master->process_owner = $request->input('process_owner','');
            $master->released_by = Auth::user()->emp_no;
            $master->status = 'For CC';

            $procedure = Procedure::find($request->input('id'));
            $procedure->status = 'Created';
            
            // $filename =  str_replace("documents/draft/", "", $procedure->file_name);
            // return $filename;
            // Storage::disk('master')->put($filename,file_get_contents(self::pdfx($request->input('id'))));

            if($master->save()){
                $procedure->save();
                return redirect()->route('procedure.index')->withSuccess('Master Copy Successfully Created');
            }
        }
    }

    public function makeCopy(Request $request)
    {
        $field = [
            'id' => 'required',
            'dept' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('procedure.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
            $department = $employee->dept_code;

            $fileName = self::pdfx($request->input('id'),"controlled");
            $filePath = str_replace('\\','/', $fileName);
            $newFileName = substr($filePath, -51, 51);

            $cc = new ProceduresControlledCopy();
            $cc->document_title = $request->input('document_title','');
            $cc->file_name = $newFileName;
            $cc->revision_no = $request->input('revision_no','');
            $cc->document_no = $request->input('document_no','');
            $cc->department = $request->input('department','');
            $cc->process_owner = $request->input('process_owner','');
            $cc->released_by = Auth::user()->emp_no;
            $cc->status = 'Created';

            $procedure = ProceduresMasterCopy::where('document_no','=',$request->input('document_no'))
                                            ->where('revision_no','=',$request->input('revision_no'))
                                            ->first();
            $procedure->status = 'Created';

            if($cc->save()){
                $procedure->save();
                return redirect()->route('procedure.index')->withSuccess('Controlled Copy Successfully Created');
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
            
            // $procedure_h = new ProceduresRevision();
            // $procedure_h->dpr_code =            $request->input('dpr_code_h');
            // $procedure_h->requested_date =      $request->input('requested_date_h');
            // $procedure_h->document_title =      $request->input('document_title');
            // $procedure_h->document_no =         $request->input('document_no_h');
            // $procedure_h->revision_no =         $request->input('revision_no_h');
            // $procedure_h->change_description =  $request->input('change_description_h');
            // $procedure_h->change_reason =       $request->input('change_reason_h');
            // $procedure_h->created_by =          Auth::user()->emp_no;
            // $procedure_h->reviewed_by =         $request->input('reviewed_by');
            // $procedure_h->approved_by =         $request->input('approved_by');
            // $procedure_h->status =              $request->input('status_h');
            // $procedure_h->file_name =           $request->input('file_h');
            // $procedure_h->save();

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
                        }
                    }

                    $approvers = json_encode($approvers);            
                    $procedure->matrix = $approvers;
            }

            $procedure->reviewed_by = '';
            $procedure->approved_by = '';
            $procedure->status = 'Pending';

            if($request->hasFile('file'))
            {
                $path = $request->file('file')->store('documents/draft');
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
                ->with('procedures', $procedures);
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

    public function getDocument($id, $loc)
    {
  
        $document = Procedure::findOrFail($id);
        
        $filename = str_replace("documents/", "", $document->file_name);
        
        $filePath = ($loc == 'Created' ?  str_replace("draft/","master/master_", $document->file_name) : $document->file_name );
 
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
        
        $employeeSec = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
                                ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  $employeeSec->sect_code."-".$lastDocx;
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

                    $revNo = $request->input('revision_no') ? $request->input('revision_no') : 0;
                    $revNoH = $request->input('revision_no_h') ? $request->input('revision_no_h') : 0;

                        if($revNo>=1)
                            {
                                if($revNoH==0)
                                {
                                    $procedure_h = new ProceduresRevision();
                                    $procedure_h->dpr_code =            $request->input('dpr_code_h');
                                    $procedure_h->requested_date =      $request->input('requested_date_h');
                                    $procedure_h->document_title =      $request->input('document_title');
                                    $procedure_h->document_no =         $request->input('document_no_h');
                                    $procedure_h->revision_no =         $request->input('revision_no_h');
                                    $procedure_h->change_description =  $request->input('change_description_h');
                                    $procedure_h->change_reason =       $request->input('change_reason_h');
                                    $procedure_h->created_by =          $request->input('created_by','');
                                    $procedure_h->reviewed_by =         $request->input('reviewed_by_h');
                                    $procedure_h->approved_by =         $request->input('approved_by_h');
                                    $procedure_h->status =              $request->input('status_h');
                                    $procedure_h->file_name =           $request->input('file_name_h');
                                    $procedure_h->save();
                                }
                                    $procedure = new ProceduresRevision();
                                    $procedure->dpr_code =              $request->input('dpr_code','');
                                    $procedure->requested_date =        $request->input('requested_date','');
                                    $procedure->document_title =        $request->input('document_title','');
                                    $procedure->document_no =           $request->input('document_no','');
                                    $procedure->revision_no =           $request->input('revision_no','');
                                    $procedure->change_description =    $request->input('change_description','');
                                    $procedure->change_reason =         $request->input('change_reason','');
                                    $procedure->created_by =            $request->input('created_by','');
                                    $procedure->reviewed_by =           $request->input('','');
                                    $procedure->approved_by =           $curr_app;
                                    $procedure->status =                $status;
                                    $procedure_h->file_name =           $request->input('file_name');
                                    $procedure_h->save();
                            }

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
                        $revNo = $request->input('revision_no') ? $request->input('revision_no') : 0;
                        $revNoH = $request->input('revision_no_h') ? $request->input('revision_no_h') : 0;
                        // return $revNoH;
                        if($revNo>=1)
                            {
                                if($revNoH==0)
                                {
                                    $procedure_h = new ProceduresRevision();
                                    $procedure_h->dpr_code =            $request->input('dpr_code_h');
                                    $procedure_h->requested_date =      $request->input('requested_date_h');
                                    $procedure_h->document_title =      $request->input('document_title');
                                    $procedure_h->document_no =         $request->input('document_no_h');
                                    $procedure_h->revision_no =         $request->input('revision_no_h');
                                    $procedure_h->change_description =  $request->input('change_description_h');
                                    $procedure_h->change_reason =       $request->input('change_reason_h');
                                    $procedure_h->created_by =          $request->input('created_by','');
                                    $procedure_h->reviewed_by =         $request->input('reviewed_by_h');
                                    $procedure_h->approved_by =         $request->input('approved_by_h');
                                    $procedure_h->status =              $request->input('status_h');
                                    $procedure_h->file_name =           $request->input('file_name_h');
                                    $procedure_h->save();
                                }
                                    $procedure = new ProceduresRevision();
                                    $procedure->dpr_code =              $request->input('dpr_code','');
                                    $procedure->requested_date =        $request->input('requested_date','');
                                    $procedure->document_title =        $request->input('document_title','');
                                    $procedure->document_no =           $request->input('document_no','');
                                    $procedure->revision_no =           $request->input('revision_no','');
                                    $procedure->change_description =    $request->input('change_description','');
                                    $procedure->change_reason =         $request->input('change_reason','');
                                    $procedure->created_by =            $request->input('created_by','');
                                    $procedure->reviewed_by =           $request->input('reviewed_by','');
                                    $procedure->approved_by =           $curr_app;
                                    $procedure->status =                $status;
                                    $procedure->file_name =           $request->input('file_name');
                                    $procedure->save();
                            }
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
        // sect_code will be used for document no ex. RSA-ITS-001
        $employeeSec = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
 
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
        ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  $employeeSec->sect_code."-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Procedures')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));
        $procedure = Procedure::find($id);
        $procedures = Procedure::where('dpr_code','=',$procedure->dpr_code)->first();
        $procedures_h = Procedure::where('revision_no','=',$procedure->revision_no-1)->first();
 
        return view('res.procedure.approval')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('idx', $id) 
                ->with('docNo',$docNo)
                ->with('permission',$permissionx)
                ->with('lastDoc', $lastDocx)
                ->with('procedures', $procedures)
                ->with('procedures_h', $procedures_h);
    }

    public function master_view($id)
    {    
        // sect_code will be used for document no ex. RSA-ITS-001
        $employeeSec = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
 
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
        ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  $employeeSec->sect_code."-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Procedures')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));
        $procedure = Procedure::find($id);
        $procedures = Procedure::where('document_no','=',$procedure->document_no)->first();
        $procedures_h = Procedure::where('revision_no','=',$procedure->revision_no-1)->first();
 
        return view('res.procedure.master')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('idx', $id) 
                ->with('docNo',$docNo)
                ->with('permission',$permissionx)
                ->with('lastDoc', $lastDocx)
                ->with('procedures', $procedures)
                ->with('procedures_h', $procedures_h);
    }

    public function copy_view($id)
    {    
        // sect_code will be used for document no ex. RSA-ITS-001
        $employeeSec = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $department = Department::get();
 
        $docxCount = Procedure::where('created_by','=',Auth::user()->emp_no)
        ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  $employeeSec->sect_code."-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Procedures')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":true,"edit":true,"view":true,"delete":true,"void":true,"approval":true}]', true));
        $procedure = Procedure::find($id);
        $procedures = Procedure::where('document_no','=',$procedure->document_no)->first();
        $procedures_h = Procedure::where('revision_no','=',$procedure->revision_no-1)->first();
 
        return view('res.procedure.copy')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','procedures')
                ->with('idx', $id) 
                ->with('docNo',$docNo)
                ->with('permission',$permissionx)
                ->with('lastDoc', $lastDocx)
                ->with('procedures', $procedures)
                ->with('procedures_h', $procedures_h)
                ->with('department', $department);
    }

    public function destroy($id)
    {
        //
    }
}
