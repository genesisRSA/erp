@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Master Data<i class="material-icons">arrow_forward_ios</i></span> Item Sub-Categories</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="itemsubcategory-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Item Category</th>
                  <th>Sub-Category Code</th>
                  <th>Description</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Sub-Category"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('item_subcategory.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Item Sub-Category</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m4">
            <select id="add_cat_code" name="cat_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($itemcode as $i)
                <option value="{{$i->cat_code}}">{{$i->cat_desc}}</option>
              @endforeach
            </select>
            <label>Item Category<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="PBIX-80-LM" name="subcat_code" type="text" class="validate" required>
            <label for="subcat_code">Item Sub-Category Code<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="PBIX-80-LM Low Magnification" name="subcat_desc" type="text" class="validate" required>
            <label for="subcat_desc">Description<sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('item_subcategory.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Item Category</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m4">
            <select id="edit_cat_code" name="cat_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($itemcode as $i)
                <option value="{{$i->cat_code}}">{{$i->cat_desc}}</option>
              @endforeach
            </select>
            <label>Item Category<sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input type="hidden" name="id" id="edit_id">
            <input placeholder="3rd Optical Inspection" name="subcat_code" id="edit_subcat_code" type="text" class="validate" required>
            <label for="subcat_code">Item Category Code <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m4">
            <input placeholder="3RDOP" name="subcat_desc" id="edit_subcat_desc" type="text" class="validate" required>
            <label for="subcat_desc">Description <sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('item_subcategory.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Item Category</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Item Category</strong>?</p>
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
        $.get('item_subcategory/'+id, function(response){
            var data = response.data;
            $('#edit_id').val(data.id);
            $('#edit_cat_code option[value="'+data.cat_code+'"]').prop('selected', true);
            $('#edit_cat_code').formSelect();
            $('#edit_subcat_code').val(data.subcat_code);
            $('#edit_subcat_desc').val(data.subcat_desc);
            $('#editModal').modal('open');
        });
    }

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var category_dt = $('#itemsubcategory-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/item_subcategory/all",
        "columns": [
            {  "data": "id" },
            {  "data": "item_cat.cat_desc" },
            {  "data": "subcat_code" },
            {  "data": "subcat_desc" },
            
            {
                "data": "system_generated",
                "render": function ( data, type, row, meta ) {
                    if (data=='0') {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+row.id+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
                    } else {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" disabled><i class="material-icons">delete</i></a>';
                    }
                }
            }
        ] 
    });
  </script>

  <!-- End of SCRIPTS -->

@endsection
