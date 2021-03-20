<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\SitePermission;
use App\Employee;
use Validator;

class SitePermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = SitePermission::all();
        $employee = Employee::all();
        return view('res.permission.index')
                ->with(array(
                    'site' => 'res',
                    'page' => 'admin',
                    'subpage' => 'permission',
                    'employee' => $employee,
                ));
    }

    public function all()
    {
        return response()
            ->json([
                "data" => SitePermission::with('employee_details:emp_no,emp_fname,emp_lname')
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
            'add_requestor' => 'required',
            'add_module' => 'required',
        ];
        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('permission.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{

        
            $permission = new SitePermission();
            $permission->module = $request->input('add_module','');
            $permission->requestor = $request->input('add_requestor','');

            $all = $request->input('all') ? "true":"false";
            $permissionx = array();

            if($all=="true")
            {
                array_push($permissionx,[
                    'add' => true,
                    'edit' => true,
                    'view' => true,
                    'delete' => true,
                    'void' => true,
                    'approval' => true,
                ]);
            }
            else 
            {
                array_push($permissionx,[
                    'add' =>      $request->input('add') ? true:false,
                    'edit' =>     $request->input('edit') ? true:false,
                    'view' =>     $request->input('view') ? true:false,
                    'delete' =>   $request->input('delete') ? true:false,
                    'void' =>     $request->input('void') ? true:false,
                    'approval' => $request->input('app') ? true:false,
                ]);
            }

            $permissionx = json_encode($permissionx);
            $permission->permission = $permissionx;

            if($permission->save()){
                return redirect()->route('permission.index')->withSuccess('Site Permission Successfully Added');
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
            "data" => SitePermission::where('id','=',$id)
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
            'module' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
                              
        if ($validator->fails()) {
            return  back()->withInput()
                            ->withErrors($validator);
        }else{
 
            $permission = SitePermission::find($request->input('id'));
            $permission->module = $request->input('module','');
 
            $all = $request->input('all') ? true:false;
            $permission_e = array();
 
            if($all)
            {
                array_push($permission_e,[
                    'add' => true,
                    'edit' => true,
                    'view' => true,
                    'delete' => true,
                    'void' => true,
                    'approval' => true,
                ]);
            }
            else 
            {
                array_push($permission_e,[
                    'add' =>      $request->input('add') ? true:false,
                    'edit' =>     $request->input('edit') ? true:false,
                    'view' =>     $request->input('view') ? true:false,
                    'delete' =>   $request->input('delete') ? true:false,
                    'void' =>     $request->input('void') ? true:false,
                    'approval' => $request->input('app') ? true:false,
                ]);
            }


            $permission_e = json_encode($permission_e);
            $permission->permission = $permission_e;
        
            if($permission->save()){
                return redirect()->route('permission.index')->withSuccess('Site Permission Successfully Updated');
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
        if(SitePermission::destroy($request->input('id',''))){
            return redirect()->route('permission.index')->withSuccess('Site Permission Successfully Deleted');
        }
    }
}
