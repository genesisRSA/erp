<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Shift;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use App\EmployeeShift;
use App\Shifts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use App\User;

class EmployeeShiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function all()
    {
        return response()
            ->json([
                "data" => EmployeeShift::where('emp_no','<>','ADMIN')
                            ->with('employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('shift:shift_code,shift_desc')
                            ->orderBy('id','DESC')
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
        $employees = Employee::where('emp_no', '<>', 'admin')
                        ->where('emp_cat', '<>', 'Resigned')
                        ->with('site:site_code,site_desc')
                        ->with('department:dept_code,dept_desc')
                        ->with('section:sect_code,sect_desc')
                        ->orderBy('emp_lname','ASC')
                        ->get()
                        ->each
                        ->append(['full_name','id_no']);
        $shifts = DB::select('SELECT DISTINCT shift_code,shift_desc from shifts ORDER BY shift_code');
        return view('pages.hris.dashboard.shifts.create')
                ->with(array('site'=> 'hris', 'page'=>'shift'))
                ->with('employees',$employees)
                ->with('shifts',$shifts);
    }

    public function import()
    {
        //
        return view('pages.hris.dashboard.shifts.import')
                ->with(array('site'=> 'hris', 'page'=>'shift', 'shift_table' => '' , 'error_count' => 0, 'file_path' => ''));
    }
    
    function generate_shift_table($data){
        $table = array();
        $error_count = 0;
        $row_no = 0;
        foreach($data as $row){
            $row_no++;
            $has_error = false;
            $remarks = null;
            //check employee
            $employee = Employee::where('emp_no',$row[0])->first();
            $emp_no = $employee ? $employee->emp_no : $row[0];
            $emp_name = $employee ? $employee->full_name : "N/A";
            $emp_photo = $employee ? $employee->emp_photo : "N/A";
            //check shift
            $shift = Shift::where('shift_code',$row[2])
                            ->where('shift_day',date('l',strtotime($row[1])))
                            ->first();
            $shift_desc = $shift ? $shift->shift_desc : $row[2];
            $shift_date = $row[1];
            $time_in = $shift ? $shift->shift_start : "N/A";
            $time_out = $shift ? $shift->shift_end : "N/A";
            
            //generate error (if any)
            if($emp_name == "N/A"){ $remarks .= "| Employee not exist. | "; $has_error = true;}
            if($time_in == "N/A"){ $remarks .= "Shift not exist. | "; $has_error = true;}
            $error_count = $has_error ? $error_count + 1 : $error_count + 0;
            array_push($table,array(
                "row_no" => $row_no,
                "emp_no" => $emp_no,
                "emp_name" => $emp_name,
                "emp_photo" => $emp_photo,
                "shift_desc" => $shift_desc,
                "shift_day" => date('l',strtotime($row[1])),
                "shift_date" => $shift_date,
                "time_in" => date('h:i A',strtotime($time_in)),
                "time_out" => date('h:i A',strtotime($time_out)),
                "remarks" => $remarks,
                "has_error" => $has_error
            ));
        }

        return array('table' => $table, 'error_count' => $error_count);
    }

    public function upload(Request $request)
    {
        //
        $field = [
            'shift_file' => 'required|file',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $file = $request->file('shift_file');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $file->move(public_path(),$file->getClientOriginalName());
            $data = array_splice($data,1,count($data));
            $data = self::generate_shift_table($data);
            $table = $data["table"];
            $error_count = $data["error_count"];
            return view('pages.hris.dashboard.shifts.import')
                    ->with(array('site'=> 'hris', 'page'=>'shift', 'shift_table' => $table, 'error_count' => $error_count, 'file_path' => public_path()."\\".$file->getClientOriginalName()));
        }
    }

    
    public function import_submit(Request $request){
        $path = $request->input('file_path');
        $data = array_map('str_getcsv', file($path));
        $data = array_splice($data,1,count($data));
        $data = self::generate_shift_table($data);
        $table = $data["table"];
        $error_count = $data["error_count"];
        File::delete($path);
        
        return view('pages.hris.dashboard.shifts.import')
                ->with(array('site'=> 'hris', 'page'=>'shift', 'shift_table' => $table, 'error_count' => $error_count, 'file_path' => $path));
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
            'employee' => 'required',
            'shift' => 'required',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $emp_shift = new EmployeeShift();
            $emp_shift->emp_no = $request->input('employee','');
            $emp_shift->shift_code = $request->input('shift','');
            $emp_shift->date_from = $request->input('date_from','');
            $emp_shift->date_to = $request->input('date_to','');
            $emp_shift->remarks = $request->input('remarks','');

            if($emp_shift->save()){
                return redirect()->route('timekeeping',['#shift'])->withSuccess('Shift Successfully Added!');
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
        //
        $emp_shift = EmployeeShift::find($id)
                    ->with('employee:emp_no,emp_photo,emp_fname,emp_lname')
                    ->whereHas('shifts', function ($query) {
                        $query->where('shift_day', '<>', 'Sunday');
                    })->first();

        $shifts = array('Sunday' => 'Rest Day');

        foreach($emp_shift->shifts as $shift){
            if($shift->shift_start=="00:00:00")
            {
                $shifts[$shift->shift_day] = "Rest Day";
            }else
            $shifts[$shift->shift_day] =  date("h:iA",strtotime($shift->shift_start)).' - '.date("h:iA",strtotime($shift->shift_end));
        }
        $shifts = json_decode(json_encode($shifts));
        
        return view('pages.hris.dashboard.shifts.show')
                ->with(array('site'=> 'hris', 'page'=>'shift'))
                ->with('emp_shift',$emp_shift)
                ->with('shifts',$shifts);
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
