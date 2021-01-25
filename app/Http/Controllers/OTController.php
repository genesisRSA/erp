<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use App\OT;
use App\OTDetails;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailable;

class OTController extends Controller
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
                "data" => OT::orderBy('date_filed','asc')
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
                "data" => OT::orderBy('date_filed','asc')
                            ->where('status', '=', 'Posted')
                            ->orWhere('status', '=', 'Voided')
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
                "data" => OT::where('filer', '=', Auth::user()->emp_no)
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
                "data" => OT::where('next_approver', '=', Auth::user()->emp_no)
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
        if(strtotime(date('H:i:s')) <= strtotime('15:00:00')){
            $team = Employee::where('reports_to','=',Auth::user()->employee->emp_no)->get();
            $reports_to = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

            return view('pages.hris.dashboard.ot.create')
                    ->with(array('site'=> 'hris', 'page'=>'overtime'))
                    ->with('reports_to',$reports_to)
                    ->with('team',$team);
        }else{
            return back();
        }
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
            'ot_date' => 'required',
            'ot_from' => 'required',
            'ot_to' => 'required',
            'reason' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{

            $lastid = DB::table('o_t_s')->latest('id')->first();

            if($lastid){
                $lastid = $lastid->id;
            }else{
                $lastid = 0;
            }
            
            $lastid = "RGCOT".date('Y').'-'.str_pad(($lastid+1), 5, '0', STR_PAD_LEFT);

            $ot = new OT();
            $ot->ref_no = $lastid;
            $ot->filer = Auth::user()->emp_no;
            $ot->date_filed = date('Y-m-d');

            if($request->input('ot_date')){
                $ot_details = array();

                for( $i = 0 ; $i < count($request->input('ot_date')) ; $i++ ){
                    array_push($ot_details, [  'ref_no' => $lastid,
                                                'emp_no' => $request->input('emp_no.'.$i),
                                                'ot_date' => $request->input('ot_date.'.$i),
                                                'ot_start' => $request->input('ot_from.'.$i),
                                                'ot_end' => $request->input('ot_to.'.$i),
                                                'reason' => $request->input('reason.'.$i)
                                              ]);
                }
                OTDetails::insert($ot_details);
                $ot_details = json_encode($ot_details);
                $ot->ot_details = $ot_details;
            }

            $ot->last_approved_by = "N/A";
            $ot->last_approved = "1990-01-01";

            $ot->next_approver = Auth::user()->employee->reports_to;
            $ot->status = "For Pre-Approval";

            $logs = array(array('status' => 'For Pre-Approval',
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => 'Filed'));

            $ot->logs = json_encode($logs);

            if($ot->save()){
                $approver = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

                Mail::to($approver->work_email, $approver->full_name)
                    ->send(new LeaveMailable('ERIS - Overtime Request Approval',
                                            'ot',
                                            'filed',
                                            'approver',
                                            $approver->emp_fname,
                                            $lastid,
                                            '',
                                            Auth::user()->employee->full_name,''));

                return redirect()->route('mytimekeeping',['#ot'])->withSuccess('Overtime Successfully Filed!');
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
        $ot = OT::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($ot->logs);
        krsort($history);
        if($ot){
            if(($ot->filer == Auth::user()->emp_no)||Auth::user()->is_admin||Auth::user()->is_hr){
                return view('pages.hris.dashboard.ot.show')
                        ->with(array('site'=> 'hris', 'page'=>'overtime'))
                        ->with('history',$history)
                        ->with('ot_details',json_decode($ot->ot_details))
                        ->with('ot',$ot);
            }else{
                return back()->withErrors(['ot' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['ot' => ['Overtime document not found!']]);
        }
    }

    public function posting($ref_no)
    {
        //
        $ot = OT::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($ot->logs);
        krsort($history);
        if($ot){
            if(Auth::user()->is_admin||Auth::user()->is_hr){
                $filer = Employee::where('emp_no','=',$ot->filer)->first();

                return view('pages.hris.dashboard.ot.posting')
                        ->with(array('site'=> 'hris', 'page'=>'overtime'))
                        ->with('history',$history)
                        ->with('ot_details',json_decode($ot->ot_details))
                        ->with('ot',$ot);
            }else{
                return back()->withErrors(['ot' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['ot' => ['Overtime document not found!']]);
        }
    }

    public function for_approval($ref_no)
    {
        //
        $ot = OT::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($ot->logs);
        krsort($history);
        if($ot){
            if($ot->next_approver == Auth::user()->emp_no){

                return view('pages.hris.dashboard.ot.approval')
                        ->with(array('site'=> 'hris', 'page'=>'overtime'))
                        ->with('history',$history)
                        ->with('ot_details',json_decode($ot->ot_details))
                        ->with('ot',$ot);
            }else{
                return back()->withErrors(['ot' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['ot' => ['Overtime document not found!']]);
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
        $ot = OT::find($id);
        $logs = json_decode($ot->logs);
        
        $filer = Employee::where('emp_no','=',$ot->filer)->first();

        if($request->input('void')){

            $status = 'Voided';
            $ot->next_approver = 'N/A';
            $mailable = new LeaveMailable('ERIS - Overtime Request Voided',
                                        'ot',
                                        'void',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $ot->ref_no,
                                        '',
                                        $filer->full_name,
                                        'Voided');
    
            $log_entry = array('status' => $status,
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => 'Void'
                            );

        }else{

            $status = 'Posted';
            $ot->next_approver = 'N/A';
            $mailable = new LeaveMailable('ERIS - Overtime Request Posted',
                                        'ot',
                                        'posted',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $ot->ref_no,
                                        '',
                                        $filer->full_name,
                                        'Posted');
            
    
            $log_entry = array('status' => $status,
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => 'Posted'
                            );

        }

        array_push($logs,$log_entry);

        $ot->logs = json_encode($logs);
        $ot->status = $status;
        $ot->last_approved_by = Auth::user()->emp_no;
        $ot->last_approved = date('Y-m-d');

        if($ot->save()){
            Mail::to($filer->work_email, $filer->full_name)->send($mailable);
            return redirect()->route('timekeeping',['#otposted'])->withSuccess('Change Shift Successfully '.$status.'!');
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
            $ot = OT::find($id);
            $logs = json_decode($ot->logs);
            
            $filer = Employee::where('emp_no','=',$ot->filer)->first();
            $mailable = new LeaveMailable('ERIS - Overtime Request Approved',
                                        'ot',
                                        'approved',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $ot->ref_no,
                                        '',
                                        $filer->full_name,
                                        $request->input('remarks'));

            if($request->submit == 'approve'){
                if($ot->status == "For Pre-Approval"){
                        $status = 'For Approval';
                        $filer = Employee::where('emp_no','=',$ot->filer)->first();
                        $mailable = new LeaveMailable('ERIS - Overtime Request Pre-approved',
                                        'ot',
                                        'pre-approved',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $ot->ref_no,
                                        '',
                                        $filer->full_name,
                                        $request->input('remarks'));
                    
                 
                }else if($ot->status == "For Approval"){
                    if(Employee::where('emp_no','=', Auth::user()->emp_no)->first()->reports_to){
                        $status = 'For Manager Approval';
                        $ot->next_approver = Employee::where('emp_no','=',Auth::user()->emp_no)->first()->reports_to;
                        $mailable = new LeaveMailable('ERIS - Overtime For Manager Approval',
                                                    'ot',
                                                    'manager',
                                                    'approver',
                                                    Employee::where('emp_no','=',$ot->next_approver)->first()->emp_fname,
                                                    $ot->ref_no,
                                                    '',
                                                    $filer->full_name,
                                                    '');
                        $filer = Employee::where('emp_no','=',$ot->next_approver)->first();
                    
                    }else{
                        $status = 'Approved';
                        $ot->next_approver = 'N/A';
                    }
                }else{
                    $status = 'Approved';
                    $ot->next_approver = 'N/A';
                }
            }else{
                $status = 'Declined';
                $ot->next_approver = 'N/A';
                $mailable = new LeaveMailable('ERIS - Overtime Request Declined',
                                            'ot',
                                            'declined',
                                            'filer',
                                            Auth::user()->employee->emp_fname,
                                            $ot->ref_no,
                                            '',
                                            $filer->full_name,
                                            $request->input('remarks'));
            }

            $log_entry = array('status' => $status,
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => $request->input('remarks')
                            );
            array_push($logs,$log_entry);

            $ot->logs = json_encode($logs);
            $ot->status = $status;
            $ot->last_approved_by = Auth::user()->emp_no;
            $ot->last_approved = date('Y-m-d');

            if($ot->save()){
                Mail::to($filer->work_email, $filer->full_name)->send($mailable);
                return redirect()->route('mytimekeeping',['#otapproval'])->withSuccess('Overtime Successfully Updated!');
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
