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
                  <th>Type</th>
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
        <h4>Add Unit</h4><br>
        <div class="row">
          <div class="input-field col s12 m6 l6">
            <select id="add_uom_type" name="uom_type">
              <option value="" selected disabled>Choose your option</option>
              <option value="Area">Area</option>
              <option value="Length">Length</option>
              <option value="Weight">Weight</option>
              <option value="Volume">Volume</option>
            </select>
            <label for="uom_type">UOM Type <sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m6 l6">
            <input placeholder="e.g Meter, Kilogram" name="uom_name" type="text" class="validate" required>
            <label for="uom_name">UOM Name <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6 l6">
            <input placeholder="e.g m, kg" name="uom_code" type="text" class="validate" required>
            <label for="uom_code">UOM Code <sup class="red-text">*</sup></label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
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
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Update</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('uom.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Unit</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Unit</strong>?</p>
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

    function deleteItem(id){
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
    }

    var uom_dt = $('#uom-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/uom/all",
        "columns": [
            {  "data": "id" },
            {  "data": "uom_type" },
            {  "data": "uom_name" },
            {  "data": "uom_code" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+data+')"><i class="material-icons">delete</i></a>';
                }
            }
        ] 
    });

  </script>

  <!-- End of SCRIPTS -->

@endsection
