<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ProductCategory;
use App\Product;
use App\Site;
use Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('res.product.index')
        ->with('site','res')
        ->with('page','products')
        ->with('subpage','productlist')
        ->with('prodcat',ProductCategory::all())
        ->with('sitecode',Site::all());
    }

    public function all()
    {
        return response()
            ->json([
                "data" => Product::with('prod_cat:id,prodcat_name')
                                    ->with('site:site_code,site_desc')
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
            'prodcat_id' => 'required',
            'site_code' => 'required',
            'prod_name' => 'required',
            'prod_code' => 'required',
            'prod_type' => 'required',
            'prod_writeup' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $product = new Product();
            $product->prodcat_id = $request->input('prodcat_id','');
            $product->site_code = $request->input('site_code');
            $product->prod_name = $request->input('prod_name','');
            $product->prod_code = Str::upper($request->input('prod_code',''));
            $product->prod_type = $request->input('prod_type','');
            $product->prod_writeup = $request->input('prod_writeup','');

            if($product->save()){
                return redirect()->route('product.index')->withSuccess('Product Successfully Added');
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
        $data = Product::find($id);
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
            'prodcat_id' => 'required',
            'prod_name' => 'required',
            'prod_code' => 'required',
            'prod_type' => 'required',
            'prod_writeup' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $product = Product::find($request->input('id',''));
            $product->prodcat_id = $request->input('prodcat_id','');
            $product->prod_name = $request->input('prod_name','');
            $product->prod_code = Str::upper($request->input('prod_code',''));
            $product->prod_type = $request->input('prod_type','');
            $product->prod_writeup = $request->input('prod_writeup','');

            if($product->save()){
                return redirect()->route('product.index')->withSuccess('Product Successfully Updated');
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
        if(Product::destroy($request->input('id',''))){
            return redirect()->route('product.index')->withSuccess('Product Successfully Deleted');
        }
    }
}
