<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use App\Leave;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailable;

class LeavesController extends Controller
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
                "data" => Leave::orderBy('date_filed','asc')
                            ->with('filer_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->get()
        ]);
    }

    public function my()
    {
        return response()
            ->json([
                "data" => Leave::where('filer', '=', Auth::user()->emp_no)
                            ->orderBy('date_filed','asc')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->get()
        ]);
    }

    public function approval()
    {
        return response()
            ->json([
                "data" => Leave::where('next_approver', '=', Auth::user()->emp_no)
                            ->orderBy('date_filed','asc')
                            ->with('filer_employee:emp_no,emp_photo,emp_fname,emp_lname')
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
        $reports_to = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

        return view('pages.hris.dashboard.leaves.create')
                ->with(array('site'=> 'hris', 'page'=>'leave'))
                ->with('reports_to',$reports_to);
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
            'leave_from' => 'required',
            'details' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            

            if(!$request->input('is_one_day'))
            {
                $from = new Carbon($request->input('leave_from'));
                $to = new Carbon($request->input('leave_to'));
                $datediff = $to->diffInDays($from);

                if($datediff < 1)
                return back()->withInput()
                            ->withErrors(['leave_to' => ['Leave date range is incorrect!']]);
            }

            $lastid = DB::table('leaves')->latest('id')->first();

            if($lastid){
                $lastid = $lastid->id;
            }else{
                $lastid = 0;
            }

            $lastid = "RSALV".date('Y').'-'.str_pad(($lastid+1), 5, '0', STR_PAD_LEFT);

            $leave = new Leave();
            $leave->ref_no = $lastid;
            $leave->type = $request->input('type');
            $leave->filer = Auth::user()->emp_no;
            $leave->leave_from = $request->input('leave_from');
            $leave->leave_to = $request->input('is_one_day') ? $request->input('leave_from') : $request->input('leave_to');
            $leave->details = $request->input('details');
            $leave->date_filed = date('Y-m-d');

            $leave->last_approved_by = "N/A";
            $leave->last_approved = "1990-01-01";

            if($request->input('type') == "Sick Leave"){
                $leave->next_approver = User::where('is_nurse','=','1')->first()->emp_no;
                $leave->status = "For Fit to Work Verification";

                $logs = array(array('status' => 'For Fit to Work Verification',
                                    'transaction_date' => date('Y-m-d'),
                                    'approved_by' => Auth::user()->emp_no,
                                    'remarks' => 'Filed'));
            }else{
                $leave->next_approver = Auth::user()->employee->reports_to;
                $leave->status = "For Approval";

                $logs = array(array('status' => 'For Approval',
                                    'transaction_date' => date('Y-m-d'),
                                    'approved_by' => Auth::user()->emp_no,
                                    'remarks' => 'Filed'));
            }

            $leave->logs = json_encode($logs);

            if($leave->save()){
                if($request->input('type') == "Sick Leave"){
                    $approver = Employee::where('emp_no','=',User::where('is_nurse','=','1')->first()->emp_no)->first();
                }else{
                    $approver = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();
                }
                Mail::to($approver->work_email, $approver->full_name)
                    ->send(new LeaveMailable('HRIS - Leave Request Approval',
                                            'leave',
                                            'filed',
                                            'approver',
                                            $approver->emp_fname,
                                            $lastid,
                                            $request->input('type'),
                                            Auth::user()->employee->full_name,''));
                return redirect()->route('mytimekeeping')->withSuccess('Leave Successfully Filed!');
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($ref_no)
    {
        //
        $leave = Leave::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($leave->logs);
        krsort($history);
        if($leave){
            if($leave->filer == Auth::user()->emp_no){
                return view('pages.hris.dashboard.leaves.show')
                        ->with(array('site'=> 'hris', 'page'=>'leave'))
                        ->with('history',$history)
                        ->with('leave',$leave);
            }else{
                return back()->withErrors(['leave' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['leave' => ['Leave document not found!']]);
        }
    }

    
    public function for_approval($ref_no)
    {
        //
        $leave = Leave::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($leave->logs);
        krsort($history);
        if($leave){
            if($leave->next_approver == Auth::user()->emp_no){
                return view('pages.hris.dashboard.leaves.approval')
                        ->with(array('site'=> 'hris', 'page'=>'leave'))
                        ->with('history',$history)
                        ->with('leave',$leave);
            }else{
                return back()->withErrors(['leave' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['leave' => ['Leave document not found!']]);
        }
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
        $field = [
            'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $leave = Leave::find($id);
            $logs = json_decode($leave->logs);
            $filer = Employee::where('emp_no','=',$leave->filer)->first();
            $mailable = new LeaveMailable('HRIS - Leave Request Approved',
                                        'leave',
                                        'fit',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $leave->ref_no,
                                        $request->input('type'),
                                        $filer->full_name,
                                        $request->input('remarks'));
            if($request->submit == 'approve'){
                if($leave->status == "For Fit to Work Verification"){
                    if(Employee::where('emp_no','=',$leave->filer)->first()->reports_to){
                        $status = 'For Approval';
                        $leave->next_approver = Employee::where('emp_no','=',$leave->filer)->first()->reports_to;
                        $mailable = new LeaveMailable('HRIS - Leave Request Fit to Work',
                                                    'leave',
                                                    'fit',
                                                    'filer',
                                                    Auth::user()->employee->emp_fname,
                                                    $leave->ref_no,
                                                    $request->input('type'),
                                                    $filer->full_name,
                                                    $request->input('remarks'));
                    }else{
                        $status = 'Approved';
                        $leave->next_approver = 'N/A';
                    }
                }else{
                    $status = 'Approved';
                    $leave->next_approver = 'N/A';
                }
            }else{
                $status = 'Declined';
                $leave->next_approver = 'N/A';
                $mailable = new LeaveMailable('HRIS - Leave Request Declined',
                                            'leave',
                                            'declined',
                                            'filer',
                                            Auth::user()->employee->emp_fname,
                                            $leave->ref_no,
                                            $request->input('type'),
                                            $filer->full_name,
                                            $request->input('remarks'));
            }

            $log_entry = array('status' => $status,
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => $request->input('remarks')
                            );
            array_push($logs,$log_entry);

            $leave->logs = json_encode($logs);
            $leave->status = $status;
            $leave->last_approved_by = Auth::user()->emp_no;
            $leave->last_approved = date('Y-m-d');

            if($leave->save()){
                Mail::to($filer->work_email, $filer->full_name)->send($mailable);
                return redirect()->route('mytimekeeping')->withSuccess('Leave Successfully Updated!');
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
}
