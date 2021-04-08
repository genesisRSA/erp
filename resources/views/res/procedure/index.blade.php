@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span>Procedures</h4>
    </div>
  </div>
  <div class="row main-content">
  
    {{-- <ul id="tabs-swipe-demo" class="tabs"> --}}
    <ul id="forecast_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#ongoing">Procedures</a></li>
      @if($permission[0]["approval"]==true)
      <li class="tab col s12 m4 l4"><a href="#approval">For Approval</a></li>
      @endif
      @if($permission[0]["masterlist"]==true)
      <li class="tab col s12 m4 l4"><a href="#master">Master Copy</a></li>
      <li class="tab col s12 m4 l4"><a href="#controlled">Controlled Copy</a></li>
      @endif
    </ul>

    <div id="ongoing" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="procedures-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>DPR No.</th>
                    <th>Document Title</th>
                    <th>Document No.</th>
                    <th>Revision No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="{{ route('procedure.create') }}" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Procedures"><i class="material-icons">add</i></a>
      @endif
    </div>

    @if($permission[0]["approval"]==true)
    <div id="approval" name="approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>DPR No.</th>
                    <th>Document Title</th>
                    <th>Document No.</th>
                    <th>Revision No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
    </div>
    @endif  

    @if($permission[0]["masterlist"]==true)
    <div id="master" name="master">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="master-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>DPR No.</th>
                    <th>Document Title</th>
                    <th>Document No.</th>
                    <th>Revision No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
    </div>

    <div id="controlled" name="controlled">
      <div class="card" style="margin-top: 0px">
        <div class="card-content">
          <table class="responsive-table highlight" id="controlled-dt" style="width: 100%">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>DPR No.</th>
                  <th>Document Title</th>
                  <th>Document No.</th>
                  <th>Revision No.</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
  </div>
    @endif  

  </div>

  <!-- MODALS -->

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('forecast.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Sales Forecast Details</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Sales Forecast Details</strong>?</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
        </div>
    </form>
  </div>

  <div id="voidModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('forecast.void')}}">
        @csrf
        <div class="modal-content">
            <h4>Void Sales Forecast</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="void_id">
                    <p>Are you sure you want to void this <strong>Sales Forecast</strong>?</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
        </div>
    </form>
  </div>

  <!-- End of MODALS -->

  <!-- SCRIPTS -->

  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script> 
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">
   

    $(document).ready(function () {
 
        @if(isset($_GET['forecastID']))
          @if($_GET['loc']=='approval')
            appItem({{Illuminate\Support\Facades\Crypt::decrypt($_GET['forecastID'])}});
          @else
            viewItem({{Illuminate\Support\Facades\Crypt::decrypt($_GET['forecastID'])}});
 
          @endif
        @endif

    });
 

    function viewItem(id)
    {  
        $('.tabs').tabs('select','view-forecast');
        $.get('forecast/'+id, function(response){

          const formatter = new Intl.NumberFormat('en-US', {
              minimumFractionDigits: 4,      
              maximumFractionDigits: 4,
            });

            var data = response.data;
            var curr_symbol = data.currency.symbol;
            var curr_name = data.currency.currency_name;
            var currency =  curr_symbol + ' - ' + curr_name;

            var unit_price = data.unit_price;
            var unit_pricex = formatter.format(unit_price);
                unit_pricex = curr_symbol + ' ' + unit_pricex;
            
            
            $('#view_id').val(data.id);
            $('#view_forecast_code').val(data.forecast_code);
            $('#view_forecast_year').val(data.forecast_year);
            $('#view_forecast_month').val(data.forecast_month);
            $('#view_site_code').val(data.sites.site_desc);
            $('#view_prod_code').val(data.products.prod_name);
            $('#view_uom_code').val(data.uoms.uom_name);
            $('#view_currency_code').val(currency);
            $('#view_unit_price').val(unit_pricex);
            $('#view_quantity').val(data.quantity);
            $('#view_total_price').val(data.total_price);
            $('#viewModal').modal('open');
        });
    }

    function appItem(id)
    {   
      $('#forecast_tab').tabs('select','approval');
        $('.tabs').tabs('select','app-forecast');
        $.get('forecast/'+id, function(response){

            const formatter = new Intl.NumberFormat('en-US', {
              minimumFractionDigits: 4,      
              maximumFractionDigits: 4,
            });

            var i, j = "";
            var data = response.data;
            var dataUP = data.unit_price;
            var dataTP = data.total_price;
            var curr_x = data.currency;
            var curr_name = curr_x.currency_name;
            
            var dataUPx = formatter.format(dataUP);
                dataUpx = curr_x.symbol + ' ' + dataUPx;

            $('#id_app').val(data.id);
            $('#seq_app').val(data.current_sequence);
            $('#appid_app').val(data.current_approver);
            
            $('#app_forecast_code').val(data.forecast_code);
            $('#app_forecast_year').val(data.forecast_year);
            $('#app_forecast_month').val(data.forecast_month);
            $('#app_site_code').val(data.site_code);
            $('#app_prod_code').val(data.prod_code);
            $('#app_uom_code').val(data.uom_code);
            $('#app_currency_code').val(curr_name);
            $('#app_unit_price').val(dataUpx);
            $('#app_quantity').val(data.quantity);
            $('#app_total_price').val(data.total_price);

            $('#appModal').modal('open');
            
        });
    }

    var procedures = $('#procedures-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/procedures",
        "columns": [
            {  "data": "id" },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="procedure/view/'+row.id+'">'+ row.document_no +'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.revision_no;
                }
            },
            {   "data": "status",
                "render": function ( data, type, row, meta ) {
                  switch(data){
                    case 'Approved':
                      return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                    break;
                    case 'Pending':
                      return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                    break;
                    case 'Created':
                      return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                    break;
                    case 'Rejected':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                    case 'For Approval':
                      return  '<span class="new badge yellow white-text" data-badge-caption="">For Approval</span>';
                    break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                    break;
                    case 'Voided':
                      return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                    break;
                    case 'Quoted':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Quoted</span>';
                    break;
                    case 'Ordered':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Ordered</span>';
                    break;
                    // case 'Created':
                    //   return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                    // break;
                  }
                   
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  
                  if(row.status=='Approved')
                  {
                    return  '<a href="procedure/revise/'+row.id+'" class="btn-small amber darken3 waves-effect waves-dark"><i class="material-icons">create</i></a>';
                  } else {
                    return  '<a href="#!" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a>';
                  }

                }
            }
                 
        ]
    });
     
    @if($permission[0]["approval"]==true)
    var approvaldt = $('#approval-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/approval",
        "columns": [
            {  "data": "id" },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="procedure/view/'+row.id+'">'+ row.document_no +'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.revision_no;
                }
            },
            {   "data": "status",
                "render": function ( data, type, row, meta ) {
                  switch(data){
                    case 'Approved':
                      return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                    break;
                    case 'Pending':
                      return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                    break;
                    case 'Created':
                      return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                    break;
                    case 'Rejected':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                    case 'For Approval':
                      return  '<span class="new badge yellow white-text" data-badge-caption="">For Approval</span>';
                    break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                    break;
                    case 'Voided':
                      return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                    break;
                    case 'Quoted':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Quoted</span>';
                    break;
                    case 'Ordered':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Ordered</span>';
                    break;
                  }
                   
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return  '<a href="procedure/approval/'+row.id+'" class="btn-small blue darken3 waves-effect waves-dark"><i class="material-icons">rate_review</i></a>';
                }
            }
        ]
    });
    @endif

    @if($permission[0]["masterlist"]==true)
    var masterdt = $('#master-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/master",
        "columns": [
            {  "data": "id" },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="procedure/view/'+row.id+'">'+ row.document_no +'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.revision_no;
                }
            },
            {   "data": "status",
                "render": function ( data, type, row, meta ) {
                  switch(data){
                    case 'Approved':
                      return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                    break;
                    case 'Pending':
                      return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                    break;
                    case 'Created':
                      return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                    break;
                    case 'Rejected':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                    case 'For Approval':
                      return  '<span class="new badge yellow white-text" data-badge-caption="">For Approval</span>';
                    break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                    break;
                    case 'Voided':
                      return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                    break;
                    case 'Quoted':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Quoted</span>';
                    break;
                    case 'Ordered':
                      return  '<span class="new badge blue darken-4 white-text" data-badge-caption="">Ordered</span>';
                    break;
 
                  }
                   
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  if(row.status=='Approved')
                  {
                    return  '<a href="procedure/master/'+row.id+'" class="btn-small blue darken3 waves-effect waves-dark"><i class="small material-icons">note_add</i></a>';
                  }else{
                    return  '<a href="#!" class="btn-small blue darken3 waves-effect waves-dark" disabled><i class="small material-icons">note_add</i></a>';
                  }
                }
            }
        ]
    });

    var controlled = $('#controlled-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/controlled",
        "columns": [
            {  "data": "id" },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.procedures.dpr_code;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.document_title;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="procedure/view/'+row.procedures.id+'">'+ row.document_no +'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.revision_no;
                }
            },
            {   "data": "status",
                "render": function ( data, type, row, meta ) {
                  switch(data){
                    case 'Created':
                      return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                    break;
                  
                    case 'For CC':
                      return  '<span class="new badge blue white-text" data-badge-caption="">For CC</span>';
                    break;
                   
                  }
                   
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  if(row.status=='For CC')
                  {
                    return  '<a href="procedure/copy/'+row.procedures.id+'" class="btn-small blue darken3 waves-effect waves-dark"><i class="small material-icons">note_add</i></a>';
                  }else{
                    return  '<a href="#!" class="btn-small blue darken3 waves-effect waves-dark" disabled><i class="small material-icons">note_add</i></a>';
                  }
                }
            }
        ]
    });
    @endif

  </script>

  <!-- End of SCRIPTS -->

@endsection
