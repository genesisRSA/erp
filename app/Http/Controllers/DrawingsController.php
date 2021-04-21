<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
// use App\Mail\ProcedureMailable;
use App\SitePermission;
use App\ApproverMatrix;
// use App\Procedure;
// use App\ProceduresRevision;
// use App\ProceduresMasterCopy;
// use App\ProceduresControlledCopy;
use App\Drawing;
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

    public function all($id, $loc)
    {
        $idx = Crypt::decrypt($id);
        $locx = $loc;

        $userDept = Employee::select('dept_code')->where('emp_no','=',$idx)->first();

        $permission = SitePermission::where('requestor','=',$idx)
                                    ->where('module','=','Procedures')
                                    ->first();

        $permissionx =  ($permission ? json_decode($permission->permission) : 
                                    json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"masterlist":false,"approval":false}]'));
        
        switch($locx){
            case "procedures":
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
