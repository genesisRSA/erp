@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parameters <i class="material-icons">arrow_forward_ios</i></span> Units Conversion</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="uom_conversion_dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Type</th>
                  <th>Name</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#!" onclick="addModal();" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Unit Conversion"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('uom_conversion.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Unit Conversion</h4><br>
        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6">
            <select id="add_uom_cnv_type" name="uom_cnv_type" required>
              <option value="" selected disabled>Choose your option</option>
              <option value="Area">Area</option>
              <option value="Length">Length</option>
              <option value="Weight">Weight</option>
              <option value="Volume">Volume</option>
            </select>
            <label for="uom_cnv_type">Conversion Type<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6">
            <input placeholder=" " id="add_uom_cnv_name" name="uom_cnv_name" type="text" required readonly>
            <label for="uom_cnv_name">Conversion Name<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6">
            <select id="add_uom_from" name="uom_from" required>
              <option value="" selected disabled>Choose your option</option>
            </select>
            <label for="uom_from">From<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="" id="add_uom_from_value" name="uom_from_value" type="number" step="0.00000001" value="1" required readonly>
            <label for="uom_from_value">Value<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6">
            <select id="add_uom_to" name="uom_to" required>
              <option value="" selected disabled>Choose your option</option>
            </select>
            <label for="uom_to">To<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="" id="add_uom_to_value" name="uom_to_value" type="number" required>
            <label for="uom_to_value">Value<sup class="red-text">*</sup></label>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button id="btnAdd_Save" class="green waves-effect waves-light btn" disabled><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left" style="margin-right: 30px;">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('uom_conversion.patch')}}">
    @csrf
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Edit Unit Conversion</h4><br>
      <div class="row" style="margin-bottom: 0px;">
        <input type="hidden" id="edit_id" name="id">
        <div class="input-field col s12 m6">
          <select id="edit_uom_cnv_type" name="uom_cnv_type" required>
            <option value="" selected disabled>Choose your option</option>
            <option value="Area">Area</option>
            <option value="Length">Length</option>
            <option value="Weight">Weight</option>
            <option value="Volume">Volume</option>
          </select>
          <label for="uom_cnv_type">Conversion Type<sup class="red-text">*</sup></label>
        </div>

        <div class="input-field col s12 m6">
          <input placeholder="e.g Meter to Kilometer" id="edit_uom_cnv_name" name="uom_cnv_name" type="text" required>
          <label for="uom_cnv_name">Conversion Name<sup class="red-text">*</sup></label>
        </div>
      </div>

      <div class="row" style="margin-bottom: 0px;">
        <div class="input-field col s12 m6">
          <select id="edit_uom_from" name="uom_from" required>
            <option value="" selected disabled>Choose your option</option>
          </select>
          <label for="uom_from">From<sup class="red-text">*</sup></label>
        </div>
        <div class="input-field col s12 m6">
          <input placeholder="" id="edit_uom_from_value" name="uom_from_value" type="number" value="1" required readonly>
          <label for="uom_from_value">Value<sup class="red-text">*</sup></label>
        </div>
      </div>

      <div class="row" style="margin-bottom: 0px;">
        <div class="input-field col s12 m6">
          <select id="edit_uom_to" name="uom_to" required>
            <option value="" selected disabled>Choose your option</option>
          </select>
          <label for="uom_to">To<sup class="red-text">*</sup></label>
        </div>
        <div class="input-field col s12 m6">
          <input placeholder="" id="edit_uom_to_value" name="uom_to_value" type="number" step="0.00000001"  required>
          <label for="uom_to_value">Value<sup class="red-text">*</sup></label>
        </div>
      </div>

    </div>
    <div class="modal-footer">
      <button id="btnEdit_Save" class="green waves-effect waves-light btn" disabled><i class="material-icons left">check_circle</i>Save</button>
      <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left" style="margin-right: 30px;">cancel</i>Cancel</a>
    </div>
    </form>
  </div>

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('uom_conversion.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Unit Conversion</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Unit Conversion</strong>?</p>
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
  
    $(document).ready(function () {
      $('#add_uom_cnv_type').on('change', function(){
        $.get('uom_conversion/uoms_per_type/'+$(this).val(), (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose your option</option>';
          $.each(data, (index,row) => {
              select += '<option value="'+row.uom_code+'">'+row.uom_name+'</option>';
          });
          $('#add_uom_from').html(select);
          $('#add_uom_from').formSelect();
          $('#add_uom_to').html(select);
          $('#add_uom_to').formSelect();
        });
      });

      $('#add_uom_from').on('change', function(){
        var from_text = $('#add_uom_from option:selected').text();
        var to_text = $('#add_uom_to option:selected').text();

        var from = $(this).val() ? from_text : ""; 
        var to = $('#add_uom_to').val() ? to_text : "";
        
        $('#add_uom_cnv_name').val(from + " to " + to);
      });

      $('#add_uom_to').on('change', function(){
        var from_text = $('#add_uom_from option:selected').text();
        var to_text = $('#add_uom_to option:selected').text();

        var from = $('#add_uom_from').val() ? from_text : ""; 
        var to = $(this).val() ? to_text : "";
        $('#add_uom_cnv_name').val(from + " to " + to);
      });

      $('#add_uom_to_value').on('blur', function(){
          if(parseFloat($(this).val()) > 0){ 
              $('#btnAdd_Save').prop('disabled', false);
          } else {
            if($(this).val()){
              alert('Conversion quantity must be greater than zero!');
              $('#btnAdd_Save').prop('disabled', true);
              $(this).val("");
            }
          }
      });


      $('#edit_uom_cnv_type').on('change', function(){
        $.get('uom_conversion/uoms_per_type/'+$(this).val(), (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose your option</option>';
          $.each(data, (index,row) => {
              select += '<option value="'+row.uom_code+'">'+row.uom_name+'</option>';
          });
          $('#edit_uom_from').html(select);
          $('#edit_uom_from').formSelect();
          $('#edit_uom_to').html(select);
          $('#edit_uom_to').formSelect();
        });
      });

      $('#edit_uom_from').on('change', function(){
        var from_text = $('#edit_uom_from option:selected').text();
        var to_text = $('#edit_uom_to option:selected').text();

        var from = $(this).val() ? from_text : ""; 
        var to = $('#edit_uom_to').val() ? to_text : "";
        
        $('#edit_uom_cnv_name').val(from + " to " + to);
      });

      $('#edit_uom_to').on('change', function(){
        var from_text = $('#edit_uom_from option:selected').text();
        var to_text = $('#edit_uom_to option:selected').text();

        var from = $('#edit_uom_from').val() ? from_text : ""; 
        var to = $(this).val() ? to_text : "";
        $('#edit_uom_cnv_name').val(from + " to " + to);
      });

      $('#edit_uom_to_value').on('blur', function(){
          if(parseFloat($(this).val()) > 0){ 
            $('#btnEdit_Save').prop('disabled', false);
          } else {
            if($(this).val()){
              alert('Conversion quantity must be greater than zero!');
              $('#btnEdit_Save').prop('disabled', true);
              $(this).val("");
            }
          }
      });

    });

    function editItem(id){
      $.get('uom_conversion/'+id, function(response){
        var data = response.data;
        $('#edit_id').val(data.id);
        loadUOMs(data.uom_cnv_type, data.uom_from, data.uom_to);

        $('#edit_uom_cnv_name').val(data.uom_cnv_name);
        $('#edit_uom_from_value').val(data.uom_from_value);
        $('#edit_uom_to_value').val(data.uom_to_value);
        $('#edit_uom_cnv_type option[value="'+data.uom_cnv_type+'"]').prop('selected', true);
        $('#edit_uom_cnv_type').formSelect();

        $('#editModal').modal('open');
      });
    }

    function deleteItem(id){
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
    }

    const loadUOMs = (uom_type, uom_from, uom_to) => {
      $.get('uom_conversion/uoms_per_type/'+uom_type, (response) => {
        var data = response.data;
        var select = '<option value="" disabled selected>Choose your option</option>';
        $.each(data, (index,row) => {
            select += '<option value="'+row.uom_code+'">'+row.uom_name+'</option>';
        });
        $('#edit_uom_from').html(select);
        $('#edit_uom_from').formSelect();
        $('#edit_uom_from option[value="'+uom_from+'"]').prop('selected', true);
        $('#edit_uom_from').formSelect();

        $('#edit_uom_to').html(select);
        $('#edit_uom_to').formSelect();
        $('#edit_uom_to option[value="'+uom_to+'"]').prop('selected', true);
        $('#edit_uom_to').formSelect();

      });
    };

    const addModal = () => {
      $('#add_uom_cnv_type option[value=""]').prop('selected', true);
      $('#add_uom_cnv_type').formSelect();

      $('#add_uom_from option[value=""]').prop('selected', true);
      $('#add_uom_from').formSelect();

      $('#add_uom_to option[value=""]').prop('selected', true);
      $('#add_uom_to').formSelect();

      $('#add_uom_cnv_name').val("");
      $('#add_uom_to_value').val("");

      $('#addModal').modal('open');
    };

    var uom_dt = $('#uom_conversion_dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/uom_conversion/all",
        "columns": [
            {  "data": "id" },
            {  "data": "uom_cnv_type" },
            {  "data": "uom_cnv_name" },
            {  "data": "uom_from" },
            {  "data": "uom_to" },
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
