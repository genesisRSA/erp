@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Master Data<i class="material-icons">arrow_forward_ios</i></span> Fabrication List</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="fabrication-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Assembly</th>
                  <th>Fabrication Code</th>
                  <th>Fabrication Description</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Fabrication Details"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('fabrication.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Fabrication Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m4">
            <select id="add_assy_code" name="assy_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($assycode as $i)
                <option value="{{$i->assy_code}}">{{$i->assy_desc}}</option>
              @endforeach
            </select>
            <label for="assy_code">Assembly<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="" name="fab_code" type="text" class="validate" required>
            <label for="fab_code">Fabrication Code<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="" name="fab_desc" type="text" class="validate" required>
            <label for="fab_desc">Fabrication Description<sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_length" type="text" class="number validate" required>
            <label for="fab_length">Length<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_width" type="text" class="number validate" required>
            <label for="fab_width">Width<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_thickness" type="text" class="number validate" required>
            <label for="fab_thickness">Thickness<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_radius" type="text" class="number validate" required>
            <label for="fab_radius">Radius<sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('fabrication.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Fabrication Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m3">
            <input type="hidden" name="id" id="edit_id">
            <select id="edit_assy_code" name="assy_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($assycode as $i)
                <option value="{{$i->assy_code}}">{{$i->assy_desc}}</option>
              @endforeach
            </select>
            <label for="assy_code">Assembly<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_code" id="edit_fab_code" type="text" class="validate grey lighten-3" readonly>
            <label for="fab_code">Fabrication Code</label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_desc" id="edit_fab_desc" type="text" class="validate" required>
            <label for="fab_desc">Assembly Description<sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_length" id="edit_fab_length" type="text" class="number validate">
            <label for="fab_length">Length<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_width" id="edit_fab_width" type="text" class="number validate">
            <label for="fab_width">Width<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_thickness" id="edit_fab_thickness" type="text" class="number validate">
            <label for="fab_thickness">Thickness<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m3">
            <input placeholder="" name="fab_radius" id="edit_fab_radius" type="text" class="number validate">
            <label for="fab_radius">Radius<sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('fabrication.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Fabrication Details</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Fabrication Details</strong>?</p>
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
        $.get('fabrication/'+id, function(response){
            var data = response.data;
            $('#edit_id').val(data.id);
            $('#edit_assy_code option[value="'+data.assy_code+'"]').prop('selected', true);
            $('#edit_assy_code').formSelect();
            $('#edit_fab_code').val(data.fab_code);
            $('#edit_fab_desc').val(data.fab_desc);
            $('#edit_fab_length').val(data.length);
            $('#edit_fab_width').val(data.width);
            $('#edit_fab_thickness').val(data.thickness);
            $('#edit_fab_radius').val(data.radius);
            $('#editModal').modal('open');
        });
    }

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    $('.number').on('keypress', function(evt){
      var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;

        return true;
    })
 

    var category_dt = $('#fabrication-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/fabrication/all",
        "columns": [
            {  "data": "id" },
            {  "data": "assy.assy_desc" },
            {  "data": "fab_code" },
            {  "data": "fab_desc" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+row.id+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
                }
            }
        ] 
    });
  </script>

  <!-- End of SCRIPTS -->

@endsection
