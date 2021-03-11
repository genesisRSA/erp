<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReissDashboardController extends Controller
{
    //
    function index($parent){

        return view("res.dashboard.".$parent)
                ->with('page','sales')
                ->with('subpage','salesdashboard');
    }
}
