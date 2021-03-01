<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\ApproverMatrix;
use App\Employee;
use Validator;

class ApproverMatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
     
        $matrix = ApproverMatrix::all();
        $employee = DB::table('employees')
                        ->select('emp_no','emp_fname')
                        ->orderBy('emp_fname')
                        ->get();
        return view('res.approver.index')
                ->with(array(
                    'site' => 'res',
                    'page' => 'admin',
                    'subpage' => 'approver',
                    'employee' => $employee,
                    'matrix' => $matrix
                ));
    }

    public function all()
    {
        return response()
            ->json([
                "data" => ApproverMatrix::with('employee_details:emp_no,emp_fname')
                                    ->get()
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
        $field = [
            'app_module' => 'required',
            // 'requestor' => 'required',
        ];
        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('approver.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

            $approver = new ApproverMatrix();
            $approver->module = $request->input('app_module','');
            $approver->requestor = $request->input('app_req','');
        
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
                    }

                    $approvers = json_encode($approvers);            
                    $approver->matrix = $approvers;
                }
            if($approver->save()){
                return redirect()->route('approver.index')->withSuccess('Approver Details Successfully Added');
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
                "data" => ApproverMatrix::where('id','=',$id)
                            ->with('employee_details:emp_no,emp_fname')
                            ->first()
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
            'edit_app_module' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
                              
        if ($validator->fails()) {
            return  back()->withInput()
                            ->withErrors($validator);
        }else{

            $approver = ApproverMatrix::find($request->input('edit_id', ''));
            $approver->module = $request->input('edit_app_module','');
            $approver->requestor = $request->input('edit_app_req','');
        
            if($request->input('edit_app_seq'))
                {
                    $approvers = array();

                    for( $i = 0 ; $i < count($request->input('edit_app_seq')) ; $i++ )
                    {
                        array_push($approvers, [
                                                'sequence' => $request->input('edit_app_seq.'.$i),
                                                'approver_emp_no' => $request->input('edit_app_id.'.$i),
                                                'approver_name' => $request->input('edit_app_fname.'.$i),
                                                'next_status' => $request->input('edit_app_nstatus.'.$i),
                                                'is_gate' => $request->input('edit_app_gate.'.$i)
                                                ]);
                    }

                    $approvers = json_encode($approvers);            
                    $approver->matrix = $approvers;
                }
            if($approver->save()){
                return redirect()->route('approver.index')->withSuccess('Approver Details Successfully Updated');
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

    public function delete(Request $request)
    {
        //
        if(ApproverMatrix::destroy($request->input('id',''))){
            return redirect()->route('approver.index')->withSuccess('Approver Matrix Details Successfully Deleted');
        }
    }
}
