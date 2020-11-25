<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitOfMeasure;
use Validator;

class UOMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('res.uom.index')
                ->with('site','res')
                ->with('page','parameters')
                ->with('subpage','uom');
    }

    public function all()
    {
        return response()
            ->json([
                "data" => UnitOfMeasure::all()
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
            'uom_name' => 'required',
            'uom_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $uom = new UnitOfMeasure();
            $uom->uom_name = $request->input('uom_name','');
            $uom->uom_code = $request->input('uom_code','');

            if($uom->save()){
                return redirect()->route('uom.index')->withSuccess('Unit Successfully Added!');
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
        return response()
            ->json([
                "data" => UnitOfMeasure::find($id)
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
            'uom_name' => 'required',
            'uom_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $uom = UnitOfMeasure::find($request->input('id',''));
            $uom->uom_name = $request->input('uom_name','');
            $uom->uom_code = $request->input('uom_code','');

            if($uom->save()){
                return redirect()->route('uom.index')->withSuccess('Unit Successfully Updated!');
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
