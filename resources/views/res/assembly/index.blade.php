@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Master Data<i class="material-icons">arrow_forward_ios</i></span> Assembly List</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="assembly-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Product</th>
                  <th>Assembly Code</th>
                  <th>Assembly Description</th>
                  <th>Parent Assembly Code</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Assembly Details"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('assembly.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Assembly Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <select id="add_prod_code" name="prod_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($products as $i)
                <option value="{{$i->prod_code}}">{{$i->prod_name}}</option>
              @endforeach
            </select>
            <label for="prod_code">Product<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="" name="assy_code" type="text" class="validate" required>
            <label for="assy_code">Assembly Code<sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="" name="assy_desc" type="text" class="validate" required>
            <label for="assy_desc">Assembly Description<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <select name="parent_assy_code">
              <option value="" disabled selected>Choose your option</option>
              @foreach ($assycode as $i)
                <option value="{{$i->assy_code}}">{{$i->assy_desc}}</option>
              @endforeach
            </select>
            <label for="parent_assy_code">Parent Assembly<sup class="red-text"></sup></label>
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
    <form method="POST" action="{{route('assembly.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Assembly Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input type="hidden" name="id" id="edit_id">
            <select id="edit_prod_code" name="prod_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($products as $i)
                <option value="{{$i->prod_code}}">{{$i->prod_name}}</option>
              @endforeach
            </select>
            <label for="prod_code">Product<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <input placeholder="" name="assy_code" id="edit_assy_code" type="text" class="validate grey lighten-3" readonly>
            <label for="assy_code">Assembly Code<sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m6">
            <input placeholder="" name="assy_desc" id="edit_assy_desc" type="text" class="validate" required>
            <label for="assy_desc">Assembly Description<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m6">
            <select name="parent_assy_code" id="edit_parent_assy_code">
              <option value="" disabled selected>Choose your option</option>
              @foreach ($assycode as $i)
                <option value="{{$i->assy_code}}">{{$i->assy_desc}}</option>
              @endforeach
            </select>
            <label for="parent_assy_code">Parent Assembly<sup class="red-text"></sup></label>
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
    <form method="POST" action="{{route('assembly.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Assembly Details</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Assembly Details</strong>?</p>
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
        $.get('assembly/'+id, function(response){
            var data = response.data;
            var parent_select = response.parent_selection;
            console.log(JSON.stringify(parent_select));
            $('#edit_id').val(data.id);
            $('#edit_prod_code option[value="'+data.prod_code+'"]').prop('selected', true);
            $('#edit_prod_code').formSelect();
            $('#edit_assy_code').val(data.assy_code);
            $('#edit_assy_desc').val(data.assy_desc);

            $('#edit_parent_assy_code').html("");

            $('#edit_parent_assy_code').append('<option value="" disabled selected>Choose your option</option>');
            $.each(parent_select,function(i,row){
              console.log(row.assy_code);
              $('#edit_parent_assy_code').append('<option value="'+row.assy_code+'">'+row.assy_desc+'</option>');
            });

            $('#edit_parent_assy_code option[value="'+data.parent_assy_code+'"]').prop('selected', true);

            // if(data.assy_code==data.parent_assy_code){
            //    $('#edit_parent_assy_code').find('option').val(data.parent_assy_code).remove();
            // } 
      
            $('#edit_parent_assy_code').formSelect();
            $('#editModal').modal('open');
        });
    }

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var category_dt = $('#assembly-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/assembly/all",
        "columns": [
            {  "data": "id" },
            {  "data": "prod.prod_name" },
            {  "data": "assy_code" },
            {  "data": "assy_desc" },
            {  "data": "parent_assy_code" },
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
