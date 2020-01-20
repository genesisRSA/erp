<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Employee;
use App\Site;
use App\User;
use Auth;
use Validator;
use Session;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        //
        if(Auth::user()->is_admin || Auth::user()->is_hr)
        {
            return view("pages.hris.dashboard.employees.index")
                ->with(array('site'=> 'hris', 'page'=>'employees'));  
        }else
        {
            return redirect('hris/home');
        }
        
    }

    public function all($is_admin = false)
    {
        $data = Employee::where('emp_no', '<>', 'admin')
                        ->with('site:site_code,site_desc')
                        ->with('department:dept_code,dept_desc')
                        ->with('section:sect_code,sect_desc')
                        ->orderBy('emp_lname','ASC')
                        ->get()
                        ->each
                        ->append(['full_name','id_no']);
        
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
        $access_id = DB::connection('mysql_live')->select("SELECT id as access_id,CONCAT(emp_lastname,', ',emp_firstname) as emp_name from hr_employee WHERE emp_active = 1 ORDER BY emp_lastname");
        $sites =  Site::all();
        return view('pages.hris.dashboard.employees.create')
                ->with(array('site' => 'hris', 
                            'page' => 'employees', 
                            'access_id' => $access_id,
                            'sites' => $sites,
                            'employees' => Employee::orderBy('emp_lname','asc')->get()
                        )); 
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
        $field = [
            'emp_img' => 'required|image',
            'site_code' => 'required',
            'access_id' => 'required',
            'emp_no' => 'required|string|unique:employees',
            'work_email' => 'required',
            'dept_code' => 'required|string',
            'sect_code' => 'required|string',
            'position' => 'required|string',
            'date_hired' => 'date',
            'emp_cat' => 'required|string',
            'date_regularized' => 'date',
            'sss_no' => 'required|string|unique:employees',
            'phil_no' => 'required|string|unique:employees',
            'pagibig_no' => 'required|string|unique:employees',
            'tin_no' => 'required|string|unique:employees',
            'emp_fname' => 'required|string',
            'emp_lname' => 'required|string',
            'dob' => 'date',
            'current_address' => 'required|string',
            'home_address' => 'required|string',
            'emergency_person' => 'required|string',
            'emergency_address' => 'required|string',
            'emergency_contact' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            
            if($request->hasfile('emp_img')) 
            { 
                $file = $request->file('emp_img');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->storeAs(
                    "public/profile", $filename
                );
            }

            $employee = new Employee();
            $employee->emp_no = $request->input('emp_no','');
            $employee->emp_photo = 'storage/profile/'.$filename;
            $employee->access_id = $request->input('access_id','');
            $employee->work_email = $request->input('work_email','').$request->input('email_suffix','');
            $employee->site_code = $request->input('site_code','');
            $employee->dept_code = $request->input('dept_code','');
            $employee->sect_code = $request->input('sect_code','');
            $employee->position = $request->input('position','');
            $employee->reports_to = $request->input('reports_to','');
            $employee->date_hired = $request->input('date_hired','1990-01-01');
            $employee->emp_cat = $request->input('emp_cat','Probationary');
            $employee->date_regularized = $request->input('emp_cat','') == 'Regular' ? $request->input('date_regularized','1990-01-01') : '1990-01-01';
            $employee->is_hmo = $request->input('is_hmo',false) ? true : false;
            $employee->hmo_cardno = $request->input('hmo_cardno','') ? $request->input('hmo_cardno','') : '';
            $employee->sss_no = $request->input('sss_no','N/A');
            $employee->phil_no = $request->input('phil_no','N/A');
            $employee->pagibig_no = $request->input('pagibig_no','N/A');
            $employee->tin_no = $request->input('tin_no','N/A');
            $employee->emp_fname = $request->input('emp_fname','N/A');
            $employee->emp_lname = $request->input('emp_lname','N/A');
            $employee->emp_mname = $request->input('emp_mname','');
            $employee->emp_suffix = $request->input('emp_suffix','');
            $employee->dob = $request->input('dob','1990-01-01');
            $employee->gender = $request->input('gender','Female');
            $employee->status = $request->input('status','Single');

            if($request->input('dep_name')){
                $dependencies = array();

                for( $i = 0 ; $i < count($request->input('dep_name')) ; $i++ ){
                    array_push($dependencies, [ 'dep_name' => $request->input('dep_name.'.$i),
                                                'dep_dob' => $request->input('dep_dob.'.$i),
                                                'dep_rel' => $request->input('dep_rel.'.$i)
                                              ]);
                }

                $dependencies = json_encode($dependencies);
                $employee->dependencies = $dependencies;

            }

            $leave_credits = array(
                'sick_leave' => $request->input('sick_leave'),
                'vacation_leave' => $request->input('vacation_leave'),
                'solo_parent_leave' => $request->input('solo_parent_leave'),
                'admin_leave' => $request->input('admin_leave'),
                'bereavement_leave' => $request->input('bereavement_leave'),
                'bday_leave' => $request->input('bday_leave'),
                'maternity_leave' => $request->input('maternity_leave'),
                'paternity_leave' => $request->input('paternity_leave'),
                'special_leave' => $request->input('special_leave'),
                'abused_leave' => $request->input('abused_leave'),
                'expanded_leave' => $request->input('expanded_leave')
            );
           
            $medical_info = array(
                'blood_type' => $request->input('blood_type'),
                'emp_height' => $request->input('emp_height') ? $request->input('emp_height') : 0,
                'emp_weight' => $request->input('emp_weight') ? $request->input('emp_weight') : 0,
                'medical_issues' => $request->input('medical_issues') ? $request->input('medical_issues') : 'N/A',
                'birth_mark' => $request->input('birth_mark') ? $request->input('birth_mark') : 'N/A'
            );

            $employee->leave_credits = json_encode($leave_credits);
            $employee->medical_info = json_encode($medical_info);
            $employee->current_address = $request->input('current_address','N/A');
            $employee->home_address = $request->input('home_address','N/A');
            $employee->tel_no = $request->input('tel_no','N/A') ? $request->input('tel_no','') : '';
            $employee->mobile_no = $request->input('mobile_no','N/A') ? $request->input('mobile_no','') : '';
            $employee->personal_email = $request->input('personal_email','') ? $request->input('personal_email','') : '';
            $employee->emergency_person = $request->input('emergency_person','N/A');
            $employee->emergency_address = $request->input('emergency_address','N/A');
            $employee->emergency_contact = $request->input('emergency_contact','N/A');

            if($employee->save()){
                return redirect()->route('employees.index')->withSuccess('Employee Successfully Added!');
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
        $employee = Employee::find(Crypt::decrypt($id));
        $reports_to = Employee::where('emp_no','=',$employee->reports_to)->first();
        
        if(!$leave_credits = json_decode($employee->leave_credits)){
            $leave_credits = json_decode( json_encode( array(
                'sick_leave' => 0,
                'vacation_leave' => 0,
                'solo_parent_leave' => 0,
                'admin_leave' => 0,
                'bereavement_leave' => 0,
                'bday_leave' => 0,
                'maternity_leave' => 0,
                'paternity_leave' => 0,
                'special_leave' => 0,
                'abused_leave' => 0,
                'expanded_leave' => 0
            ) ) );
        }

        if(!$medical_info = json_decode($employee->medical_info)){
            $medical_info = json_decode( json_encode( array(
                'blood_type' => 'O-',
                'emp_height' => 0,
                'emp_weight' => 0,
                'medical_issues' => 'N/A',
                'birth_mark' => 'N/A'
            ) ) );
        }

        return view('pages.hris.dashboard.employees.show')
                    ->with(array('site'=> 'hris', 'page'=>'employees'))
                    ->with('dep',json_decode($employee->dependencies))
                    ->with('employee',$employee)
                    ->with('reports_to',$reports_to)
                    ->with('leave_credits',$leave_credits)
                    ->with('medical_info',$medical_info);
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
        $employee = Employee::find(Crypt::decrypt($id));
        $access_id = DB::connection('mysql_live')->select("SELECT id as access_id,CONCAT(emp_lastname,', ',emp_firstname) as emp_name from hr_employee WHERE emp_active = 1 and id = '".$employee->access_id."' ORDER BY emp_lastname")[0];
        $departments =  \App\Department::where('site_code','=',$employee->site_code)->get();
        $sections =  \App\Section::where('dept_code','=',$employee->dept_code)->get();
        $positions =  \App\Position::where('sect_code','=',$employee->sect_code)->get();
        $dependencies = json_decode($employee->dependencies);
        
        if(!$leave_credits = json_decode($employee->leave_credits)){
            $leave_credits = json_decode( json_encode( array(
                'sick_leave' => 0,
                'vacation_leave' => 0,
                'solo_parent_leave' => 0,
                'admin_leave' => 0,
                'bereavement_leave' => 0,
                'bday_leave' => 0,
                'maternity_leave' => 0,
                'paternity_leave' => 0,
                'special_leave' => 0,
                'abused_leave' => 0,
                'expanded_leave' => 0
            ) ) );
        }

        if(!$medical_info = json_decode($employee->medical_info)){
            $medical_info = json_decode( json_encode( array(
                'blood_type' => 'O-',
                'emp_height' => 0,
                'emp_weight' => 0,
                'medical_issues' => 'N/A',
                'birth_mark' => 'N/A'
            ) ) );
        }

        return view('pages.hris.dashboard.employees.edit')
                ->with(array('site' => 'hris', 
                            'page' => 'employees', 
                            'access_id' => $access_id,
                            'departments' => $departments,
                            'sections' => $sections,
                            'positions' => $positions,
                            'dependencies' => $dependencies,
                            'employee' => $employee,
                            'leave_credits' => $leave_credits,
                            'employees' => Employee::where('id','<>',Crypt::decrypt($id))->orderBy('emp_lname','asc')->get()
                        ))
                ->with('medical_info',$medical_info); 
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
        $field = [
            'dept_code' => 'required|string',
            'sect_code' => 'required|string',
            'position' => 'required|string',
            'date_hired' => 'date',
            'emp_cat' => 'required|string',
            'date_regularized' => 'date',
            'sss_no' => 'required|string',
            'phil_no' => 'required|string',
            'pagibig_no' => 'required|string',
            'tin_no' => 'required|string',
            'emp_fname' => 'required|string',
            'emp_lname' => 'required|string',
            'dob' => 'date',
            'current_address' => 'required|string',
            'home_address' => 'required|string',
            'emergency_person' => 'required|string',
            'emergency_address' => 'required|string',
            'emergency_contact' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $employee = Employee::find($id);
            
            if($request->hasfile('emp_img')) 
            { 
                $file = $request->file('emp_img');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->storeAs(
                    "public/profile", $filename
                );
                $employee->emp_photo = 'storage/profile/'.$filename;
            }

            $employee->dept_code = $request->input('dept_code','');
            $employee->sect_code = $request->input('sect_code','');
            $employee->position = $request->input('position','');
            $employee->reports_to = $request->input('reports_to','');
            $employee->date_hired = $request->input('date_hired','1990-01-01');
            $employee->emp_cat = $request->input('emp_cat','Probationary');
            $employee->date_regularized = $request->input('emp_cat','') == 'Regular' ? $request->input('date_regularized','1990-01-01') : '1990-01-01';
            $employee->is_hmo = $request->input('is_hmo',false) ? true : false;
            $employee->hmo_cardno = $request->input('hmo_cardno','') ? $request->input('hmo_cardno','') : '';
            $employee->sss_no = $request->input('sss_no','N/A');
            $employee->phil_no = $request->input('phil_no','N/A');
            $employee->pagibig_no = $request->input('pagibig_no','N/A');
            $employee->tin_no = $request->input('tin_no','N/A');
            $employee->emp_fname = $request->input('emp_fname','N/A');
            $employee->emp_lname = $request->input('emp_lname','N/A');
            $employee->emp_mname = $request->input('emp_mname','');
            $employee->emp_suffix = $request->input('emp_suffix','');
            $employee->dob = $request->input('dob','1990-01-01');
            $employee->gender = $request->input('gender','Female');
            $employee->status = $request->input('status','Single');

            if($request->input('dep_name')){
                $dependencies = array();

                for( $i = 0 ; $i < count($request->input('dep_name')) ; $i++ ){
                    array_push($dependencies, [ 'dep_name' => $request->input('dep_name.'.$i),
                                                'dep_dob' => $request->input('dep_dob.'.$i),
                                                'dep_rel' => $request->input('dep_rel.'.$i)
                                              ]);
                }

                $dependencies = json_encode($dependencies);
                $employee->dependencies = $dependencies;

            }

            $leave_credits = array(
                'sick_leave' => $request->input('sick_leave'),
                'vacation_leave' => $request->input('vacation_leave'),
                'solo_parent_leave' => $request->input('solo_parent_leave'),
                'admin_leave' => $request->input('admin_leave'),
                'bereavement_leave' => $request->input('bereavement_leave'),
                'bday_leave' => $request->input('bday_leave'),
                'maternity_leave' => $request->input('maternity_leave'),
                'paternity_leave' => $request->input('paternity_leave'),
                'special_leave' => $request->input('special_leave'),
                'abused_leave' => $request->input('abused_leave'),
                'expanded_leave' => $request->input('expanded_leave')
            );
            $medical_info = array(
                'blood_type' => $request->input('blood_type'),
                'emp_height' => $request->input('emp_height') ? $request->input('emp_height') : 0,
                'emp_weight' => $request->input('emp_weight') ? $request->input('emp_weight') : 0,
                'medical_issues' => $request->input('medical_issues') ? $request->input('medical_issues') : 'N/A',
                'birth_mark' => $request->input('birth_mark') ? $request->input('birth_mark') : 'N/A'
            );

            $employee->leave_credits = json_encode($leave_credits);
            $employee->medical_info = json_encode($medical_info);
            $employee->current_address = $request->input('current_address','N/A');
            $employee->home_address = $request->input('home_address','N/A');
            $employee->tel_no = $request->input('tel_no','') ? $request->input('tel_no','') : '';
            $employee->mobile_no = $request->input('mobile_no','') ? $request->input('mobile_no','') : '';
            $employee->personal_email = $request->input('personal_email','') ? $request->input('personal_email','') : '';
            $employee->emergency_person = $request->input('emergency_person','N/A');
            $employee->emergency_address = $request->input('emergency_address','N/A');
            $employee->emergency_contact = $request->input('emergency_contact','N/A');

            if($employee->save()){
                return redirect()->route('employees.index')->withSuccess('Employee Successfully Updated!');
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

    public function account($id)
    {
            $employee = Employee::find(Crypt::decrypt($id));
            $user = User::where('emp_no','=',$employee->emp_no)->first();

            return view('pages.hris.dashboard.employees.account')
                        ->with(array('site'=> 'hris', 'page'=>'employees'))
                        ->with('employee', $employee)
                        ->with('user',$user);
    }
    
    public function account_store(Request $request)
    {
        //
        $field = [
            'username' => 'required|string|unique:users',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $user = new User();
            $user->emp_no = $request->input('emp_no');
            $user->username = $request->input('username');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));

            $user->is_admin = $request->input('is_admin') ? true : false;
            $user->is_hr = $request->input('is_hr') ? true : false;
            $user->is_nurse = $request->input('is_nurse') ? true : false;
            $user->api_token = Str::random(60);

            if($request->input('is_nurse')){
                DB::table('users')->update(array('is_nurse' => 0));
            }

            $user->is_lv_approver = $request->input('is_lv_approver') ? true : false;
            $user->is_ot_approver = $request->input('is_ot_approver') ? true : false;
            $user->is_cs_approver = $request->input('is_cs_approver') ? true : false;
            $user->is_active = 1;

            if($user->save()){
                    return redirect()->route('employees.index')->withSuccess('Account Information Successfully Created!');
            }
        }
    }
    
    public function account_update(Request $request)
    {
       $user = User::find($request->input('user_id'));
       if($request->input('password')){
            $user->password = bcrypt($request->input('password'));
       }

       $user->is_admin = $request->input('is_admin') ? true : false;
       $user->is_hr = $request->input('is_hr') ? true : false;
       $user->is_nurse = $request->input('is_nurse') ? true : false;

       if($request->input('is_nurse')){
            DB::table('users')->update(array('is_nurse' => 0));
        }

       $user->is_lv_approver = $request->input('is_lv_approver') ? true : false;
       $user->is_ot_approver = $request->input('is_ot_approver') ? true : false;
       $user->is_cs_approver = $request->input('is_cs_approver') ? true : false;

       if($user->save()){
            return redirect()->route('employees.index')->withSuccess('Account Information Successfully Updated!');
       }

    }

    public function change_password(Request $request){
        $user = User::find($request->input('user_id'));
        if(password_verify($request->input('current_password'), $user->password)){
            $user->password = bcrypt($request->input('new_password'));
            
            if($user->save()){
                return redirect()->route('hris.home')->withSuccess('Password successfully changed!');
            }
        }else{
            return redirect()->route('hris.home')->withErrors(['Current password is incorrect!']);
        }
    }
}
