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
                "data" => Leave::where('status', '=', 'Approved')
                            ->with('filer_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->orderBy('id','DESC')
                            ->get()
        ]);
    }

    public function all_posted()
    {
        return response()
            ->json([
                "data" => Leave::where('status', '=', 'Posted')
                            ->with('filer_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->orderBy('id','DESC')
                            ->get()
        ]);
    }

    public function my()
    {
        return response()
            ->json([
                "data" => Leave::where('filer', '=', Auth::user()->emp_no)
                            ->where('status', '<>', 'Posted')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->orderBy('id','DESC')
                            ->get()
        ]);
    }

    public function my_posted()
    {
        return response()
            ->json([
                "data" => Leave::where('filer', '=', Auth::user()->emp_no)
                            ->where('status', '=', 'Posted')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->orderBy('id','DESC')
                            ->get()
        ]);
    }

    public function approval()
    {
        return response()
            ->json([
                "data" => Leave::where('next_approver', '=', Auth::user()->emp_no)
                            ->with('filer_employee:emp_no,emp_photo,emp_fname,emp_lname')
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
        if(!$leave_credits = json_decode(Auth::user()->employee->leave_credits)){
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
        $reports_to = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

        return view('pages.hris.dashboard.leaves.create')
                ->with(array('site'=> 'hris', 'page'=>'leave'))
                ->with('reports_to',$reports_to)
                ->with('leave_credits',$leave_credits);
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

            if($request->input('type') != "Unpaid Leave")
            {
                $start = strtotime($request->input('leave_from'));
                $end = strtotime($request->input('is_one_day') ? $request->input('leave_from') : $request->input('leave_to'));
                $days = 0;
                while ($start <= $end) {
                    if (date('N', $start) <= 6)
                        $days++;  
                    
                    $start += 86400;
                }

                $leave_credits = json_decode(Auth::user()->employee->leave_credits);

                if( ($request->input('type') == "Sick Leave" && $days > $leave_credits->sick_leave) ||
                ($request->input('type') == "Vacation Leave" && $days > $leave_credits->vacation_leave) ||
                ($request->input('type') == "Admin Leave" && $days > $leave_credits->admin_leave) ||
                ($request->input('type') == "Solo Parent Leave" && $days > $leave_credits->solo_parent_leave) ||
                ($request->input('type') == "Bereavement Leave" && $days > $leave_credits->bereavement_leave) ||
                ($request->input('type') == "Birthday Leave" && $days > $leave_credits->bday_leave) ||
                ($request->input('type') == "Paternity Leave" && $days > $leave_credits->paternity_leave) ||
                ($request->input('type') == "Maternity Leave" && $days > $leave_credits->maternity_leave) ||
                ($request->input('type') == "Special Leave for Women" && $days > $leave_credits->special_leave) )
                { return back()->withInput()
                    ->withErrors(['leave_to' => ['Leave credit is insufficient with the leave date range!']]); }   
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

            if($request->input('type') == "Sick Leave" && !$request->input('is_one_day')){
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

    public function show_posted($ref_no)
    {
        //
        $leave = Leave::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($leave->logs);
        krsort($history);
        if($leave){
            if(Auth::user()->is_hr || Auth::user()->is_admin){
                return view('pages.hris.dashboard.leaves.posted')
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

    public function for_posting($ref_no)
    {
        //
        $leave = Leave::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($leave->logs);
        krsort($history);
        if($leave){
            if(Auth::user()->is_hr || Auth::user()->is_admin){
                return view('pages.hris.dashboard.leaves.posting')
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
                                        Auth::user()->employee->full_name,
                                        $leave->ref_no,
                                        $request->input('type'),
                                        $filer->emp_fname,
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
                                                    Auth::user()->employee->full_name,
                                                    $leave->ref_no,
                                                    $request->input('type'),
                                                    $filer->emp_fname,
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
                                            Auth::user()->employee->full_name,
                                            $leave->ref_no,
                                            $request->input('type'),
                                            $filer->emp_fname,
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
                return redirect()->route('mytimekeeping',['#leaveapproval'])->withSuccess('Leave Successfully Updated!');
            }

        }
    }

    public function post(Request $request, $id)
    {
       
        $leave = Leave::find($id);
        $logs = json_decode($leave->logs);
        $filer = Employee::where('emp_no','=',$leave->filer)->first();
        $mailable = new LeaveMailable('HRIS - Leave Request Posted',
                                    'leave',
                                    'fit',
                                    'filer',
                                    Auth::user()->employee->full_name,
                                    $leave->ref_no,
                                    $request->input('type'),
                                    $filer->emp_fname,
                                    'Posted');
        
        $status = 'Posted';
        $leave->next_approver = 'N/A';
        $days = 0;

        if($leave->type <> "Unpaid Leave"){

            if($leave->leave_from == $leave->leave_to)
                $days = 1;
            else
            {
                $start = strtotime($leave->leave_from);
                $end = strtotime($leave->leave_to);

                while ($start <= $end) {
                    if (date('N', $start) <= 6)
                        $days++;  
                    
                    $start += 86400;
                }
            }

            $leave_credits = json_decode($filer->leave_credits);

            if($leave->type == "Sick Leave")
            {
                $leave_credits->sick_leave -= $days;
            }
            else if($leave->type == "Vacation Leave")
            {
                $leave_credits->vacation_leave -= $days;
            }
            else if($leave->type == "Admin Leave")
            {
                $leave_credits->admin_leave -= $days;
            }
            else if($leave->type == "Solo Parent Leave")
            {
                $leave_credits->solo_parent_leave -= $days;
            }
            else if($leave->type == "Bereavement Leave")
            {
                $leave_credits->bereavement_leave -= $days;
            }
            else if($leave->type == "Birthday Leave")
            {
                $leave_credits->bday_leave -= $days;
            }
            else if($leave->type == "Paternity Leave")
            {
                $leave_credits->paternity_leave -= $days;
            }
            else if($leave->type == "Maternity Leave")
            {
                $leave_credits->maternity_leave -= $days;
            }
            else if($leave->type == "Special Leave for Women")
            {
                $leave_credits->special_leave -= $days;
            }
            else if($leave->type == "Leave for Abused Women")
            {
                $leave_credits->abused_leave -= $days;
            }
            else if($leave->type == "Expanded Maternity Leave")
            {
                $leave_credits->expanded_leave -= $days;
            }

            $filer->leave_credits = json_encode($leave_credits);
            $filer->save();

        }
            

        $log_entry = array('status' => $status,
                            'transaction_date' => date('Y-m-d'),
                            'approved_by' => Auth::user()->emp_no,
                            'remarks' => 'Posted'
                        );

        array_push($logs,$log_entry);

        $leave->logs = json_encode($logs);
        $leave->status = $status;
        $leave->last_approved_by = Auth::user()->emp_no;
        $leave->last_approved = date('Y-m-d');

        if($leave->save()){
            Mail::to($filer->work_email, $filer->full_name)->send($mailable);
            return redirect()->route('timekeeping',['#leaveposted'])->withSuccess('Leave Successfully Posted!');
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
