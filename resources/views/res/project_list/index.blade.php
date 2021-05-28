@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Projects<i class="material-icons">arrow_forward_ios</i></span>Project List</h4>
    </div>
  </div>
  <div class="row main-content">
    <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab col s12 m4 l4"><a class="active" href="#ongoing">Projects</a></li>
    </ul>

    <div id="ongoing" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="projects-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Project Code</th>
                    <th>Project Name</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="{{ route('projects.create') }}" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Project"><i class="material-icons">add</i></a>
      @endif
    </div>

  </div>

  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script> 
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">
    var projects = $('#projects-dt').DataTable({
          "lengthChange": false,
          "pageLength": 15,
          "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
          "pagingType": "full",
          "ajax": "/api/reiss/projects/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
          "columns": [
              // {  "data": "id" },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.order_code;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    @if($permission[0]["view"]==true)
                    return '<a href="projects/view/'+data+'">'+ row.project_code +'</a>';
                    @else
                    return row.project_code;
                    @endif
                  }
              },
              {  "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.project_name;
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    return row.customers.cust_name;
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
                      case 'Received':
                        return  '<span class="new badge deep-orange lighten-1 white-text" data-badge-caption="">Received</span>';
                      break;
                      case 'Created':
                        return  '<span class="new badge green white-text" data-badge-caption="">Created</span>';
                      break;
                      case 'On Going':
                        return  '<span class="new badge deep-purple darken-1 white-text" data-badge-caption="">On Going</span>';
                      break;
                      case 'Oriented':
                        return  '<span class="new badge green darken-1 white-text" data-badge-caption="">Oriented</span>';
                      break;
                      case 'Obsolete':
                        return  '<span class="new badge black white-text" data-badge-caption="">Obsolete</span>';
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
                    }
                    
                  }
              },
              {   "data": "id",
                  "render": function ( data, type, row, meta ) {
                    @if($permission[0]["view"]==true)
                    return  '<a href="projects/edit/'+data+'" class="btn-small amber darken3 waves-effect waves-dark"><i class="material-icons">create</i></a>';
                    @else
                    return  '<a href="#!" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a>';
                    @endif
                  }
              }
                  
          ]
    });
  </script>

@endsection