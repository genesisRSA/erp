<?php

namespace App\Http\Controllers;

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
}
