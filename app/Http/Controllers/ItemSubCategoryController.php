<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ItemCategory;
use App\ItemSubCategory;
use Validator;

class ItemSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $itemcode = ItemCategory::all();
        return view('res.item_subcategory.index')
                ->with('site','res')
                ->with('page','masterdata')
                ->with('subpage','itemsubcat')
                ->with('itemcode',$itemcode);
    }

    public function all()
    {
        return response()
            ->json([
                "data" => ItemSubCategory::all()
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
            'cat_code' => 'required',
            'subcat_code' => 'required|unique:item_sub_categories',
            'subcat_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $itemsubcat = new ItemSubCategory();
            $itemsubcat->cat_code = Str::upper($request->input('cat_code',''));
            $itemsubcat->subcat_code = Str::upper($request->input('subcat_code',''));
            $itemsubcat->subcat_desc = $request->input('subcat_desc','');

            if($itemsubcat->save()){
                return redirect()->route('item_subcategory.index')->withSuccess('Item Sub-Category Successfully Added');
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
        $data = ItemSubCategory::find($id);
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
            'cat_code' => 'required',
            'subcat_code' => 'required',
            'subcat_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $itemsubcat = ItemSubCategory::find($request->input('id',''));
            $itemsubcat->cat_code = Str::upper($request->input('cat_code',''));
            $itemsubcat->subcat_code = Str::upper($request->input('subcat_code',''));
            $itemsubcat->subcat_desc = $request->input('subcat_desc','');

            if($itemsubcat->save()){
                return redirect()->route('item_subcategory.index')->withSuccess('Item Sub-Category Successfully Updated');
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
        if(ItemSubCategory::destroy($request->input('id',''))){
            return redirect()->route('item_subcategory.index')->withSuccess('Item Sub-Category Successfully Deleted');
        } else {
            return redirect()->route('item_subcategory.index')->withErrors('Item Sub-Category Delete Unsuccessful');
        }
    }
}
