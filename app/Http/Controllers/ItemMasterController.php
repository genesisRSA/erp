<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\ItemMaster;
use App\ItemCategory;
use App\ItemSubCategory;
use App\UnitOfMeasure;
use Validator;
 

class ItemMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemmaster = ItemMaster::all();
        $itemcat = ItemCategory::all();
        $itemsubcat = ItemSubCategory::all();
        $uom = UnitOfMeasure::all();

        return view('res.item_master.index')
                ->with('site','res')
                ->with('page','masterdata')
                ->with('subpage','itemmaster')
                ->with('itemmaster',$itemmaster)
                ->with('itemcat',$itemcat)
                ->with('itemsubcat',$itemsubcat)
                ->with('uom',$uom);
    }

    public function all()
    {
        return response()
            ->json([
                "data" => ItemMaster::with('item_cat:cat_code,cat_desc')
                                     ->with('item_subcat:subcat_code,subcat_desc')
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
        // return 'test';
        $field = [
            'item_cat_code' => 'required',
            'item_subcat_code' => 'required',
            'item_code' => 'required|unique:item_masters',
            'oem_partno' => 'unique:item_masters',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('item_master.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $itemaster = new ItemMaster();
            $itemaster->cat_code =          Str::upper($request->input('item_cat_code',''));
            $itemaster->subcat_code =       Str::upper($request->input('item_subcat_code',''));
            $itemaster->item_code =         Str::upper($request->input('item_code',''));
            $itemaster->item_desc =         $request->input('item_desc','');
            $itemaster->oem_partno =        $request->input('item_oem','');
            $itemaster->uom_code =          $request->input('item_uom','');
            $itemaster->safety_stock =      $request->input('item_safety','');
            $itemaster->maximum_stock =     $request->input('item_max','');
            $itemaster->length =            $request->input('item_length','');
            $itemaster->width =             $request->input('item_width','');
            $itemaster->thickness =         $request->input('item_thickness','');
            $itemaster->radius =            $request->input('item_radius','');
            $itemaster->is_serialized =     $request->input('serialized');

            if($itemaster->save()){
                return redirect()->route('item_master.index')->withSuccess('Item Master Details Successfully Added');
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
        $data = ItemMaster::find($id);
        return response()
            ->json([
                "data" => $data
            ]);
    }

    public function getItemDetails($item_code)
    {
        //
        $data = ItemMaster::where('item_code',$item_code)->first();
        return response()
            ->json([
                "data" => $data
            ]);
    }

    public function getSubCategory($id)
    {
        $data = ItemSubCategory::where('cat_code',$id)->get();
        \Log::info($data);
        return response()->json(['data' => $data]);
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
            'item_cat_code' => 'required',
            'item_subcat_code' => 'required',
            'item_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $itemmas = ItemMaster::find($request->input('id',''));
            $itemmas->cat_code =          Str::upper($request->input('item_cat_code',''));
            $itemmas->subcat_code =       Str::upper($request->input('item_subcat_code',''));
            $itemmas->item_code =         Str::upper($request->input('item_code',''));
            $itemmas->item_desc =         $request->input('item_desc','');
            $itemmas->oem_partno =        $request->input('item_oem','');
            $itemmas->uom_code =          $request->input('item_uom','');
            $itemmas->safety_stock =      $request->input('item_safety','');
            $itemmas->maximum_stock =     $request->input('item_max','');
            $itemmas->length =            $request->input('item_length','');
            $itemmas->width =             $request->input('item_width','');
            $itemmas->thickness =         $request->input('item_thickness','');
            $itemmas->radius =            $request->input('item_radius','');
            $itemmas->is_serialized =     $request->input('serialized');

            if($itemmas->save()){
                return redirect()->route('item_master.index')->withSuccess('Item Master Details Successfully Updated');
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
        if(ItemMaster::destroy($request->input('id',''))){
            return redirect()->route('item_master.index')->withSuccess('Item Master Details Successfully Deleted');
        }
    }
}
