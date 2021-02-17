<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\PaymentTerm;
use App\Currency;
use Validator;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $terms = PaymentTerm::all();
        $currency = Currency::all();
        return view('res.customer.index')
                ->with('site','res')
                ->with('page','masterdata')
                ->with('subpage','customer')
                ->with('terms',$terms)
                ->with('currency',$currency);
    }

    public function all()
    {
        return response()
            ->json([
                "data" => Customer::all()
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
            'cust_name' => 'required',
            'cust_code' => 'required',
            'cust_num_code' => 'required',
            'cust_type' => 'required',
            'currency_id' => 'required',
            'term_id' => 'required',
            'vat_type' => 'required',
            'cust_tin' => 'required',
            'cust_address' => 'required',
            'cust_email' => 'required',
            'cust_no' => 'required',
            'cust_person' => 'required',
            'cust_person_pos' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $customer = new Customer();
            $customer->cust_name = $request->input('cust_name','');
            $customer->cust_code = Str::upper($request->input('cust_code',''));
            $customer->cust_num_code = Str::upper($request->input('cust_num_code',''));
            $customer->cust_type = $request->input('cust_type','');
            $customer->currency_id = $request->input('currency_id','');
            $customer->term_id = $request->input('term_id','');
            $customer->vat_type = $request->input('vat_type','');
            $customer->cust_tin = $request->input('cust_tin','');
            $customer->cust_website = $request->input('cust_website','') ? $request->input('cust_website','') : 'N/A';
            $customer->cust_address = $request->input('cust_address','');
            $customer->cust_email = $request->input('cust_email','');
            $customer->cust_no = $request->input('cust_no','');
            $customer->cust_person = $request->input('cust_person','');
            $customer->cust_person_pos = $request->input('cust_person_pos','');
            $customer->remarks = $request->input('remarks','') ? $request->input('remarks','') : 'N/A';

            if($customer->save()){
                return redirect()->route('customer.index')->withSuccess('Customer Successfully Added');
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
        $data = Customer::find($id);
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
            'cust_name' => 'required',
            'cust_code' => 'required',
            'cust_type' => 'required',
            'currency_id' => 'required',
            'term_id' => 'required',
            'vat_type' => 'required',
            'cust_tin' => 'required',
            'cust_address' => 'required',
            'cust_email' => 'required',
            'cust_no' => 'required',
            'cust_person' => 'required',
            'cust_person_pos' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $customer = Customer::find($request->input('id',''));
            $customer->cust_name = $request->input('cust_name','');
            $customer->cust_code = Str::upper($request->input('cust_code',''));
            $customer->cust_type = $request->input('cust_type','');
            $customer->currency_id = $request->input('currency_id','');
            $customer->term_id = $request->input('term_id','');
            $customer->vat_type = $request->input('vat_type','');
            $customer->cust_tin = $request->input('cust_tin','');
            $customer->cust_website = $request->input('cust_website','') ? $request->input('cust_website','') : 'N/A';
            $customer->cust_address = $request->input('cust_address','');
            $customer->cust_email = $request->input('cust_email','');
            $customer->cust_no = $request->input('cust_no','');
            $customer->cust_person = $request->input('cust_person','');
            $customer->cust_person_pos = $request->input('cust_person_pos','');
            $customer->remarks = $request->input('remarks','') ? $request->input('remarks','') : 'N/A';

            if($customer->save()){
                return redirect()->route('customer.index')->withSuccess('Customer Successfully Updated');
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
        if(Customer::destroy($request->input('id',''))){
            return redirect()->route('customer.index')->withSuccess('Customer Successfully Deleted');
        }
    }
}
