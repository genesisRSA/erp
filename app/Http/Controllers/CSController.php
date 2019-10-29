<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use App\CS;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailable;

class CSController extends Controller
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
                "data" => CS::orderBy('date_filed','asc')
                            ->where('status', '<>', 'Posted')
                            ->with('filer_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approved_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->with('approver_employee:emp_no,emp_photo,emp_fname,emp_lname')
                            ->get()
        ]);
    }

    public function all_posted()
    {
        return response()
            ->json([
                "data" => CS::orderBy('date_filed','asc')
                            ->where('status', '=', 'Posted')
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
                "data" => CS::where('filer', '=', Auth::user()->emp_no)
                            ->where('status', '<>', 'Posted')
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
                "data" => CS::where('next_approver', '=', Auth::user()->emp_no)
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

        return view('pages.hris.dashboard.cs.create')
                ->with(array('site'=> 'hris', 'page'=>'change shift'))
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
        if($request->input('type') == "Change of Shift"){
            $field = [
                'reason' => 'required',
                'orig_sched' => 'required',
                'new_sched' => 'required',
            ];
        }else if($request->input('type') == "Change of Date"){
            $field = [
                'reason' => 'required',
                'orig_sched' => 'required',
                'date_to' => 'required',
            ];
        }else{
            $field = [
                'reason' => 'required',
                'orig_sched' => 'required',
                'new_sched' => 'required',
                'date_to' => 'required',
            ];

        }

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{

            $lastid = DB::table('c_s_s')->latest('id')->first();

            if($lastid){
                $lastid = $lastid->id;
            }else{
                $lastid = 0;
            }
            
            $lastid = "RSACS".date('Y').'-'.str_pad(($lastid+1), 5, '0', STR_PAD_LEFT);

            $cs = new CS();
            $cs->ref_no = $lastid;
            $cs->type = $request->input('type');
            $cs->reason = $request->input('reason');
            $cs->filer = Auth::user()->emp_no;
            $cs->date_from = $request->input('date_from');
            $cs->orig_sched = $request->input('orig_sched');
            $cs->date_to = $request->input('date_to');
            $cs->new_sched = $request->input('new_sched');
            $cs->date_filed = date('Y-m-d');

            $cs->last_approved_by = "N/A";
            $cs->last_approved = "1990-01-01";

            $cs->next_approver = Auth::user()->employee->reports_to;
            $cs->status = "For Approval";

            $logs = array(array('status' => 'For Approval',
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => 'Filed'));

            $cs->logs = json_encode($logs);

            if($cs->save()){
                $approver = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

                Mail::to($approver->work_email, $approver->full_name)
                    ->send(new LeaveMailable('HRIS - Change Shift Request Approval',
                                            'cs',
                                            'filed',
                                            'approver',
                                            $approver->emp_fname,
                                            $lastid,
                                            $request->input('type'),
                                            Auth::user()->employee->full_name,''));

                return redirect()->route('mytimekeeping',['#cs'])->withSuccess('Change Shift Successfully Filed!');
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
        $cs = CS::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($cs->logs);
        krsort($history);
        if($cs){
            if(($cs->filer == Auth::user()->emp_no)||Auth::user()->is_admin||Auth::user()->is_hr){
                return view('pages.hris.dashboard.cs.show')
                        ->with(array('site'=> 'hris', 'page'=>'change shift'))
                        ->with('history',$history)
                        ->with('cs',$cs);
            }else{
                return back()->withErrors(['cs' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['cs' => ['Change Shift document not found!']]);
        }
    }

    public function posting($ref_no)
    {
        //
        $cs = CS::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($cs->logs);
        krsort($history);
        if($cs){
            if(Auth::user()->is_admin||Auth::user()->is_hr){
                $filer = Employee::where('emp_no','=',$cs->filer)->first();

                return view('pages.hris.dashboard.cs.posting')
                        ->with(array('site'=> 'hris', 'page'=>'change shift'))
                        ->with('history',$history)
                        ->with('cs',$cs);
            }else{
                return back()->withErrors(['cs' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['cs' => ['Change Shift document not found!']]);
        }
    }

    public function for_approval($ref_no)
    {
        //
        $cs = CS::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($cs->logs);
        krsort($history);
        if($cs){
            if($cs->next_approver == Auth::user()->emp_no){

                return view('pages.hris.dashboard.cs.approval')
                        ->with(array('site'=> 'hris', 'page'=>'change shift'))
                        ->with('history',$history)
                        ->with('cs',$cs);
            }else{
                return back()->withErrors(['cs' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['cs' => ['Change Shift document not found!']]);
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
    
    public function posted(Request $request, $id)
    {
        $cs = CS::find($id);
        $logs = json_decode($cs->logs);
        
        $filer = Employee::where('emp_no','=',$cs->filer)->first();
        $status = 'Posted';
        $cs->next_approver = 'N/A';
        $mailable = new LeaveMailable('HRIS - Change Shift Request Posted',
                                    'cs',
                                    'posted',
                                    'filer',
                                    Auth::user()->employee->emp_fname,
                                    $cs->ref_no,
                                    $cs->type,
                                    $filer->full_name,
                                    'Posted');
        

        $log_entry = array('status' => $status,
                            'transaction_date' => date('Y-m-d'),
                            'approved_by' => Auth::user()->emp_no,
                            'remarks' => 'Posted'
                        );
        array_push($logs,$log_entry);

        $cs->logs = json_encode($logs);
        $cs->status = $status;
        $cs->last_approved_by = Auth::user()->emp_no;
        $cs->last_approved = date('Y-m-d');

        if($cs->save()){
            Mail::to($filer->work_email, $filer->full_name)->send($mailable);
            return redirect()->route('timekeeping',['#csposted'])->withSuccess('Change Shift Successfully Posted!');
        }
    }


    public function update(Request $request, $id)
    {
        $field = [
            'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $cs = CS::find($id);
            $logs = json_decode($cs->logs);
            
            $filer = Employee::where('emp_no','=',$cs->filer)->first();
            $mailable = new LeaveMailable('HRIS - Change Shift Request Approved',
                                        'cs',
                                        'approved',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $cs->ref_no,
                                        $cs->type,
                                        $filer->full_name,
                                        $request->input('remarks'));

            if($request->submit == 'approve'){
                if($cs->status == "For Approval"){
                    if(Employee::where('emp_no','=', Auth::user()->emp_no)->first()->reports_to){
                        $status = 'For Manager Approval';
                        $cs->next_approver = Employee::where('emp_no','=',Auth::user()->emp_no)->first()->reports_to;
                        $mailable = new LeaveMailable('HRIS - Change Shift For Manager Approval',
                                                    'cs',
                                                    'manager',
                                                    'approver',
                                                    Employee::where('emp_no','=',$cs->next_approver)->first()->emp_fname,
                                                    $cs->ref_no,
                                                    $cs->type,
                                                    $filer->full_name,
                                                    '');
                        $filer = $cs->next_approver;
                    }else{
                        $status = 'Approved';
                        $cs->next_approver = 'N/A';
                    }
                }else{
                    $status = 'Approved';
                    $cs->next_approver = 'N/A';
                }
            }else{
                $status = 'Declined';
                $cs->next_approver = 'N/A';
                $mailable = new LeaveMailable('HRIS - Change Shift Request Declined',
                                            'cs',
                                            'declined',
                                            'filer',
                                            Auth::user()->employee->emp_fname,
                                            $cs->ref_no,
                                            $cs->type,
                                            $filer->full_name,
                                            $request->input('remarks'));
            }

            $log_entry = array('status' => $status,
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => $request->input('remarks')
                            );
            array_push($logs,$log_entry);

            $cs->logs = json_encode($logs);
            $cs->status = $status;
            $cs->last_approved_by = Auth::user()->emp_no;
            $cs->last_approved = date('Y-m-d');

            if($cs->save()){
                Mail::to($filer->work_email, $filer->full_name)->send($mailable);
                return redirect()->route('mytimekeeping',['#csapproval'])->withSuccess('Change Shift Successfully Updated!');
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
