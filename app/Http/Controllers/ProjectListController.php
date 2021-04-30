<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\SitePermission;
use App\SalesOrder;
use App\Site;
use App\Employee;
use App\Customer;
use App\Product;
use App\Assembly;
use App\AssemblyFab;
use App\AssemblyAdtlItem;
use App\Fabrication;
use App\Project;
use App\ProjectAssembly;
use App\UnitOfMeasure;
use Validator;
use Auth;

class ProjectListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $product = Product::all();
        $customer = Customer::all();
        $salesorder = SalesOrder::all();
        $site = Site::where('site_code','=',$employee->site_code)->get();
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Projects')
        ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.project_list.index')
                ->with('site','res')
                ->with('page','projects')
                ->with('subpage','list')
                ->with('sites', $site)
                ->with('products', $product) 
                ->with('customers', $customer) 
                ->with('salesorders', $salesorder) 
                ->with('permission',$permissionx);
    }

    public function all($id)
    {
        $idx = Crypt::decrypt($id);
        $data = Project::where('created_by','=',$idx)
                        ->with('customers:cust_code,cust_name')
                        ->get();

        return response()
        ->json([
            "data" => $data
        ]); 
    }

    public function all_orders($site_code)
    {
        return response()
        ->json([
            "data" => SalesOrder::where('site_code',$site_code)
                                ->where('status','<>','Pending')    
                                ->where('status','<>','Voided')    
                                ->where('status','<>','On Going')    
                                ->get()
        ]); 
    }

    public function all_products($order_code)
    {
        return response()
        ->json([
            "data" => SalesOrder::where('order_code','=',$order_code)
                                    ->first()
        ]); 
    }

    public function count_per_type($cust_code)
    {
        return response()
        ->json([
            "data" => Customer::where('cust_code','=',$cust_code)
                                    ->first()
        ]);
    }

    public function prod_assy($prod_code)
    {
        return response()
        ->json([
            "data" => Assembly::where('prod_code','=',$prod_code)
                                    ->get()
        ]);
    }

    public function assy_fab($assy_code)
    {
        return response()
        ->json([
            "data" => Fabrication::where('assy_code','=',$assy_code)
                                    ->get()
        ]);
    }

    public function create()
    {
        $employee = Employee::where('emp_no','=',Auth::user()->emp_no)->first();
        $product = Product::all();
        $customer = Customer::all();
        $salesorder = SalesOrder::all();
        $assembly = Assembly::all();
        $uom = UnitOfMeasure::all();
        $sales = json_decode($salesorder, true);

        $site = Site::where('site_code','=',$employee->site_code)->get();
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
        ->where('module','=','Projects')
        ->first();

        // return $sales[0];
        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        // return $sales[0]['products'];
        // return $uom;
        return view('res.project_list.new')
                ->with('site','res')
                ->with('page','projects')
                ->with('subpage','list')
                ->with('sites', $site)
                ->with('products', $product) 
                ->with('assycode', $assembly) 
                ->with('uoms', $uom)
                ->with('customers', $customer) 
                ->with('salesorders', $salesorder) 
                ->with('permission',$permissionx);
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
            // 'currency_code' => 'required',
            // 'unit_price' => 'required',
            // 'quantity' => 'required',
            // 'total_price' => 'required',
            // 'app_seq' => 'required',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('forecast.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $project = new Project();
            $project->project_code = $request->input('project_code','');
            $project->project_name = $request->input('project_name','');
            $project->project_type = $request->input('project_type','');
            $project->order_code = $request->input('sales_order','');

            $project->site_code =  Str::upper($request->input('site_code',''));
            $project->cust_code = Str::upper($request->input('customer',''));
            $project->prod_code = Str::upper($request->input('product',''));
            $project->quantity = $request->input('quantity','');
            $project->delivery_date= '2021-04-29'; // temporary date  $request->input('delivery_date','');
            $project->status = 'Pending';
            $project->created_by = Auth::user()->employee->emp_no;

            if($request->input('fab_assy_code'))
            {   
                for( $i = 0 ; $i < count($request->input('fab_assy_code')) ; $i++ )
                {
                    $mechfab = new AssemblyFab;
                    $mechfab->project_code = $request->input('project_code','');
                    $mechfab->assy_code = $request->input('fab_assy_code.'.$i);
                    $mechfab->fab_code = $request->input('fab_code.'.$i);
                    $mechfab->fab_desc = $request->input('fab_desc.'.$i);
                    $mechfab->length = $request->input('fab_length.'.$i);
                    $mechfab->width = $request->input('fab_width.'.$i);
                    $mechfab->thickness = $request->input('fab_thickness.'.$i);
                    $mechfab->radius = $request->input('fab_radius.'.$i);
                    $mechfab->created_by = Auth::user()->employee->emp_no;
                    $mechfab->save();
                }
            }

            if($request->input('item_assy_code'))
            {   
                for( $i = 0 ; $i < count($request->input('item_assy_code')) ; $i++ )
                {
                    $additem = new AssemblyAdtlItem;
                    $additem->project_code = $request->input('project_code','');
                    $additem->assy_code = $request->input('item_assy_code.'.$i);
                    $additem->item_code = $request->input('item_code.'.$i);
                    $additem->item_desc = $request->input('item_desc.'.$i);
                    $additem->uom_code = $request->input('item_uom.'.$i);
                    $additem->length = $request->input('item_length.'.$i);
                    $additem->width = $request->input('item_width.'.$i);
                    $additem->thickness = $request->input('item_thickness.'.$i);
                    $additem->radius = $request->input('item_radius.'.$i);
                    $additem->location = $request->input('item_loc.'.$i);
                    $additem->created_by = Auth::user()->employee->emp_no;
                    $additem->save();
                }
            }

            if($request->input('assy_code'))
            {   
                for( $i = 0 ; $i < count($request->input('assy_code')) ; $i++ )
                {
                    $additem = new ProjectAssembly;
                    $additem->project_code = $request->input('project_code','');
                    $additem->assy_code = $request->input('assy_code.'.$i);
                    $additem->assy_desc = $request->input('assy_desc.'.$i);
                    $additem->created_by = Auth::user()->employee->emp_no;
                    $additem->save();
                }
            }

            $order = SalesOrder::where('order_code',$request->input('sales_order',''))->first();
            $order->status = 'On Going';
            $order->save();

            // DETAILS FOR EMAIL BELOW

                        // $project_details = $project;
                        // $lastid = DB::table('sales_projects')->latest('id')->first();

                        // if($lastid){
                        //     $lastid = $lastid->id + 1;
                        // }else{
                        //     $lastid = 0;
                        // }
                        // $approver = Employee::where('emp_no','=',$approverID)->first();

                        // $maildetails = new SalesMailable('REISS - Sales project Approval',
                        //                                 'project',
                        //                                 'Pending',
                        //                                 'approver',
                        //                                 $approver->emp_fname,
                        //                                 $request->input('project_code',''),
                        //                                 Auth::user()->employee->full_name, // full_name
                        //                                 '',
                        //                                 $lastid); // remarks here

            if($project->save()){
                // Mail::to('johnpaul.sarinas@rsa.com.ph', 'John Paul Sarinas')->send($maildetails);
                // Mail::to($approver->work_email, $approver->full_name)
                return redirect()->route('projects.index')->withSuccess('Sales project Details Successfully Added');
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
