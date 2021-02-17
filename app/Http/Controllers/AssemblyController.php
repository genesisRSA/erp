<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Assembly;

use App\Product;
use Validator;

class AssemblyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $assemblycode = Assembly::all();
        $prodcode = Product::all();
        return view('res.assembly.index')
                ->with('site','res')
                ->with('page','assemblylist')
                ->with('subpage','assemblylist')
                ->with('products',$prodcode)
                ->with('assycode',$assemblycode);
    }

    public function all()
    {
        return response()
            ->json([
                "data" => Assembly::all()
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
            'prod_code' => 'required',
            'assy_code' => 'required|unique:assemblies',
            'assy_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $assembly = new Assembly();
            $assembly->prod_code = Str::upper($request->input('prod_code',''));
            $assembly->assy_code = Str::upper($request->input('assy_code',''));
            $assembly->assy_desc = $request->input('assy_desc','');
            $assembly->parent_assy_code = $request->input('parent_assy_code','');

            if($assembly->save()){
                return redirect()->route('assembly.index')->withSuccess('Assembly Details Successfully Added');
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
        $data = Assembly::find($id);
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
            'prod_code' => 'required',
            'assy_code' => 'required|unique:assemblies',
            'assy_desc' => 'required',
            'parent_assy_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $assembly = Assembly::find($request->input('id',''));
            $assembly->prod_code = $request->input('prod_code','');
            $assembly->assy_code = $request->input('assy_code','');
            $assembly->assy_desc = $request->input('assy_desc','');
            $assembly->parent_assy_code = $request->input('parent_assy_code','');

            if($assembly->save()){
                return redirect()->route('assembly.index')->withSuccess('Assembly Details Successfully Updated');
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
        if(Assembly::destroy($request->input('id',''))){
            return redirect()->route('assembly.index')->withSuccess('Assembly Details Successfully Deleted');
        }
    }
}
