<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Fabrication;
use App\Assembly;
use Validator;

class FabricationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fab = Fabrication::all();
        $assembly = Assembly::all();
        return view('res.fabrication.index')
                ->with('site','res')
                ->with('page','products')
                ->with('subpage','fabricationlist')
                ->with('fabrication',$fab)
                ->with('assycode',$assembly);
    }

    public function all()
    {
        return response()
            ->json([
                "data" => Fabrication::all()
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
            'assy_code' => 'required',
            'fab_code' => 'required|unique:fabrications',
            'fab_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $fabrication = new Fabrication();
            $fabrication->assy_code = Str::upper($request->input('assy_code',''));
            $fabrication->fab_code = Str::upper($request->input('fab_code',''));
            $fabrication->fab_desc = $request->input('fab_desc','');
            $fabrication->length = $request->input('fab_length','');
            $fabrication->width = $request->input('fab_width','');
            $fabrication->thickness = $request->input('fab_thickness','');
            $fabrication->radius = $request->input('fab_radius','');

            if($fabrication->save()){
                return redirect()->route('fabrication.index')->withSuccess('Fabrication Details Successfully Added');
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
        $data = Fabrication::find($id);
        return response()
            ->json([
                "data" => $data
            ]);
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

    public function patch(Request $request)
    {
        $field = [
            'assy_code' => 'required',
            'fab_code' => 'required|unique:fabrications',
            'fab_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $fab = Fabrication::find($request->input('id',''));
            $fab->assy_code = Str::upper($request->input('assy_code',''));
            $fab->fab_code = Str::upper($request->input('fab_code',''));
            $fab->fab_desc = $request->input('fab_desc','');
            $fab->length = $request->input('fab_length','');
            $fab->width = $request->input('fab_width','');
            $fab->thickness = $request->input('fab_thickness','');
            $fab->radius = $request->input('fab_radius','');

            if($fab->save()){
                return redirect()->route('fabrication.index')->withSuccess('Fabrication Details Successfully Updated');
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

    public function delete(Request $request)
    {
        //
        if(Fabrication::destroy($request->input('id',''))){
            return redirect()->route('fabrication.index')->withSuccess('Fabrication Details Successfully Deleted');
        }
    }
}
