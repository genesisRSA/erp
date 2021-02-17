<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ProductCategory;
use Validator;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('res.product_category.index')
        ->with('site','res')
        ->with('page','products')
        ->with('subpage','productcategories');
    }

    public function all()
    {
        return response()
            ->json([
                "data" => ProductCategory::all()
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
            'prodcat_name' => 'required',
            'prodcat_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $prodcat = new ProductCategory();
            $prodcat->prodcat_name = $request->input('prodcat_name','');
            $prodcat->prodcat_code = Str::upper($request->input('prodcat_code',''));

            if($prodcat->save()){
                return redirect()->route('product_category.index')->withSuccess('Product Category Successfully Added');
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
        $data = ProductCategory::find($id);
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
            'prodcat_name' => 'required',
            'prodcat_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $prodcat = ProductCategory::find($request->input('id',''));
            $prodcat->prodcat_name = $request->input('prodcat_name','');
            $prodcat->prodcat_code = Str::upper($request->input('prodcat_code',''));

            if($prodcat->save()){
                return redirect()->route('product_category.index')->withSuccess('Product Category Successfully Updated');
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
        if(ProductCategory::destroy($request->input('id',''))){
            return redirect()->route('product_category.index')->withSuccess('Product Category Successfully Deleted');
        }
    }
}
