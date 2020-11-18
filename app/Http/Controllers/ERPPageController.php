<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ERPPageController extends Controller
{
    //
    function home(){
        return view('res.home')
                    ->with('site','res')
                    ->with('page','home')
                    ->with('subpage','');
    }
}
