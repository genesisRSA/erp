<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ItemCategory;
use Validator;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('res.item_category.index')
            ->with('site','res')
            ->with('page','itemcategory')
            ->with('subpage','itemcategories');
    }

    public function all()
    {
        return response()
            ->json([
                "data" => ItemCategory::all()
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
            'cat_code' => 'required|unique:item_categories',
            'cat_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $itemcat = new ItemCategory();
            $itemcat->cat_code = Str::upper($request->input('cat_code',''));
            $itemcat->cat_desc = $request->input('cat_desc','');

            if($itemcat->save()){
                return redirect()->route('item_category.index')->withSuccess('Item Category Successfully Added');
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
        $data = ItemCategory::find($id);
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
            'cat_desc' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $itemcat = ItemCategory::find($request->input('id',''));
            $itemcat->cat_code = Str::upper($request->input('cat_code',''));
            $itemcat->cat_desc = $request->input('cat_desc','');

            if($itemcat->save()){
                return redirect()->route('item_category.index')->withSuccess('Item Category Successfully Updated');
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
        if(ItemCategory::destroy($request->input('id',''))){
            return redirect()->route('item_category.index')->withSuccess('Item Category Successfully Deleted');
        }
    }
}
