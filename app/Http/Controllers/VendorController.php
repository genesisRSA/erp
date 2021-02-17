<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Vendor;
use App\PaymentTerm;
use App\Currency;
use Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = PaymentTerm::all();
        $currency = Currency::all();
        return view('res.vendor.index')
                ->with('site','res')
                ->with('page','masterdata')
                ->with('subpage','vendor')
                ->with('terms',$terms)
                ->with('currency',$currency);
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
        $field = [
            'ven_name' => 'required',
            'ven_code' => 'required',
            'ven_num_code' => 'required',
            'ven_type' => 'required',
            'currency_id' => 'required',
            'term_id' => 'required',
            'vat_type' => 'required',
            'ven_tin' => 'required',
            'ven_address' => 'required',
            'ven_email' => 'required',
            'ven_no' => 'required',
            'ven_person' => 'required',
            'ven_person_pos' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $vendor = new Vendor();
            $vendor->ven_name = $request->input('ven_name','');
            $vendor->ven_code = Str::upper($request->input('ven_code',''));
            $vendor->ven_num_code = $request->input('ven_num_code','');
            $vendor->ven_type = $request->input('ven_type','');
            $vendor->currency_id = $request->input('currency_id','');
            $vendor->term_id = $request->input('term_id','');
            $vendor->vat_type = $request->input('vat_type','');
            $vendor->ven_tin = $request->input('ven_tin','');
            $vendor->ven_website = $request->input('ven_website','') ? $request->input('ven_website','') : 'N/A';
            $vendor->ven_address = $request->input('ven_address','');
            $vendor->ven_email = $request->input('ven_email','');
            $vendor->ven_no = $request->input('ven_no','');
            $vendor->ven_person = $request->input('ven_person','');
            $vendor->ven_person_pos = $request->input('ven_person_pos','');
            $vendor->remarks = $request->input('remarks','') ? $request->input('remarks','') : 'N/A';

            if($vendor->save()){
                return redirect()->route('vendor.index')->withSuccess('Vendor Successfully Added');
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
        $data = Vendor::find($id);
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
        if(Vendor::destroy($request->input('id',''))){
            return redirect()->route('vendor.index')->withSuccess('Vendor Successfully Deleted');
        }
    }

    public function patch(Request $request)
    {
        $field = [
            'ven_name' => 'required',
            'ven_code' => 'required',
            'ven_type' => 'required',
            'currency_id' => 'required',
            'term_id' => 'required',
            'vat_type' => 'required',
            'ven_tin' => 'required',
            'ven_address' => 'required',
            'ven_email' => 'required',
            'ven_no' => 'required',
            'ven_person' => 'required',
            'ven_person_pos' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $vendor = Vendor::find($request->input('id',''));
            $vendor->ven_name = $request->input('ven_name','');
            $vendor->ven_code = Str::upper($request->input('ven_code',''));
            $vendor->ven_type = $request->input('ven_type','');
            $vendor->currency_id = $request->input('currency_id','');
            $vendor->term_id = $request->input('term_id','');
            $vendor->vat_type = $request->input('vat_type','');
            $vendor->ven_tin = $request->input('ven_tin','');
            $vendor->ven_website = $request->input('ven_website','') ? $request->input('ven_website','') : 'N/A';
            $vendor->ven_address = $request->input('ven_address','');
            $vendor->ven_email = $request->input('ven_email','');
            $vendor->ven_no = $request->input('ven_no','');
            $vendor->ven_person = $request->input('ven_person','');
            $vendor->ven_person_pos = $request->input('ven_person_pos','');
            $vendor->remarks = $request->input('remarks','') ? $request->input('remarks','') : 'N/A';

            if($vendor->save()){
                return redirect()->route('vendor.index')->withSuccess('Customer Successfully Updated');
            }
        }
    }

    public function all()
    {
        return response()
                ->json([
                    "data" => Vendor::all()
                ]);
    }
}
