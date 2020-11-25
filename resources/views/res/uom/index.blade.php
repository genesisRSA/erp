@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parameters <i class="material-icons">arrow_forward_ios</i></span> Units</h4>
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
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Unit"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('uom.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Unit</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="e.g Meter, Kilogram" name="uom_name" type="text" class="validate" required>
            <label for="uom_name">UOM Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="e.g m, kg" name="uom_code" type="text" class="validate" required>
            <label for="uom_code">UOM Code <sup class="red-text">*</sup></label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="green-text waves-effect waves-green btn-flat">Save</button>
        <a href="#!" class="modal-close red-text waves-effect waves-red btn-flat">Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('uom.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Unit</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input type="hidden" name="id" id="edit_id">
            <input placeholder="e.g Meter, Kilogram" name="uom_name" id="edit_uom_name" type="text" class="validate" required>
            <label for="uom_name">UOM Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="e.g m, kg" name="uom_code" id="edit_uom_code" type="text" class="validate" required>
            <label for="uom_code">UOM Code <sup class="red-text">*</sup></label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="green-text waves-effect waves-green btn-flat">Update</button>
        <a href="#!" class="modal-close red-text waves-effect waves-red btn-flat">Cancel</a>
      </div>
    </form>
  </div>

  <!-- End of MODALS -->

  <!-- SCRIPTS -->
  
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    function editItem(id){
      $.get('uom/'+id, function(response){
        var data = response.data;
        $('#edit_id').val(data.id);
        $('#edit_uom_code').val(data.uom_code);
        $('#edit_uom_name').val(data.uom_name);
        $('#editModal').modal('open');
      });
    }

    var uom_dt = $('#uom-dt').DataTable({
        "lengthChange": false,
        "pageLength": 50,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/rgc_entsys/uom/all",
        "columns": [
            {  "data": "id" },
            {  "data": "uom_name" },
            {  "data": "uom_code" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+data+')">Edit</a> <a href="#" class="btn-small red waves-effect waves-light">Delete</a>';
                }
            }
        ] 
    });
  </script>

  <!-- End of SCRIPTS -->

@endsection
