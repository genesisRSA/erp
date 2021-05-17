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
use App\Customer;
use App\Product;
use App\ItemMaster;
use App\ItemCategory;
use App\InventoryLocation;
use App\InventoryLocationType;

use Validator;
use Response;
use Auth;
use PDF;
 

class InventoryLocationController extends Controller
{
   
    public function index()
    {
        $itemcategory = ItemCategory::all();
        $locationcount = InventoryLocation::count();
        $locationtype = InventoryLocationType::all();
        $permission = SitePermission::where('requestor','=',Auth::user()->emp_no)
                        ->where('module','=','Projects')
                        ->first();

        $permissionx =  ($permission ? json_decode($permission->permission, true) : json_decode('[{"add":false,"edit":false,"view":false,"delete":false,"void":false,"approval":false,"masterlist":false}]', true));

        return view('res.inventory_location.index')
                ->with('site','res')
                ->with('page','inventory')
                ->with('subpage','location')
                ->with('itemcat', $itemcategory) 
                ->with('type', $locationtype) 
                ->with('count', $locationcount)
                ->with('permission',$permissionx);
    }

    public function all($id)
    {
        return response()->json([
            "data" => InventoryLocation::with('reqcat:cat_code,cat_desc')
                                        ->with('loctype:location_code,location_type')
                                        ->get()
        ]);
    }
 
    public function create()
    {
        //
    }

    public function barcodes($id)
    {   
        $style = array(
                    'position' => '',
                    'align' => 'C',
                    'stretch' => false,
                    'fitwidth' => true,
                    'cellfitalign' => '',
                    'border' => true,
                    'hpadding' => 'auto',
                    'vpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false,
                    'text' => true,
                    'font' => 'helvetica',
                    'fontsize' => 8,
                    'stretchtext' => 4
                );
        // return $id;
        $code = InventoryLocation::find($id);
                // return $code->location_code;
        $pdf = 'file://'.realpath('../storage/app/assets/pdfbarcode.pdf');
        $preference = array('FitWindow' => true,'CenterWindow' => true);
        PDF::Reset();
        PDF::SetAutoPageBreak(true, 20);
        PDF::setViewerPreferences($preference);
        $pageCount = PDF::setSourceFile($pdf);
        for($i=1; $i <= $pageCount; $i++){ 
            PDF::AddPage();
            $page = PDF::importPage($i);
            PDF::useTemplate($page, 0, 0);
            PDF::setPrintHeader(false);
            PDF::setPrintFooter(false);
         
            PDF::SetFont('helvetica', '', 10);
            PDF::write1DBarcode($code->location_code, 'C128A', '', '', '', 18, 0.4, $style, 'N');
            
            PDF::SetMargins(false, false);
        };

        PDF::Output('hello_world.pdf', 'I');
    
    }
 
    public function store(Request $request)
    {
        $field = [
            // 'item_cat_code' => 'required',
            // 'item_subcat_code' => 'required',
            // 'item_code' => 'required|unique:item_masters',
            // 'oem_partno' => 'unique:item_masters',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('location.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            if($request->input('location_name'))
            {
                $invloc = new InventoryLocation();
                $invloc->location_code =            Str::upper($request->input('location_code',''));
                $invloc->category =                 Str::upper($request->input('category',''));
                $invloc->location_name =            $request->input('location_name','');
                $invloc->required_item_category =   $request->input('required_item_category','');
                $invloc->created_by =               Auth::user()->emp_no;

                if($invloc->save()){
                    return redirect()->route('location.index')->withSuccess('Inventory Location Successfully Added');
                }
            } else {
                return redirect()->route('location.index')->withErrors('Please fill up all the Inventory Location details!');
            }
        }
    }

    public function show($id)
    {
        $data = InventoryLocation::find($id);
        return response()
            ->json([
                "data" => $data
            ]);
    }
 
    public function edit($id)
    {
        //
    }
 
    public function update(Request $request, $id)
    {
        //
    }

    public function patch(Request $request)
    {
        $field = [
            // 'item_cat_code' => 'required',
            // 'item_subcat_code' => 'required',
            // 'item_code' => 'required|unique:item_masters',
            // 'oem_partno' => 'unique:item_masters',
        ];

        $validator = Validator::make($request->all(), $field);
         
        if ($validator->fails()) {
            return redirect()->route('location.index')
                        ->withInput()
                        ->withErrors($validator);
        }else{
            if($request->input('location_name'))
            {
                $invloc = InventoryLocation::find($request->input('id'));
                $invloc->location_code =            Str::upper($request->input('location_code'));
                $invloc->category =                 Str::upper($request->input('category'));
                $invloc->location_name =            $request->input('location_name');
                $invloc->required_item_category =   $request->input('required_item_category');
                $invloc->updated_by =               Auth::user()->emp_no;

                if($invloc->save()){
                    return redirect()->route('location.index')->withSuccess('Inventory Location Successfully Updated');
                }
            } else { 
                return redirect()->route('location.index')->withErrors('Please fill up all the Inventory Location details!');
            }
        }
    }
 
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        if(InventoryLocation::destroy($request->input('id'))){
            return redirect()->route('location.index')->withSuccess('Inventory Location Successfully Deleted');
        }
    }
}
