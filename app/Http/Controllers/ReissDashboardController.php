<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class ReissDashboardController extends Controller
{
    //
    function index($parent){

        $salesrep = Employee::where('position','LIKE','%Sales Rep%')
                    ->where('emp_cat','<>','Resigned')
                    ->get();

        return view("res.dashboard.".$parent)
                ->with('page',$parent)
                ->with('subpage',$parent.'dashboard')
                ->with('salesrep',$salesrep);
    }
}
