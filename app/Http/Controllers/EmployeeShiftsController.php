<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use App\EmployeeShift;
use App\Shifts;
use Illuminate\Support\Facades\DB;
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
