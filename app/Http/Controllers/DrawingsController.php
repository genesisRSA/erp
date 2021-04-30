<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\DrawingMailable;
use App\SitePermission;
use App\ApproverMatrix;
use App\Drawing;
use App\DrawingsRevision;
use App\DrawingsControlledCopy;
use App\DrawingsMasterCopy;
use App\Site;
use App\Employee;
use App\Department;
use App\Customer;
use App\Assembly;
use App\Fabrication;
use Validator;
use Response;
use Auth;
use PDF;
use Image;

class DrawingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                                    ->where('module','=','Drawings')
                                    ->first();

        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"masterlist":false,"approval":false}]', true));

        return view('res.drawing.index')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('permission',$permissionx)
                ->with('employee',$employee);
    }

    public function pdf($id,$loc)
    {
        $locx = $loc;
        $drawing = Drawing::find($id);
        $preference = array('FitWindow' => true,'CenterWindow' => true,);
    
        $pdf = 'file://'.realpath('../storage/app/'.$drawing->file_name);
        PDF::Reset();
        PDF::SetAutoPageBreak(true, 20);
        PDF::setViewerPreferences($preference);
        $pageCount = PDF::setSourceFile($pdf);
        for($i=1; $i <= $pageCount; $i++){
           
            PDF::AddPage('L', 'A4');
            $page = PDF::importPage($i);
            PDF::useTemplate($page, 0, 0);
            PDF::setPrintHeader(false);
            PDF::setPrintFooter(true);
            if($locx=='master')
            {
                PDF::setFooterCallback(function($pdf) {
                        $master_v = realpath('../storage/app/assets/copy_m_v.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_v, 235, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }
            elseif($locx=='copy')
            {
                $cc = DrawingsControlledCopy::where('drawing_no','=',$drawing->drawing_no)
                                                ->where('ecn_code','=',$drawing->ecn_code)
                                                ->count();
                                                 
                self::makeStamp($cc);
                PDF::setFooterCallback(
                    function($pdf) {
                        $master_nv = realpath('../storage/app/assets/copy_m_nv.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_nv, 183, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');

                        $copy_cc = realpath('../storage/app/assets/stamps/copy_cc.png');
                        $pdf->SetY(-15);      
                        $pdf->Cell(0, 40, $pdf->Image($copy_cc, 238, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');                        
                                        
                });
              
               
            }
            else
            {
                PDF::setFooterCallback(function($pdf) {
                        $master_nv = realpath('../storage/app/assets/copy_m_nv.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_nv, 10, 315 - 50, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');

                        $copy_cc = realpath('../storage/app/assets/copy_cc.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($copy_cc, 65, 315 - 50, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');

                        $obs = realpath('../storage/app/assets/copy_ob.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($obs, 145, 315 - 50, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }
            PDF::SetMargins(false, false);
        }
        PDF::Output('hello_world.pdf', 'I');
    }

    public function pdfx($id,$loc)
    {
        $locx = $loc;
        $drawings = Drawing::find($id);
        $copyCount = DrawingsControlledCopy::where('drawing_no','=',$drawings->drawing_no)->count();
       
        if($locx=='master')
        {
            $newFile = 'drawings/master/master_'.str_replace("drawings/draft/","",$drawings->file_name);
        }
        elseif ($locx=='controlled')
        {
            $newFile = 'drawings/controlled/cc_'.$copyCount.'_'.str_replace("drawings/draft/","",$drawings->file_name);
        }
        elseif ($locx=='obsm')
        {
            $newFile = 'drawings/obsolete/obsm_'.str_replace("drawings/draft/","",$drawings->file_name);
        }
        else
        {
            $newFile = 'drawings/obsolete/obsc_'.str_replace("drawings/draft/","",$drawings->file_name);
        }

        Storage::copy($drawings->file_name,$newFile);
        $pdf = 'file://'.realpath('../storage/app/'.$newFile);
        PDF::Reset();
        $pageCount = PDF::setSourceFile($pdf);
        for($i=1; $i <= $pageCount; $i++){
            PDF::AddPage('L', 'A4');
            $page = PDF::importPage($i);
            PDF::useTemplate($page, 0, 0);
            PDF::setPrintHeader(false);
            PDF::setPrintFooter(true);
            if($locx=='master')
            {
                PDF::setFooterCallback(function($pdf) {
                        $master_v = realpath('../storage/app/assets/copy_m_v.png');
                        $pdf->SetY(0);
                        $pdf->Cell(0, 40, $pdf->Image($master_v, 235, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }elseif($locx=='controlled'){
                PDF::setFooterCallback(function($pdf) {
                        $master_nv = realpath('../storage/app/assets/copy_m_nv.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_nv, 183, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');

                        $copy_cc = realpath('../storage/app/assets/stamps/copy_cc.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($copy_cc, 238, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }elseif($locx=='obsm'){
                PDF::setFooterCallback(function($pdf) {
                        $master_nv = realpath('../storage/app/assets/copy_m_nv.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_nv, 183, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                  
                        $obs = realpath('../storage/app/assets/copy_ob.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($obs, 238, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }elseif($locx=='obswoc'){
                PDF::setFooterCallback(function($pdf) {
                        $master_nv = realpath('../storage/app/assets/copy_m_nv.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_nv, 183, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                  
                        $obs = realpath('../storage/app/assets/copy_ob.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($obs, 238, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }elseif($locx=='obswc'){
                PDF::setFooterCallback(function($pdf) {
                        $master_nv = realpath('../storage/app/assets/copy_m_nv.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($master_nv, 183, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                        
                        $copy_cc = realpath('../storage/app/assets/stamps/copy_cc.png');
                        $pdf->SetY(-15);
                        // $pdf->Cell(0, 40, $pdf->Image($copy_cc, 5, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                        $pdf->Cell(0, 40, $pdf->Image($copy_cc, 238, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');

                        $obs = realpath('../storage/app/assets/copy_ob.png');
                        $pdf->SetY(-15);
                        $pdf->Cell(0, 40, $pdf->Image($obs, 5, 315 - 310, 55, 25, 'PNG') , 0, 0, '', 0, '', 0, false, '', '');
                });
            }
            PDF::SetMargins(false, false);
        }
        PDF::Output(realpath('../storage/app/'.$newFile), 'F');
        return realpath('../storage/app/'.$newFile);
    }

    public function all($id, $loc)
    {
        $idx = Crypt::decrypt($id);
        $locx = $loc;

        $userDept = Employee::select('dept_code')->where('emp_no','=',$idx)->first();

        $permission = SitePermission::where('requestor','=',$idx)
                                    ->where('module','=','drawings')
                                    ->first();

        $permissionx =  ($permission ? json_decode($permission->permission) : 
                                    json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"masterlist":false,"approval":false}]'));
        
        switch($locx){
            case "drawing":
                $data = Drawing::where('created_by','=',$idx)
                        ->get();
                        
            break;
            case "approval":
                $data = Drawing::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                        ->where('status','<>','Approved')
                        ->where('status','<>','Rejected')
                        ->where('status','<>','Created')
                        ->where('status','<>','Obsolete')
                        ->where('status','<>','Received')
                        ->where('status','<>','Oriented')
                        ->where('current_approver','=',$idx)
                        ->get();
            break;
            case "master":
                $data = Drawing::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                        ->where('status','<>','Pending')
                        ->where('status','<>','For Review')
                        ->where('status','<>','Approval')
                        ->where('status','<>','Rejected')
                        ->get();
            break;
            case "forCC":
                $data = DrawingsMasterCopy::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                        ->where('status','<>','Obsolete')
                        ->get();
            break;
            case "cc":
                if($permissionx[0]->masterlist==true){
                    $data = DrawingsControlledCopy::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                    ->with('dept_details:dept_code,dept_desc')
                    ->get();
                } else {
                    $data = DrawingsControlledCopy::with('employee_details:emp_no,emp_fname,emp_mname,emp_lname')
                    ->with('dept_details:dept_code,dept_desc')
                    ->where('department','=',$userDept->dept_code)
                    ->where('status','<>','Obsolete')
                    ->get();
                }
            break;
        }
            
        return response()
        ->json([
            "data" => $data
        ]); 
    }

    public function all_revision($id)
    {
        $drawing_no = Crypt::decrypt($id);

        $data =  DrawingsRevision::where('drawing_no','=',$drawing_no)
                                ->with('drawings:ecn_code,id')
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
                            ->where('module','=','Drawings')
                            ->first();
        return response()->json(['data' => $data]);
    }

    public function getApproverMatrix($id)
    {
        $data = Drawing::where('id','=',$id)->first();
        return response()->json(['data' => $data]);
    }

    public function create()
    {
        $customer = Customer::get();
        $assembly = Assembly::get();
        $fabrication = Fabrication::get();
        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $docxCount = Drawing::where('drawing_no','like', $employee->site_code.'%')->count();
        $docx = Drawing::distinct('part_name')->where('drawing_no','like', $employee->site_code.'%')->count('part_name');

        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $LDocx = str_pad($docx+1,2,"0",STR_PAD_LEFT);
        $docNo = "RSA-001-A0001-1-F".$LDocx;
       
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Drawings')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"masterlist":false,"approval":false}]', true));

        return view('res.drawing.new')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('permission',$permissionx)
                ->with('docNo', $docNo)
                ->with('lastDoc', $lastDocx)
                ->with('customer', $customer)
                ->with('employee', $employee)
                ->with('assembly', $assembly)
                ->with('fabrication', $fabrication);
    }

    public function store(Request $request)
    {
        $field = [
            // 'ecn_code' => 'required',
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
            return redirect()->route('drawing.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            $drawing = new Drawing();
            $drawing->ecn_code = $request->input('ecn_code','');
            $drawing->cust_code = $request->input('cust_code','');
            $drawing->project_code = $request->input('project_code','');
            $drawing->part_name = $request->input('part_name','');
            $drawing->drawing_no = $request->input('drawing_no','');
            $drawing->revision_no = $request->input('revision_no','');
            $drawing->revision_date = $request->input('revision_date','');
            $drawing->process_specs = $request->input('process_specs','');
            $drawing->change_description = $request->input('change_description','');
            $drawing->change_reason = $request->input('change_reason','');
            $drawing->assy_code = $request->input('assy_code','');
            $drawing->fab_code = $request->input('fab_code','');

            $drawing->created_by = Auth::user()->emp_no;
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
                            $drawing->current_sequence = $request->input('app_seq.'.$i);
                            $drawing->current_approver = $request->input('app_id.'.$i);
                        }
                    }

                    $approvers = json_encode($approvers);            
                    $drawing->matrix = $approvers;
            }

            $drawing->reviewed_by = $request->input('','');
            $drawing->approved_by = $request->input('','');
            $drawing->status = 'Pending';

            if($request->hasFile('file'))
            { 
                $path = $request->file('file')->store('drawings/draft'); 
                $url = env('APP_URL') . Storage::url($path);
            }  

            $drawing->file_name = $path;

            if($drawing->save()){
                return redirect()->route('drawing.index')->withSuccess('Drawing Successfully Added');
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
            return redirect()->route('drawing.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $revCount = $request->input('revision_no');
            $fileName = self::pdfx($request->input('id'),"master");
            $filePath = str_replace('\\','/', $fileName);
            $newFileName = substr($filePath, -51, 51);

            // return $newFileName;

            $master = new DrawingsMasterCopy();
            $master->ecn_code = $request->input('ecn_code');
            $master->part_name = $request->input('part_name');
            $master->cust_code = $request->input('cust_code');
            $master->project_code = $request->input('project_code');
            $master->file_name = $newFileName;
            $master->revision_no = $revCount;
            $master->drawing_no = $request->input('drawing_no');
            $master->department = $request->input('dept');
            $master->designer = $request->input('designer');
            $master->released_by = Auth::user()->emp_no;
            $master->status = 'For CC';
            
            $drawing = Drawing::find($request->input('id'));
            $drawing->status = 'Created';           
            

            if($revCount>=1)
            {
                $drawing_obs = Drawing::where('drawing_no','=',$request->input('drawing_no'))
                                        ->where('revision_no','=',$revCount-1)
                                        ->first();
                
                $master_obs = DrawingsMasterCopy::where('drawing_no','=',$drawing_obs->drawing_no)
                                        ->where('revision_no','=',$drawing_obs->revision_no)
                                        ->first();
               
                $copy_obs = DrawingsControlledCopy::where('drawing_no','=',$drawing_obs->drawing_no)
                                        ->where('revision_no','=',$drawing_obs->revision_no)
                                        ->first();
                
                $rev_obs = DrawingsRevision::where('drawing_no','=',$drawing_obs->drawing_no)
                                        ->where('revision_no','=',$drawing_obs->revision_no)
                                        ->first();
                
                $idx = $drawing_obs->id;
                if($drawing_obs)
                    {$drawing_obs->status = 'Obsolete'; 
                        $drawing_obs->save();}
                if($master_obs)
                    {self::pdfx($idx,'obsm');
                        $master_obs->status = 'Obsolete'; 
                            Storage::delete('drawings/master/'.$master_obs->file_name); 
                                $master_obs->save();}
                if($copy_obs)
                    {$copy_obs->status = 'Obsolete';
                        Storage::delete('drawings/controlled/'.$copy_obs->file_name); 
                            $copy_obs->save();
                                $obs = 'obswc';} else 
                                    { $obs = 'obswoc'; }
                if($rev_obs)
                    {$rev_obs->status = 'Obsolete'; 
                        $rev_obs->save();}

                self::pdfx($idx,$obs);
            }

            if($master->save()){
                $drawing->save();
                return redirect()->route('drawing.index', ['#master'])->withSuccess('Master Copy Successfully Created');
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
            return redirect()->route('drawing.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
            $department = $employee->dept_code;

            $copyCount = DrawingsControlledCopy::where('drawing_no','=',$request->input('drawing_no'))
                                                ->where('revision_no','=',$request->input('revision_no'))
                                                ->count();
                                                           
            $fileName = self::pdfx($request->input('id'),"controlled");
            $filePath = str_replace('\\','/', $fileName);
            $newFileName = substr($filePath, -49, 51);

            $cc = new DrawingsControlledCopy();
            $cc->ecn_code = $request->input('ecn_code');
            $cc->part_name = $request->input('part_name');
            $cc->cust_code = $request->input('cust_code');
            $cc->project_code = $request->input('project_code');
            $cc->file_name = $newFileName;
            $cc->revision_no = $request->input('revision_no');
            $cc->drawing_no = $request->input('drawing_no');
            $cc->copy_no = $copyCount + 1;
            $cc->department = $request->input('dept');
            $cc->designer = $request->input('designer');
            $cc->released_by = Auth::user()->emp_no;
            $cc->status = 'For Receiving';

            $drawing = DrawingsMasterCopy::where('drawing_no','=',$request->input('drawing_no'))
                                            ->where('revision_no','=',$request->input('revision_no'))
                                            ->first();
            $drawing->status = 'Created';
            $drawing->updated_by = Auth::user()->emp_no;

            $revisions = DrawingsRevision::where('drawing_no','=',$request->input('drawing_no'))
                                            ->where('revision_no','=',$request->input('revision_no'))
                                            ->count();
            if($revisions)
                {
                    if($copyCount>=1)
                    {
                        $revision = DrawingsRevision::where('drawing_no','=',$request->input('drawing_no'))
                                                    ->where('revision_no','=',$request->input('revision_no'))
                                                    ->first();
                        $revision->status = 'Created';
                        $revision->save();
                    } 
                }

            if($cc->save()){
                $drawing->save();
                return redirect()->route('drawing.index', ['#controlled'])->withSuccess('Controlled Copy Successfully Created');
            }
        }
    }

    public function makeStamp($cc)
    {   
        // copy count, 
        $img = Image::make(realpath('../storage/app/assets/copy_cc.png'));  
        $img->text($cc + 1, 65, 96, function($font) {  
            $font->file(realpath('../storage/app/assets/cc.ttf'));  
            $font->size(9);  
            $font->color('#000000');  
            $font->align('center');  
            $font->valign('bottom');  
        }); 
        // released by user
        $img->text(Auth::user()->emp_no, 152, 96, function($font) {  
            $font->file(realpath('../storage/app/assets/cc.ttf'));  
            $font->size(9);  
            $font->color('#000000');  
            $font->align('center');  
            $font->valign('bottom');  
        }); 
        // date
        $img->text(date('Y-m-d'), 225, 96, function($font) {  
            $font->file(realpath('../storage/app/assets/cc.ttf'));  
            $font->size(9);  
            $font->color('#000000');  
            $font->align('center');  
            $font->valign('bottom');  
        }); 
        
        $img->save('../storage/app/assets/stamps/copy_cc.png'); 
    }

    public function revision(Request $request)
    {
        $field = [
            // 'ecn_code' => 'required',
            // 'doctitle' => 'required',
            // 'docno' => 'required',
            // 'revno' => 'required',
            // 'desc' => 'required',
            // 'reas' => 'required',
            // 'file' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('drawing.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            
            $drawing = new Drawing();
            $drawing->ecn_code = $request->input('ecn_code','');
            $drawing->cust_code = $request->input('cust_code','');
            $drawing->project_code = $request->input('project_code','');
            $drawing->part_name = $request->input('part_name','');
            $drawing->drawing_no = $request->input('drawing_no','');
            $drawing->revision_no = $request->input('revision_no','');
            $drawing->revision_date = $request->input('revision_date','');
            $drawing->process_specs = $request->input('process_specs','');
            $drawing->change_description = $request->input('change_description','');
            $drawing->change_reason = $request->input('change_reason','');
            $drawing->assy_code = $request->input('assy_code','');
            $drawing->fab_code = $request->input('fab_code','');

            $drawing->created_by = Auth::user()->emp_no;
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
                            $drawing->current_sequence = $request->input('app_seq.'.$i);
                            $drawing->current_approver = $request->input('app_id.'.$i);
                        }
                    }

                    $approvers = json_encode($approvers);            
                    $drawing->matrix = $approvers;
            }

            $drawing->reviewed_by = '';
            $drawing->approved_by = '';
            $drawing->status = 'Pending';

            if($request->hasFile('file'))
            { 
                $path = $request->file('file')->store('drawings/draft'); 
                $url = env('APP_URL') . Storage::url($path);
            }  

            $drawing->file_name = $path;
            if($drawing->save()){
                return redirect()->route('drawing.index')->withSuccess('Drawing Revision Successfully Added');
            }
        }
    }

    public function show($id)
    {
        //
    }

    public function view($id, $loc)
    {    
        $drawing = Drawing::find($id);
        $employee = Employee::where('emp_no','=',$drawing->created_by)
                            ->first();
        return view('res.drawing.view')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('loc', $loc)
                ->with('employee',$employee)
                ->with('drawings', $drawing);
    }

    public function view_fcc($id, $loc)
    {    
        $drawingx = DrawingsMasterCopy::find($id);
        $drawing = Drawing::where('drawing_no','=', $drawingx->drawing_no)
                                ->where('ecn_code','=', $drawingx->ecn_code)
                                ->where('revision_no','=', $drawingx->revision_no)
                                ->first();
        $employee = Employee::where('emp_no','=',$drawing->created_by)
                                ->first();
        return view('res.drawing.view')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('loc',$loc)
                ->with('employee',$employee)
                ->with('drawings', $drawing);
    }

    public function view_cc($id, $loc)
    {    
        $drawingx = DrawingsControlledCopy::find($id);
        // return $drawingx;
        $drawing = Drawing::where('drawing_no','=', $drawingx->drawing_no)
                                ->where('ecn_code','=', $drawingx->ecn_code)
                                ->where('revision_no','=', $drawingx->revision_no)
                                ->first();
        $employee = Employee::where('emp_no','=',$drawing->created_by)
                                ->first();
        return view('res.drawing.view')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('loc',$loc)
                ->with('employee',$employee)
                ->with('drawings', $drawing)
                ->with('drawingx', $drawingx);
    }

    public function approval_view($id, $loc)
    {    
        $drawing =    Drawing::find($id);
        $drawings =   Drawing::where('ecn_code','=',$drawing->ecn_code)
                                    ->where('drawing_no','=',$drawing->drawing_no)
                                    ->first();
        $employee =   Employee::where('emp_no','=',$drawings->created_by)->first();
        $drawings_h = Drawing::where('revision_no','=',$drawing->revision_no-1)->first();
 
        return view('res.drawing.approval')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('idx', $id) 
                ->with('loc', $loc)
                ->with('employee',$employee)
                ->with('drawings', $drawings)
                ->with('drawings_h', $drawings_h);
    }

    public function master_view($id, $loc)
    {    
        $drawing = Drawing::find($id);
        $employee = Employee::where('emp_no','=',$drawing->created_by)->first();
        $drawings = Drawing::where('drawing_no','=',$drawing->drawing_no) 
                                ->where('revision_no','=',$drawing->revision_no)
                                ->where('ecn_code','=',$drawing->ecn_code)
                                ->first();           
        $customer = Customer::where('cust_code','=',$drawings->cust_code)->first();
        // $project  = Project::where('project_code','=',$drawings->project_code)->first();
        $assy = Assembly::where('assy_code','=',$drawings->assy_code)->first();
        $fab = Fabrication::where('fab_code','=',$drawings->fab_code)->first();
                        
 
        return view('res.drawing.master')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('idx', $id) 
                ->with('loc', $loc)
                ->with('employee', $employee)
                ->with('drawings', $drawings)
                ->with('customer', $customer)
                // ->with('project', $project)
                ->with('assy', $assy)
                ->with('fab', $fab);
 
    }

    public function copy_view($id, $loc)
    {  
        $drawing =      DrawingsMasterCopy::find($id);
        $drawings =     Drawing::where('drawing_no','=',$drawing->drawing_no) 
                                    ->where('revision_no','=',$drawing->revision_no)
                                    ->where('ecn_code','=',$drawing->ecn_code)
                                    ->first();
        $drawings_h =   Drawing::where('drawing_no','=',$drawing->drawing_no) 
                                    ->where('revision_no','=',$drawing->revision_no-1)
                                    ->where('ecn_code','=',$drawing->ecn_code)
                                    ->first();
        $employee =     Employee::where('emp_no','=',$drawings->created_by)->first();
        $customer = Customer::where('cust_code','=',$drawings->cust_code)->first();
        // $project  = Project::where('project_code','=',$drawings->project_code)->first();
        $assy = Assembly::where('assy_code','=',$drawings->assy_code)->first();
        $fab = Fabrication::where('fab_code','=',$drawings->fab_code)->first();

        $copyCount =    DrawingsControlledCopy::where('drawing_no','=',$drawing->drawing_no)
                                    ->where('revision_no','=',$drawing->revision_no)
                                    ->count();
      
        $cc =           DrawingsControlledCopy::where('drawing_no','=',$drawing->drawing_no)->get();
        $dept_code = array();
        foreach($cc as $dept)
        {
            array_push($dept_code,$dept["department"]);
        }
      
        $deptx =        DrawingsMasterCopy::where('drawing_no','=',$drawing->drawing_no)
                                            ->where('revision_no','=',$drawing->revision_no)
                                            ->where('ecn_code','=',$drawing->ecn_code)
                                            ->with('dept_details:dept_code,dept_desc')
                                            ->first();
        $department =   Department::whereNotIn('dept_code',$dept_code)->get();
 
        return view('res.drawing.copy')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('loc', $loc)
                ->with('drawings', $drawings)
                ->with('copyCount', $copyCount)
                ->with('employee', $employee)
                ->with('drawings_h', $drawings_h)
                ->with('department', $department)
                ->with('deptx', $deptx)
                ->with('customer', $customer)
                // ->with('project', $project)
                ->with('assy', $assy)
                ->with('fab', $fab);
    }

    public function getDocument($id, $stat, $loc, $cc)
    {   
        
        switch($loc){
            case "drawings":
                $document = Drawing::find($id);
                $filename = str_replace("drawings/", "", $document->file_name);
                $filePath = $document->file_name;
                break;
            case "app":
                $document = Drawing::find($id);
                $filename = str_replace("drawings/", "", $document->file_name);
                $filePath = $document->file_name;
                break;
            case "master":
                if($stat=="Created"){
                    $document = Drawing::find($id);
                    $documentm = DrawingsMasterCopy::where('ecn_code','=',$document->ecn_code)
                                                    ->where('revision_no','=',$document->revision_no)
                                                    ->first();
                    $filename = $documentm->file_name;
                    $filePath = "drawings/master/".$documentm->file_name;
                } elseif ($stat=="Received") {
                    $document = Drawing::find($id);
                    $documentm = DrawingsMasterCopy::where('ecn_code','=',$document->ecn_code)
                                                    ->where('revision_no','=',$document->revision_no)
                                                    ->first();
                    $filename = $documentm->file_name;
                    $filePath = "drawings/master/".$documentm->file_name;
                } elseif ($stat=="Obsolete") {
                    $document = Drawing::find($id);
                    $filename = 'obsm_'.str_replace("drawings/draft/", "", $document->file_name);
                    $filePath = 'drawings/obsolete/'.$filename;
                }else {
                    $document = Drawing::find($id);
                    $filename = str_replace("drawings/", "", $document->file_name);
                    $filePath = $document->file_name;
                }
                break;
            case "controlled":
                if($stat=="Created"){
                    $document = Drawing::find($id);
                    $filename = str_replace("drawings/draft/", "", $document->file_name);
                    $filePath = 'drawings/draft/'.$filename;
                } elseif ($stat=="Obsolete") {
                    $document = Drawing::find($id);
                    $filename = 'obs_'.str_replace("drawings/draft/", "", $document->file_name);
                    $filePath = 'drawings/obsolete/'.$filename;
                } elseif ($stat=="Approved") {
                    $document = Drawing::find($id);
                    $filename = str_replace("drawings/", "", $document->file_name);
                    $filePath = $document->file_name;
                } elseif ($stat=="Received") {
                    $document = Drawing::find($id);
                    $documentc = DrawingsControlledCopy::where('ecn_code','=',$document->ecn_code)
                                                    ->where('revision_no','=',$document->revision_no)
                                                    ->first();
                    $filename = $documentc->file_name;
                    $filePath = "drawings/controlled/".$documentc->file_name;
                }  
                break;
            case "cc": 
                if($stat=="Created"){
                    $document = Drawing::find($id);
                    $documentcc = DrawingsControlledCopy::where('ecn_code','=',$document->ecn_code)
                                                    ->where('revision_no','=',$document->revision_no)
                                                    ->where('copy_no','=', $cc)
                                                    ->first();
                    $filename = $documentcc->file_name;
                    $filePath = "drawings/controlled/".$documentcc->file_name;
                } elseif ($stat=="Received") {
                    $document = Drawing::find($id);
                    $documentc = DrawingsControlledCopy::where('ecn_code','=',$document->ecn_code)
                                                    ->where('revision_no','=',$document->revision_no)
                                                    ->first();
                    $filename = $documentc->file_name;
                    $filePath = "drawings/controlled/".$documentc->file_name;
                } elseif ($stat=="Obsolete") {
                    $document = Drawing::find($id);
                    $filename = 'obsc_'.str_replace("drawings/draft/", "", $document->file_name);
                    $filePath = 'drawings/obsolete/'.$filename;
                } elseif ($stat=="Approved") {
                    $document = Drawing::find($id);
                    $filename = str_replace("drawings/", "", $document->file_name);
                    $filePath = $document->file_name;
                } 
                break;
          
        }

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

    public function check($id,$loc)
    {
        $locx = $loc;
        $drawing = Drawing::where('ecn_code','=',$id)
                            ->where('current_approver','=',Auth::user()->emp_no)
                            ->first();
            
        if($locx=='app')
        {
            return redirect()->route('drawing.approval', ['drawingID' => $drawing->id, 'loc' => $locx]);
        } else {
            return redirect()->route('drawing.view', ['drawingID' => $drawing->id, 'loc' => $locx]);
        }


        // 

    }

    public function revise($id)
    {
        
        $employeeSec = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $docxCount = Drawing::where('created_by','=',Auth::user()->emp_no)
                                ->count();
        $lastDocx = str_pad($docxCount+1,3,"0",STR_PAD_LEFT);
        $docNo =  $employeeSec->sect_code."-".$lastDocx;
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Drawings')
        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"masterlist":false,"approval":false}]', true));
        $drawing = Drawing::find($id);
        $drawings = Drawing::where('drawing_no','=',$drawing->drawing_no)
                                ->where('revision_no','=',$drawing->revision_no)
                                ->first();
        
        $revCount = Drawing::where('drawing_no','=',$drawing->drawing_no)
                                ->count();

        $customer = Customer::get();
        $assembly = Assembly::get();
        $fabrication = Fabrication::get();
        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        
        return view('res.drawing.revise')
                ->with('site','res')
                ->with('page','dcc')
                ->with('subpage','drawings')
                ->with('docNo',$docNo)
                ->with('permission',$permissionx)
                ->with('lastDoc', $lastDocx)
                ->with('revCount', $revCount)
                ->with('drawings', $drawings)
                ->with('customer', $customer)
                ->with('employee', $employee)
                ->with('assembly', $assembly)
                ->with('fabrication', $fabrication);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function receive(Request $request)
    {
        $receive = DrawingsControlledCopy::find($request->input('id'));
        $receive->status = 'Received';
        $receive->receive_date = date('Y-m-d H:i:s');
        $receive->receive_by = Auth::user()->emp_no;

        $cc = DrawingsControlledCopy::where('drawing_no','=',$receive->drawing_no)->count();
        if($cc)
        {
            $rev = DrawingsRevision::where('drawing_no','=',$receive->drawing_no)->count();
            if($rev)
            {
                $receivedR = DrawingsRevision::where('drawing_no','=',$receive->drawing_no)
                ->where('revision_no','=',$receive->revision_no)
                ->first();
                $receivedR->status = 'Received';
                $receivedR->save();
            }
        }
        
        if($receive->save()){
            return redirect()->route('drawing.index', ['#controlled'])->withSuccess('Drawing Successfully Received');
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

            $drawing_app = Drawing::find($request->input('id', ''));
            $curr_status = $drawing_app->status;
            $curr_seq_db = $drawing_app->current_sequence;
    
            $curr_id = $request->input('id','');
            $curr_seq = $request->input('seq','');
            $curr_app = $request->input('appid','');
            $status = $request->input('status','');
            $remarks = $request->input('remarks','');
 
            $date = date('Y-m-d H:i:s');

            $matrix = json_decode($drawing_app->matrix, true);
            $matrixh = json_decode($drawing_app->matrix_h) ? json_decode($drawing_app->matrix_h) : array();

            $gate = $matrix[0]['is_gate'];
            $next_status = $matrix[0]['next_status'];
            $next_app = $matrix[0]['approver_emp_no'];

            $lastid = DB::table('drawings')->latest('id')->first();
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
                    $drawing_app->status = 'Approved';
                    $drawing_app->reviewed_by = $curr_app;
                    $drawing_app->approved_by = $curr_app;
                    
                    $matrix = [];

                    $revNo = $request->input('revision_no') ? $request->input('revision_no') : 0;
                    $revNoH = $request->input('revision_no_h') ? $request->input('revision_no_h') : 0;

                        if($revNo>=1)
                            {   
                              
                                if($revNoH==0)
                                {   
                                   
                                    $drawings_h = new DrawingsRevision();
                                    $drawings_h->ecn_code =            $request->input('ecn_code_h');
                                    $drawings_h->cust_code =           $request->input('cust_code_h');
                                    $drawings_h->project_code =        $request->input('project_code_h');
                                    $drawings_h->part_name =           $request->input('part_name');
                                    $drawings_h->drawing_no =          $request->input('drawing_no_h');
                                    $drawings_h->revision_no =         $request->input('revision_no_h');
                                    $drawings_h->revision_date =       $request->input('revision_date_h');
                                    $drawings_h->process_specs =       $request->input('process_specs_h');
                                    $drawings_h->change_description =  $request->input('change_description_h');
                                    $drawings_h->change_reason =       $request->input('change_reason_h');
                                    $drawings_h->assy_code =           $request->input('assy_code_h');
                                    $drawings_h->fab_code =            $request->input('fab_code_h');
                                    $drawings_h->created_by =          $request->input('created_by_h');
                                    $drawings_h->approved_by =         $request->input('approved_by_h');
                                    $drawings_h->status =              $request->input('status_h');
                                    $drawings_h->file_name =           $request->input('file_name_h');
                                    $drawings_h->save();
                                }
                                    $drawing = new DrawingsRevision();
                                    $drawing->ecn_code =                $request->input('ecn_code');
                                    $drawing->cust_code =               $request->input('cust_code');
                                    $drawing->project_code =            $request->input('ecn_code');
                                    $drawing->part_name =               $request->input('part_name');
                                    $drawing->drawing_no =              $request->input('drawing_no');
                                    $drawing->revision_no =             $request->input('revision_no');
                                    $drawing->revision_date =           $request->input('revision_date');
                                    $drawing->process_specs =           $request->input('process_specs');
                                    $drawing->change_description =      $request->input('change_description');
                                    $drawing->change_reason =           $request->input('change_reason');
                                    $drawing->assy_code =               $request->input('assy_code');
                                    $drawing->fab_code =                $request->input('fab_code');
                                    $drawing->created_by =              $request->input('created_by');
                                    $drawing->approved_by =             $curr_app;
                                    $drawing->status =                  $status;
                                    $drawing->file_name =               $request->input('file_name');
                                    $drawing->save();
                            }

                    $approver = Employee::where('emp_no','=',$empID)->first();
                    $maildetails = new DrawingMailable('REISS - Drawing Approval', // subject
                                                    'drawing', // location
                                                    'Approved', // next status val
                                                    'filer', // who to receive
                                                    $approver->emp_fname, // approver name
                                                    $drawing_app->ecn_code, // ecn_code
                                                    Auth::user()->employee->full_name, // full_name
                                                    $remarks, // remarks
                                                    $lastid); // last id + 1
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
                        $drawing_app->status = $next_status;
                        $drawing_app->approved_by = $curr_app;
                        $revNo = $request->input('revision_no') ? $request->input('revision_no') : 0;
                        $revNoH = $request->input('revision_no_h') ? $request->input('revision_no_h') : 0;
                        $test = "";
                        if($revNo>=1)
                            {
                                $test = "revno > 1";
                                if($revNoH==0)
                                {   
                                    $drawings_h = new DrawingsRevision();
                                    $drawings_h->ecn_code =            $request->input('ecn_code_h');
                                    $drawings_h->cust_code =           $request->input('cust_code_h');
                                    $drawings_h->project_code =        $request->input('ecn_code_h');
                                    $drawings_h->part_name =           $request->input('part_name');
                                    $drawings_h->drawing_no =          $request->input('drawing_no_h');
                                    $drawings_h->revision_no =         $request->input('revision_no_h');
                                    $drawings_h->revision_date =       $request->input('revision_date_h');
                                    $drawings_h->process_specs =       $request->input('process_specs_h');
                                    $drawings_h->change_description =  $request->input('change_description_h');
                                    $drawings_h->change_reason =       $request->input('change_reason_h');
                                    $drawings_h->assy_code =           $request->input('assy_code_h');
                                    $drawings_h->fab_code =            $request->input('fab_code_h');
                                    $drawings_h->created_by =          $request->input('created_by_h');
                                    $drawings_h->approved_by =         $request->input('approved_by_h');
                                    $drawings_h->status =              $request->input('status_h');
                                    $drawings_h->file_name =           $request->input('file_name_h');
                                    $drawings_h->save();
                                }
                                    $drawing = new DrawingsRevision();
                                    $drawing->ecn_code =                $request->input('ecn_code');
                                    $drawing->cust_code =               $request->input('cust_code');
                                    $drawing->project_code =            $request->input('ecn_code');
                                    $drawing->part_name =               $request->input('part_name');
                                    $drawing->drawing_no =              $request->input('drawing_no');
                                    $drawing->revision_no =             $request->input('revision_no');
                                    $drawing->revision_date =           $request->input('revision_date');
                                    $drawing->process_specs =           $request->input('process_specs');
                                    $drawing->change_description =      $request->input('change_description');
                                    $drawing->change_reason =           $request->input('change_reason');
                                    $drawing->assy_code =               $request->input('assy_code');
                                    $drawing->fab_code =                $request->input('fab_code');
                                    $drawing->created_by =              $request->input('created_by');
                                    $drawing->approved_by =             $curr_app;
                                    $drawing->status =                  $status;
                                    $drawing->file_name =               $request->input('file_name');
                                    $drawing->save();

                            }
                        $drawing_app->approved_by = $curr_app;
                        
                        $approver = Employee::where('emp_no','=',$empID)->first();
                        $maildetails = new DrawingMailable('REISS - Drawing Approval', // subject
                                                        'drawing', // location
                                                        'Approved', // next status val
                                                        'filer', // who to receive
                                                        $approver->emp_fname, // approver name
                                                        $drawing_app->ecn_code, // drawing_no
                                                        Auth::user()->employee->full_name, // full_name
                                                        $remarks, // remarks
                                                        $lastid); // last id + 1
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
                        $drawing_app->status = $next_status;
                        $drawing_app->reviewed_by = $curr_app;
                        
                        $approver = Employee::where('emp_no','=',$empID)->first();
                        $maildetails = new DrawingMailable('REISS - Drawing Approval', // subject
                                                        'drawing', // location
                                                        $next_status, // next status val
                                                        'approver', // who to receive
                                                        $approver->emp_fname, // approver name
                                                        $drawing_app->ecn_code, // drawing_no
                                                        Auth::user()->employee->full_name, // full_name
                                                        $remarks, // remarks
                                                        $lastid); // last id + 1
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
                $drawing_app->status = 'Rejected';
                $drawing_app->approved_by = 'N/A';
                $drawing_app->reviewed_by = $curr_app;
                
                $matrix = [];
 
                $approver = Employee::where('emp_no','=',$empID)->first();
                $maildetails = new DrawingMailable('REISS - Drawing Approval', // subject
                                                'drawing', // location
                                                'Rejected', // next status val
                                                'filer', // who to receive
                                                $approver->emp_fname, // approver name
                                                $drawing_app->ecn_code, // drawing_no
                                                Auth::user()->employee->full_name, // full_name
                                                $remarks, // remarks
                                                $lastid); // last id + 1
                
            }
            
            $drawing_app->current_sequence = $curr_seq;
            $drawing_app->current_approver = $empID;
            $drawing_app->matrix = json_encode($matrix);
            $drawing_app->matrix_h = json_encode($matrixh);
        
            if($drawing_app->save()){
                if($status=='Approved'){
                    // Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('drawing.index', ['#approval'])->withSuccess('Drawing Successfully Approved');
                } else {
                    // Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                    return redirect()->route('drawing.index', ['#approval'])->withSuccess('Drawing Successfully Rejected');
                }
            }
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        $stat = $request->input('stat');
        if($stat=='Obsolete')
        {
            $drawingcc = DrawingsControlledCopy::find($request->input('id'));
            $drawing = Drawing::where('ecn_code','=',$drawingcc->ecn_code)
                                ->where('revision_no','=',$drawingcc->revision_no)
                                ->first();
            Storage::delete('drawings/obsolete/obsc_'.str_replace("drawings/draft/","",$drawing->file_name)); 
        }
        else
        {
            $drawingcc = DrawingsControlledCopy::find($request->input('id'));
            Storage::delete('drawings/controlled/'.$drawingcc->file_name); 
        }
      
        if(DrawingsControlledCopy::destroy($drawingcc->id)){
            return redirect()->route('drawing.index',['#controlled'])->withSuccess('Drawing Controlled Copy Successfully Deleted');
        }
    }
}
