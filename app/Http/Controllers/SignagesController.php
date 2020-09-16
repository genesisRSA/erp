<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Signages;

class SignagesController extends Controller
{
    //
    public function store(Request $request)
    {
        if($request->hasfile('source_url')) 
        { 
            $file = $request->file('source_url');
            $filename = $file->getClientOriginalName();
            $file->storeAs(
                "public/videos", $filename
            );
        }

        if($request->hasfile('source_url_vertical')) 
        { 
            $file_vertical = $request->file('source_url_vertical');
            $filename_vertical = 'vertical_'.$file_vertical->getClientOriginalName();
            $file_vertical->storeAs(
                "public/videos", $filename_vertical
            );
        }

        $signages = new Signages();
        $signages->source_url = 'storage/videos/'.$filename;
        $signages->source_url_vertical = 'storage/videos/'.$filename_vertical;
        $signages->is_enabled = $request->input('is_enabled','');
        $signages->is_video = $request->input('is_video','');

        if($signages->save()){
            return redirect()->route('digital.managesignage')->withSuccess('Signage Successfully Added!');
        }
    }

    public function all()
    {
        $data = Signages::all();
        
        return response()
            ->json([
                "data" => $data
        ]);
    }

    public function signage()
    {
        $signages = Signages::where('is_enabled','=',1)->get();
        
        return view('signage')
                ->with('signages',$signages);
    }

    public function signage_vertical()
    {
        $signages = Signages::where('is_enabled','=',1)->get();
        
        return view('signagev')
                ->with('signages',$signages);
    }

    public function signage_jolist()
    {
        $signages = Signages::where('is_enabled','=',1)->get();
        $jo_list = DB::connection('sqlsrv')->table("JOLIST.dbo.jolist")->get();

        return view('signagejo')
                ->with('signages',$signages)
                ->with('jolist',$jo_list);
    }

    public function signage_jolistv()
    {
        $signages = Signages::where('is_enabled','=',1)->get();
        $jo_list = DB::connection('sqlsrv')->table("JOLIST.dbo.jolist")->get();

        return view('signagejov')
                ->with('signages',$signages)
                ->with('jolist',$jo_list);
    }

    public function disable($id){
        $sign = Signages::find($id);
        $sign->is_enabled = 0;
        if($sign->save()){
            return redirect()->route('digital.managesignage')->withSuccess('Signage Successfully Disabled!');
        }
    }

    public function enable($id){
        $sign = Signages::find($id);
        $sign->is_enabled = 1;
        if($sign->save()){
            return redirect()->route('digital.managesignage')->withSuccess('Signage Successfully Enabled!');
        }
    }

    public function delete($id){
        $sign = Signages::find($id);
        if($sign->forceDelete()){
            return redirect()->route('digital.managesignage')->withSuccess('Signage Successfully Deleted!');
        }
    }

    public function jolist(){
        $jo_list = DB::connection('sqlsrv')->RAW("SELECT JOLIST.dbo.jolist")->get();
        
        return response()
        ->json([
            "data" => $jo_list
        ]);
    }
}
