<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\UnitOfMeasure;
use App\UOMConversion;
use Validator;

class UOMConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uoms = UnitOfMeasure::all();
        return view('res.uom_conversion.index')
                ->with('site','res')
                ->with('page','parameters')
                ->with('subpage','uom_conversion')
                ->with('uoms', $uoms);
    }

    public function all()
    {
        return response()
            ->json([
                "data" => UOMConversion::all()
            ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $field = [
            'uom_cnv_type' => 'required',
            'uom_cnv_name' => 'required',
            'uom_from' => 'required',
            'uom_from_value' => 'required',
            'uom_to' => 'required',
            'uom_to_value' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{

            $uomExist = UOMConversion::where('uom_from','=',$request->input('uom_from'))
                                    ->where('uom_to','=',$request->input('uom_to')) 
                                    ->first();

            if($uomExist == null){
                $uomOneToOneExist = UOMConversion::where('uom_from','=',$request->input('uom_from'))
                                    ->where('uom_to','=',$request->input('uom_from')) 
                                    ->first();
                if($uomOneToOneExist == null){
                    $uomOneToOne = new UOMConversion();
                    $uomOneToOne->uom_cnv_type = $request->input('uom_cnv_type','');
                    $uomName = explode(" ", $request->input('uom_cnv_name',''));
                    $uomOneToOne->uom_cnv_name = $uomName[0].' to '.$uomName[0];
                    $uomOneToOne->uom_from = $request->input('uom_from','');
                    $uomOneToOne->uom_from_value = $request->input('uom_from_value','');
                    $uomOneToOne->uom_to = $request->input('uom_from','');
                    $uomOneToOne->uom_to_value = $request->input('uom_from_value','');
                    $uomOneToOne->save();
    
                    $uom = new UOMConversion();
                    $uom->uom_cnv_type = $request->input('uom_cnv_type','');
                    $uom->uom_cnv_name = $request->input('uom_cnv_name','');
                    $uom->uom_from = $request->input('uom_from','');
                    $uom->uom_from_value = $request->input('uom_from_value','');
                    $uom->uom_to = $request->input('uom_to','');
                    $uom->uom_to_value = $request->input('uom_to_value','');
                } else {
                    $uom = new UOMConversion();
                    $uom->uom_cnv_type = $request->input('uom_cnv_type','');
                    $uom->uom_cnv_name = $request->input('uom_cnv_name','');
                    $uom->uom_from = $request->input('uom_from','');
                    $uom->uom_from_value = $request->input('uom_from_value','');
                    $uom->uom_to = $request->input('uom_to','');
                    $uom->uom_to_value = $request->input('uom_to_value','');
                }
            } else {
                return redirect()->route('uom_conversion.index')->withErrors('Unit Conversion Already Exist!');
            }
            
            if($uom->save()){
                return redirect()->route('uom_conversion.index')->withSuccess('Unit Conversion Successfully Added');
            }
        }
    }

    public function show($id)
    {
        $data = UOMConversion::find($id);
        return response()
            ->json([
                "data" => $data
            ]);
    }

    public function getUOMperType($type)
    {
        return response()
            ->json([
                "data" => UnitOfMeasure::where('uom_type', $type)->get()
            ]);
    }

    public function getUOMconversion($code)
    {
        return response()
            ->json([
                "data" => UOMConversion::where('uom_from', $code)
                                    ->with('uom_details:uom_code,uom_name')
                                    ->get()
            ]);
    }

    public function getReverseConvert($from, $to)
    {
        return response()
        ->json([
            "data" => UOMConversion::where('uom_from', $from)
                                ->where('uom_to', $to)
                                ->first()
        ]);
    }

    public function getConversionValue($id)
    {
        return response()
            ->json([
                "data" => UOMConversion::find($id)
            ]);
    }

    public function edit($id)
    {
        //
    }

    public function patch(Request $request)
    {
        $field = [
            'uom_cnv_type' => 'required',
            'uom_cnv_name' => 'required',
            'uom_from' => 'required',
            'uom_from_value' => 'required',
            'uom_to' => 'required',
            'uom_to_value' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $uom = UOMConversion::find($request->input('id'));
            $uom->uom_cnv_type = $request->input('uom_cnv_type','');
            $uom->uom_cnv_name = $request->input('uom_cnv_name','');
            $uom->uom_from = $request->input('uom_from','');
            $uom->uom_from_value = $request->input('uom_from_value','');
            $uom->uom_to = $request->input('uom_to','');
            $uom->uom_to_value = $request->input('uom_to_value','');
 
            if($uom->save()){
                return redirect()->route('uom_conversion.index')->withSuccess('Unit Conversion Successfully Updated');
            }
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
 
    public function delete(Request $request)
    {
        //
        if(UOMConversion::destroy($request->input('id',''))){
            return redirect()->route('uom_conversion.index')->withSuccess('Unit Conversion Successfully Deleted');
        }
    }
}
