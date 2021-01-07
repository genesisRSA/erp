<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Signages;
use App\Employee;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailable;

class SignagesController extends Controller
{
    //
    public function store(Request $request)
    {
        if($request->hasfile('source_url')) 
        { 
            $file = $request->file('source_url');
            $filename = date("Ymdhisa").$file->getClientOriginalName();
            $file->storeAs(
                "public/videos", $filename
            );
        }

        if($request->hasfile('source_url_vertical')) 
        { 
            $file_vertical = $request->file('source_url_vertical');
            $filename_vertical = date("Ymdhisa").'vertical_'.$file_vertical->getClientOriginalName();
            $file_vertical->storeAs(
                "public/videos", $filename_vertical
            );
        }

        $signages = new Signages();
        $signages->status = $request->input('status','');
        $signages->created_by = Auth::user()->emp_no;
        $signages->source_url = 'storage/videos/'.$filename;
        $signages->source_url_vertical = 'storage/videos/'.$filename_vertical;
        $signages->is_enabled = 0;
        $signages->expiration_date = $request->input('expiration_date','');;
        $signages->is_video = $request->input('is_video','');
        $signages->last_approved_by = '0722-2019';
        $approver = Employee::where('emp_no','=',$signages->last_approved_by)->first();

        if($signages->save()){

            Mail::to($approver->work_email, $approver->full_name)
                ->send(new LeaveMailable('RGC Digital Signage - Signage Request Approval',
                                        'digital signage',
                                        0,
                                        'approver',
                                        $approver->emp_fname,
                                        '',
                                        '',
                                        Auth::user()->employee->full_name,''));

            return redirect()->route('signages.index')->withSuccess('Signage Successfully Added!');
        }
    }

    public function all($emp_no)
    {
        $data = Signages::where('created_by','=',$emp_no)
                ->where('expiration_date','>=',date('Y-m-d'))
                ->get();
        
        return response()
            ->json([
                "data" => $data
        ]);
    }

    public function forapproval($emp_no)
    {
        $data = Signages::where('last_approved_by','=',$emp_no)
                ->where('expiration_date','>=',date('Y-m-d'))
                ->where('is_enabled','<>','1')
                ->where('is_enabled','<>','3')
                ->with('requestor:emp_no,emp_photo,emp_fname,emp_lname')
                ->get();
        
        return response()
            ->json([
                "data" => $data
        ]);
    }

    public function signage()
    {
        $signages = Signages::where('is_enabled','=',1)->where('expiration_date','>=',date('Y-m-d'))->get();
        
        return view('signage')
                ->with('signages',$signages);
    }

    public function signage_vertical()
    {
        $signages = Signages::where('is_enabled','=',1)->where('expiration_date','>=',date('Y-m-d'))->get();
        
        return view('signagev')
                ->with('signages',$signages);
    }

    public function signage_jolist()
    {
        $signages = Signages::where('is_enabled','=',1)->where('expiration_date','>=',date('Y-m-d'))->get();
        $jo_list = DB::connection('sqlsrv')->table("JOLIST.dbo.jolist")->get();

        return view('signagejo')
                ->with('signages',$signages)
                ->with('jolist',$jo_list);
    }

    public function signage_jolistv()
    {
        $signages = Signages::where('is_enabled','=',1)->where('expiration_date','>=',date('Y-m-d'))->get();
        $jo_list = DB::connection('sqlsrv')->table("JOLIST.dbo.jolist")->get();

        return view('signagejov')
                ->with('signages',$signages)
                ->with('jolist',$jo_list);
    }

    public function rejected($id){
        $sign = Signages::find($id);
        $sign->is_enabled = 3;
        if($sign->save()){
            return redirect()->route('signages.index')->withSuccess('Signage Successfully Rejected!');
        }
    }

    public function disable($id){
        $sign = Signages::find($id);
        $requestor = Employee::where('emp_no','=',$sign->created_by)->first();
        $sign->is_enabled = 0;
        Mail::to($requestor->work_email, $requestor->full_name)
            ->send(new LeaveMailable('RGC Digital Signage - Signage Request Rejected',
                                    'digital signage',
                                    $sign->is_enabled,
                                    'filer',
                                    $requestor->emp_fname,
                                    '',
                                    '',
                                    Auth::user()->employee->full_name,''));
        if($sign->save()){
            return redirect()->route('signages.index')->withSuccess('Signage Successfully Disabled!');
        }
    }

    public function enable($id){
        $sign = Signages::find($id);
        $requestor = Employee::where('emp_no','=',$sign->created_by)->first();

        if($sign->is_enabled == 0){
            $sign->is_enabled = 2;
            if($sign->status == "HR"){
                $sign->last_approved_by = "0311-2020";
            }else if($sign->status == "QC"){
                $sign->last_approved_by = "0219-2007A";
            }else{
                $sign->last_approved_by = "0219-2007B";
            }
                                        
            Mail::to($requestor->work_email, $requestor->full_name)
            ->send(new LeaveMailable('RGC Digital Signage - Signage Request HR Approved',
                                    'digital signage',
                                    $sign->is_enabled,
                                    'filer',
                                    $requestor->emp_fname,
                                    '',
                                    '',
                                    Auth::user()->employee->full_name,''));

                                    
            
            $approver = Employee::where('emp_no','=',$sign->last_approved_by)->first();

            Mail::to($approver->work_email, $approver->full_name)
                ->send(new LeaveMailable('RGC Digital Signage - Signage Request Approval',
                                        'digital signage',
                                        $sign->is_enabled,
                                        'approver',
                                        $approver->emp_fname,
                                        '',
                                        '',$requestor->full_name,''));
        }else{
            $sign->is_enabled = 1;
            $sign->last_approved_by = '';

            Mail::to($requestor->work_email, $requestor->full_name)
            ->send(new LeaveMailable('RGC Digital Signage - Signage Request Approved',
                                    'digital signage',
                                    1,
                                    'filer',
                                    $requestor->emp_fname,
                                    '',
                                    '',
                                    Auth::user()->employee->full_name,''));
        }

        if($sign->save()){
            return redirect()->route('signages.index')->withSuccess('Signage Successfully Enabled!');
        }
    }

    public function delete($id){
        $sign = Signages::find($id);
        if($sign->forceDelete()){
            return redirect()->route('signages.index')->withSuccess('Signage Successfully Deleted!');
        }
    }

    public function jolist(){
        $jo_list = DB::connection('sqlsrv')->RAW("SELECT JOLIST.dbo.jolist")->get();
        
        return response()
        ->json([
            "data" => $jo_list
        ]);
    }

    public function index(){
        return view("pages.ics.digital_signage.index")
                ->with('site','ics')
                ->with('page','digital signage');  
    }

    public function create(){

        return view("pages.ics.digital_signage.create")
                ->with('site','ics')
                ->with('page','digital signage');  
        
    }
}
