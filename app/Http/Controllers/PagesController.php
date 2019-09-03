<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{

    //HRIS
    public function hris_index(){
        if (Auth::check()) {
            return redirect('/hris/home');
        }
        return view("pages.hris.index");
    }

    public function hris_home(){
        return view("pages.hris.dashboard.home")
                    ->with(array('site'=> 'hris', 'page'=>'home'));
    }

    public function attendance(){
        return view("pages.hris.dashboard.attendance")
                    ->with(array('site'=> 'hris', 'page'=>'attendance'));  
    }

    public function myattendance(){
        return view("pages.hris.dashboard.myattendance")
                    ->with(array('site'=> 'hris', 'page'=>'my attendance'));  
    }

    public function timekeeping(){
        return view("pages.hris.dashboard.timekeeping")
                    ->with(array('site'=> 'hris', 'page'=>'timekeeping'));  
    }

    public function reports(){
        return view("pages.hris.dashboard.reports")
                    ->with(array('site'=> 'hris', 'page'=>'reports'));  
    }

    public function mytimekeeping(){
        return view("pages.hris.dashboard.mytimekeeping")
                    ->with(array('site'=> 'hris', 'page'=>'my timekeeping'));  
    }
    
    //AIS
    public function ics_index(){
        return view("pages.ics.index");
    }

    public function ics_home(){
        return view("pages.ics.home")
                    ->with(array('site'=> 'ics', 'page'=>'home'));
    }

    public function inventory(){
        return view("pages.ics.inventory")
                    ->with(array('site'=> 'ics', 'page'=>'inventory management'));
    }

    public function barcode(){
        return view("pages.ics.barcode")
                    ->with(array('site'=> 'ics', 'page'=>'item barcoding'));
    }



}
