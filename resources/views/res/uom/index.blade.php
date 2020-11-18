@extends('layouts.resmain')

@section('content')
  <div class="row" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h3 class="title">Units</h3>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <table id="uom-dt">
        <thead>
          <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Code</th>
              <th>Action</th>
          </tr>
        </thead>

        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
  <a href="test" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Unit"><i class="material-icons">add</i></a>

  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">
        var uom_dt = $('#uom-dt').DataTable({
            "responsive": true,
            "lengthChange": false,
            "pageLength": 50,
            //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
            "pagingType": "full",
            "ajax": "/api/rgc_entsys/uom/all",
            "columns": [
                {  "data": "uom_id" },
                {  "data": "uom_name" },
                {  "data": "uom_code" },
                {
                    "targets": 0,
                    "data": "uom_id",
                    "render": function ( data, type, row, meta ) {
                        return  '<a href="employeeshift/'+data+'" class="btn"><i class="fas fa-eye"></i> View</a>';
                    }
                }
            ] 
        });
  </script>

@endsection
