<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentTerm;
use Validator;

class PaymentTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('res.payment_term.index')
        ->with('site','res')
        ->with('page','parameters')
        ->with('subpage','payment_term');
    }

    public function all()
    {
        return response()
            ->json([
                "data" => PaymentTerm::all()
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
            'term_name' => 'required',
            'term_days' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $term = new PaymentTerm();
            $term->term_name = $request->input('term_name','');
            $term->term_days = $request->input('term_days','');
            $term->is_endofmonth = $request->input('is_endofmonth','') ? true : false;

            if($term->save()){
                return redirect()->route('payment_term.index')->withSuccess('Payment Term Successfully Added');
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
        $data = PaymentTerm::find($id);
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
            'term_name' => 'required',
            'term_days' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $term = PaymentTerm::find($request->input('id',''));
            $term->term_name = $request->input('term_name','');
            $term->term_days = $request->input('term_days','');
            $term->is_endofmonth = $request->input('is_endofmonth','') ? true : false;

            if($term->save()){
                return redirect()->route('payment_term.index')->withSuccess('Payment Term Successfully Updated');
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
        if(PaymentTerm::destroy($request->input('id',''))){
            return redirect()->route('payment_term.index')->withSuccess('Payment Term Successfully Deleted');
        }
    }
}
