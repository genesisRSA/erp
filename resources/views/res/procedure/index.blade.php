@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Document Control Centre<i class="material-icons">arrow_forward_ios</i></span>Procedures</h4>
    </div>
  </div>
  <div class="row main-content">
  
    <ul id="procedures_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#ongoing">Procedures</a></li>
      @if($permission[0]["approval"]==true)
      <li class="tab col s12 m4 l4"><a href="#approval">For Approval</a></li>
      @endif
      @if($permission[0]["masterlist"]==true)
      <li class="tab col s12 m4 l4"><a href="#master">Master Copy</a></li>
      @endif
      <li class="tab col s12 m4 l4"><a href="#controlled">Controlled Copy</a></li>
     
    </ul>

    <div id="ongoing" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="procedures-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Document No.</th>
                    <th>Document Title</th>
                    <th>DPR No.</th>
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
                    <th>Document No.</th>
                    <th>Date Requested</th>
                    <th>Requested By</th>
                    <th>Document Title</th>
                    <th>DPR No.</th>
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
                  <th>Document No.</th>
                  <th>Date Requested</th>
                  <th>Requested By</th>
                  <th>Document Title</th>
                  <th>DPR No.</th>
                  <th>Revision No.</th>
                  <th>Status</th>
                  @if($permission[0]["masterlist"]==true)
                  <th>Action</th>
                  @endif
                </tr>
              </thead>
            </table>
          </div>
        </div>
    </div>
    @endif  
    
    <div id="controlled" name="controlled">
      <div class="card" style="margin-top: 0px">
       @if($permission[0]["masterlist"]==true)
          <div class="col s12 m12 l12">
            <h6 style="padding: 10px; padding-top: 20px; padding-left: 20px; padding-right: 20px;   margin-top: 5px; background-color:#0d47a1" class="white-text"><b>For Control Copy</b></h6>  
          </div>
          <div class="card-content">
            <table class="responsive-table highlight" id="controlled-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Document No.</th>
                    <th>Date Requested</th>
                    <th>Requested By</th>
                    <th>Document Title</th>
                    <th>DPR No.</th>
                    <th>Revision No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="col s12 m12 l12">
            <h6 style="padding: 10px; padding-top: 20px; padding-left: 20px; padding-right: 20px;   margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Created Copies</b></h6>  
          </div>
        @endif

        <div class="card-content">
          <table class="responsive-table highlight" id="created-dt" style="width: 100%">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Document No.</th>     
                  <th>Created By</th>
                  <th>Copy Owner</th>
                  <th>Document Title</th>
                  <th>DPR No.</th>
                  <th>Copy No.</th>
                  <th>Status</th>
                  @if($permission[0]["masterlist"]==true)
                  <th>Action</th>
                  @endif
              </tr>
            </thead>
          </table>
        </div>

      </div>
      
    </div>

  </div>

  <!-- MODALS -->

  <div id="ccModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('procedure.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Controlled Copy</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="cc_id">
                    <p>Are you sure you want to delete this <strong>Procedure Controlled Copy</strong>?</p>
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
 
    });
 

    function deleteCC(id)
    {
      $('#cc_id').val(id);
      $('#ccModal').modal('open');
    }

      var procedures = $('#procedures-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/procedures",
          "columns": [
              {  "data": "id" },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view/'+data+'/procedures">'+ row.document_no +'</a>';
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.document_title;
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.dpr_code;
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
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                      break;
                      case 'Rejected':
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                      break;
                    }
                    
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    
                    if(row.status=='Created')
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
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view/'+row.id+'/app">'+ row.document_no +'</a>';
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.requested_date;
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.document_title;
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.dpr_code;
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
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                      break;
                      case 'Rejected':
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                      break;
                    }
                    
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    if(row.status=='Pending')
                    {
                      return  '<a href="procedure/approval/'+row.id+'/app" class="btn-small blue darken3 waves-effect waves-dark"><i class="material-icons">rate_review</i></a>';
                    } else {
                      return  '<a href="#!" class="btn-small blue darken3 waves-effect waves-dark" disabled><i class="material-icons">rate_review</i></a>';
                    }

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
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view/'+row.id+'/master">'+ row.document_no +'</a>';
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.requested_date;
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.document_title;
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.dpr_code;
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
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                      break;
                      case 'Rejected':
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                      break;
                    }
                    
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    if(row.status=='Approved')
                    {
                      return  '<a href="procedure/master/'+row.id+'/master" class="btn-small blue darken3 waves-effect waves-dark"><i class="small material-icons">note_add</i></a>';
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
          "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/forCC",
          "columns": [
              {  "data": "id" },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view_fcc/'+row.id+'/controlled">'+ row.document_no +'</a>';
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.created_at.substring(0,10);
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.document_title;
                  }
              },
          
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view_fcc/'+row.id+'/controlled">'+ row.dpr_code +'</a>';
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
                      case 'For CC':
                        return  '<span class="new badge blue white-text" data-badge-caption="">For CC</span>';
                      break;
                      case 'Approved':
                        return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                      break;
                      case 'Pending':
                        return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                      break;
                      case 'Created':
                        return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                      break;
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                      break;
                      case 'Rejected':
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                      break;
                    }
                    
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    if(row.status=='For CC'||row.status=='Created')
                    {
                      return  '<a href="procedure/copy/'+row.id+'/controlled" class="btn-small blue darken3 waves-effect waves-dark"><i class="small material-icons">note_add</i></a>';
                    }else{
                      return  '<a href="#!" class="btn-small blue darken3 waves-effect waves-dark" disabled><i class="small material-icons">note_add</i></a>';
                    }
                  }
              }
          ]
      });
    @endif

      var controlled = $('#created-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/procedure/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}/cc",
          "columns": [
              {  "data": "id" },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view_cc/'+row.id+'/cc">'+ row.document_no +'</a>';
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.employee_details.full_name;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.dept_details.dept_desc;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.document_title;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return '<a href="procedure/view_cc/'+row.id+'/cc">'+ row.dpr_code +'</a>';
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.copy_no;
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
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
                      break;
                      case 'Rejected':
                        return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                      break;
                    }
                    
                  }
              },
              @if($permission[0]["masterlist"]==true)
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return  '<a href="#!" onclick="deleteCC('+data+')" class="btn-small red darken3 waves-effect waves-dark"><i class="small material-icons">delete_forever</i></a> ';
                  }
              }
              @endif
          ]
      });
    

  </script>

  <!-- End of SCRIPTS -->

@endsection
