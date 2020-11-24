@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h3 class="title">Units</h3>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="uom-dt">
            <thead>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Action</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>1</td>
                <td>Meters</td>
                <td>m</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div id="addModal" class="modal">
    <form method="POST">
    @csrf
      <div class="modal-content">
        <h4>Add Unit</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="e.g Meter/s, Kilogram/s" name="uom_name" type="text" class="validate">
            <label for="uom_name">UOM Name</label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="e.g m(s), kg(s)" name="uom_name" type="text" class="validate">
            <label for="uom_name">UOM Desc</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-close green-text waves-effect waves-green btn-flat">Save</button>
        <a href="#!" class="modal-close red-text waves-effect waves-red btn-flat">Cancel</a>
      </div>
    </form>
  </div>


  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Unit"><i class="material-icons">add</i></a>

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
