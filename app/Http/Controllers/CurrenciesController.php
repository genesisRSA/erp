<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use Validator;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('res.currency.index')
                ->with('site','res')
                ->with('page','parameters')
                ->with('subpage','currency');
    }

    public function all()
    {
        return response()
            ->json([
                "data" => Currency::all()
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
            'currency_name' => 'required',
            'currency_code' => 'required',
            'currency_words' => 'required',
            'symbol' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $currency = new Currency();
            $currency->currency_name = $request->input('currency_name','');
            $currency->currency_code = $request->input('currency_code','');
            $currency->currency_words = $request->input('currency_words','');
            $currency->symbol = $request->input('symbol','');

            if($currency->save()){
                return redirect()->route('currency.index')->withSuccess('Currency Successfully Added');
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
        $data = Currency::find($id);
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
            'currency_name' => 'required',
            'currency_code' => 'required',
            'currency_words' => 'required',
            'symbol' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator);
        }else{
            $currency = Currency::find($request->input('id',''));
            $currency->currency_name = $request->input('currency_name','');
            $currency->currency_code = $request->input('currency_code','');
            $currency->currency_words = $request->input('currency_words','');
            $currency->symbol = $request->input('symbol','');

            if($currency->save()){
                return redirect()->route('currency.index')->withSuccess('Currency Successfully Updated');
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
        if(Currency::destroy($request->input('id',''))){
            return redirect()->route('currency.index')->withSuccess('Currency Successfully Deleted');
        }
    }
}
