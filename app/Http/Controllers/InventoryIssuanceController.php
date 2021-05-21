<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\SitePermission;
 
use App\Site;
use App\Employee;
use App\ApproverMatrix;
use App\Customer;
use App\Currency;
use App\Product;
use App\ItemMaster;
use App\ItemCategory;

use App\Project;
use App\Inventory;
use App\InventoryLog;
use App\InventoryLocation;
use App\InventoryLocationType;
use App\InventoryIssuance;

use Validator;
use Response;
use Auth;
use PDF;

class InventoryIssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $sites = Site::all();
        $currency = Currency::all();
        $inventoryLocation = InventoryLocation::all();
        $issuanceCount = InventoryIssuance::count();
 
        $employees = Employee::orderBy('emp_lname')->get();
        $project = Project::where('status','<>','Pending')->get();

        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','Projects')
                        ->first();
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.inventory_issuance.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','issuance')
                ->with('employee',$employees)
                ->with('projects', $project)
                ->with('sites', $sites)
                ->with('count', $issuanceCount)
                ->with('currency', $currency)
                ->with('inventloc', $inventoryLocation)
                ->with('permission',$permissionx);
    }

    public function all($id)
    {
        return response()->json([
            "data" => InventoryIssuance::get()
        ]);
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
}
