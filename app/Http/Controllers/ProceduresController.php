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

    public function destroy($id)
    {
        //
    }
}
