<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Validator;
use Session;
use Carbon\Carbon;
use App\OB;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailable;

class OBController extends Controller
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
                "data" => OB::orderBy('date_filed','asc')
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
                "data" => OB::orderBy('date_filed','asc')
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
                "data" => OB::where('filer', '=', Auth::user()->emp_no)
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
                "data" => OB::where('next_approver', '=', Auth::user()->emp_no)
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
            $reports_to = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

            return view('pages.hris.dashboard.ob.create')
                    ->with(array('site'=> 'hris', 'page'=>'official business'))
                    ->with('reports_to',$reports_to);
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
        if($request->input('purpose') == "Others"){
            $field = [
                'others' => 'required',
                'destination' => 'required',
                'ob_date' => 'required',
                'ob_from' => 'required',
                'ob_to' => 'required',
            ];
        }else{
            $field = [
                'destination' => 'required',
                'ob_date' => 'required',
                'ob_from' => 'required',
                'ob_to' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{

            $lastid = DB::table('o_b_s')->latest('id')->first();

            if($lastid){
                $lastid = $lastid->id;
            }else{
                $lastid = 0;
            }
            
            $lastid = "RGCOB".date('Y').'-'.str_pad(($lastid+1), 5, '0', STR_PAD_LEFT);

            $ob = new OB();
            $ob->ref_no = $lastid;
            $ob->filer = Auth::user()->emp_no;
            $ob->date_filed = date('Y-m-d');

            if($request->input('ob_date')){
                $ob_details = array();

                for( $i = 0 ; $i < count($request->input('ob_date')) ; $i++ ){
                    array_push($ob_details, [ 'ob_date' => $request->input('ob_date.'.$i),
                                                'ob_from' => $request->input('ob_from.'.$i),
                                                'ob_to' => $request->input('ob_to.'.$i),
                                                'destination' => $request->input('destination.'.$i),
                                                'purpose' => $request->input('purpose.'.$i)
                                              ]);
                }
                $ob_details = json_encode($ob_details);
                $ob->ob_details = $ob_details;
            }

            $ob->last_approved_by = "N/A";
            $ob->last_approved = "1990-01-01";

            $ob->next_approver = Auth::user()->employee->reports_to;
            $ob->status = "For Approval";

            $logs = array(array('status' => 'For Approval',
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => 'Filed'));

            $ob->logs = json_encode($logs);

            if($ob->save()){
                $approver = Employee::where('emp_no','=',Auth::user()->employee->reports_to)->first();

                Mail::to($approver->work_email, $approver->full_name)
                    ->send(new LeaveMailable('HRIS - Official Business Request Approval',
                                            'ob',
                                            'filed',
                                            'approver',
                                            $approver->emp_fname,
                                            $lastid,
                                            '',
                                            Auth::user()->employee->full_name,''));

                return redirect()->route('mytimekeeping',['#ob'])->withSuccess('OB Successfully Filed!');
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
        $ob = OB::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($ob->logs);
        krsort($history);
        if($ob){
            if(($ob->filer == Auth::user()->emp_no)||Auth::user()->is_admin||Auth::user()->is_hr){
                return view('pages.hris.dashboard.ob.show')
                        ->with(array('site'=> 'hris', 'page'=>'official business'))
                        ->with('history',$history)
                        ->with('ob_details',json_decode($ob->ob_details))
                        ->with('ob',$ob);
            }else{
                return back()->withErrors(['ob' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['ob' => ['OB document not found!']]);
        }
    }

    public function posting($ref_no)
    {
        //
        $ob = OB::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($ob->logs);
        krsort($history);
        if($ob){
            if(Auth::user()->is_admin||Auth::user()->is_hr){
                $filer = Employee::where('emp_no','=',$ob->filer)->first();

                return view('pages.hris.dashboard.ob.posting')
                        ->with(array('site'=> 'hris', 'page'=>'official business'))
                        ->with('ob_details',json_decode($ob->ob_details))
                        ->with('history',$history)
                        ->with('ob',$ob);
            }else{
                return back()->withErrors(['ob' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['ob' => ['Official Business document not found!']]);
        }
    }

    public function for_approval($ref_no)
    {
        //
        $ob = OB::where('ref_no', '=', $ref_no)->first();
        $history = json_decode($ob->logs);
        krsort($history);
        if($ob){
            if($ob->next_approver == Auth::user()->emp_no){

                return view('pages.hris.dashboard.ob.approval')
                        ->with(array('site'=> 'hris', 'page'=>'official business'))
                        ->with('ob_details',json_decode($ob->ob_details))
                        ->with('history',$history)
                        ->with('ob',$ob);
            }else{
                return back()->withErrors(['ob' => ['You have no permission to access the document!']]);
            }
        }else{
            return back()->withErrors(['ob' => ['Official Business document not found!']]);
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
        $ob = OB::find($id);
        $logs = json_decode($ob->logs);
        
        $filer = Employee::where('emp_no','=',$ob->filer)->first();
        $status = 'Posted';
        $ob->next_approver = 'N/A';
        $mailable = new LeaveMailable('HRIS - Official Business Request Posted',
                                    'ob',
                                    'posted',
                                    'filer',
                                    Auth::user()->employee->emp_fname,
                                    $ob->ref_no,
                                    $ob->purpose,
                                    $filer->full_name,
                                    'Posted');
        

        $log_entry = array('status' => $status,
                            'transaction_date' => date('Y-m-d'),
                            'approved_by' => Auth::user()->emp_no,
                            'remarks' => 'Posted'
                        );
        array_push($logs,$log_entry);

        $ob->logs = json_encode($logs);
        $ob->status = $status;
        $ob->last_approved_by = Auth::user()->emp_no;
        $ob->last_approved = date('Y-m-d');

        if($ob->save()){
            Mail::to($filer->work_email, $filer->full_name)->send($mailable);
            return redirect()->route('timekeeping',['#obposted'])->withSuccess('Official Business Successfully Posted!');
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
            $ob = OB::find($id);
            $logs = json_decode($ob->logs);
            
            $filer = Employee::where('emp_no','=',$ob->filer)->first();
            $mailable = new LeaveMailable('HRIS - Official Business Request Approved',
                                        'ob',
                                        'approved',
                                        'filer',
                                        Auth::user()->employee->emp_fname,
                                        $ob->ref_no,
                                        $ob->purpose,
                                        $filer->full_name,
                                        $request->input('remarks'));

            if($request->submit == 'approve'){
                if($ob->status == "For Approval"){
                    if(Employee::where('emp_no','=', Auth::user()->emp_no)->first()->reports_to){
                        $status = 'For Manager Approval';
                        $ob->next_approver = Employee::where('emp_no','=',Auth::user()->emp_no)->first()->reports_to;
                        $mailable = new LeaveMailable('HRIS - Official Business For Manager Approval',
                                                    'ob',
                                                    'manager',
                                                    'approver',
                                                    Employee::where('emp_no','=',$ob->next_approver)->first()->emp_fname,
                                                    $ob->ref_no,
                                                    $ob->purpose,
                                                    $filer->full_name,
                                                    '');
                        $filer = Employee::where('emp_no','=',$ob->next_approver)->first();
                    }else{
                        $status = 'Approved';
                        $ob->next_approver = 'N/A';
                    }
                }else{
                    $status = 'Approved';
                    $ob->next_approver = 'N/A';
                }
            }else{
                $status = 'Declined';
                $ob->next_approver = 'N/A';
                $mailable = new LeaveMailable('HRIS - Official Business Request Declined',
                                            'ob',
                                            'declined',
                                            'filer',
                                            Auth::user()->employee->emp_fname,
                                            $ob->ref_no,
                                            $ob->purpose,
                                            $filer->full_name,
                                            $request->input('remarks'));
            }

            $log_entry = array('status' => $status,
                                'transaction_date' => date('Y-m-d'),
                                'approved_by' => Auth::user()->emp_no,
                                'remarks' => $request->input('remarks')
                            );
            array_push($logs,$log_entry);

            $ob->logs = json_encode($logs);
            $ob->status = $status;
            $ob->last_approved_by = Auth::user()->emp_no;
            $ob->last_approved = date('Y-m-d');

            if($ob->save()){
                Mail::to($filer->work_email, $filer->full_name)->send($mailable);
                return redirect()->route('mytimekeeping',['#obapproval'])->withSuccess('Official Business Successfully Updated!');
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
