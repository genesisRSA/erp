@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Products <i class="material-icons">arrow_forward_ios</i></span> Product List</h4>
    </div>
  </div>
  <div class="row main-content">
    <div class="col s12 m12 l12">
      <div class="card">
        <div class="card-content">
          <table class="highlight" id="product-dt">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Site</th>
                  <th>Product Category</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>Type</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Category"><i class="material-icons">add</i></a>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('product.store')}}">
    @csrf
      <div class="modal-content">
        <h4>Add Product Details</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m4">
             <select name="site_code" required>
                  <option value="" disabled selected>Choose your option</option>
              @foreach ($sitecode as $s)
                  <option value="{{$s->site_code}}">{{$s->site_desc}}</option>
              @endforeach
             </select>
            <label for="site_code">Site<sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4">
                <select name="prodcat_id" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($prodcat as $p)
                        <option value="{{$p->id}}">{{$p->prodcat_name}}</option>
                    @endforeach
                </select>
                <label>Product Category <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m6">
                <input placeholder="e.g PBIX-80-LM Low Magnification" name="prod_name" type="text" class="validate" required>
                <label for="prod_name">Name <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m2">
                <input placeholder="e.g PBIX-80-LM" name="prod_code" type="text" class="validate" required>
                <label for="prod_code">Code <sup class="red-text">*</sup></label>
            </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m4">
              <select name="prod_type" required>
                  <option value="" disabled selected>Choose your option</option>
                  <option value="Accessories">Accessories</option>
                  <option value="Service">Service</option>
                  <option value="Unit">Unit</option>
              </select>
              <label>Type <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m8">
            <textarea id="prod_writeup" name="prod_writeup" class="materialize-textarea" required></textarea>
            <label for="prod_writeup">Specification Write-Up <sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('product.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Product Category</h4><br><br>
        <div class="row">
          <div class="input-field col s12 m4">
             <select name="site_code" id="edit_site_code" required>
                  <option value="" disabled selected>Choose your option</option>
              @foreach ($sitecode as $s)
                  <option value="{{$s->site_code}}">{{$s->site_desc}}</option>
              @endforeach
             </select>
            <label for="site_code">Site<sup class="red-text">*</sup></label>
          </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4">
                <input type="hidden" name="id" id="edit_id">
                <select name="prodcat_id" id="edit_prodcat_id" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($prodcat as $p)
                        <option value="{{$p->id}}">{{$p->prodcat_name}}</option>
                    @endforeach
                </select>
                <label>Product Category <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m6">
                <input placeholder="e.g PBIX-80-LM Low Magnification" name="prod_name" id="edit_prod_name" type="text" class="validate" required>
                <label for="prod_name">Name <sup class="red-text">*</sup></label>
            </div>
            <div class="input-field col s12 m2">
                <input placeholder="e.g PBIX-80-LM" name="prod_code" id="edit_prod_code" type="text" class="validate" required>
                <label for="prod_code">Code <sup class="red-text">*</sup></label>
            </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m4">
              <select name="prod_type" id="edit_prod_type" required>
                  <option value="" disabled selected>Choose your option</option>
                  <option value="Accessories">Accessories</option>
                  <option value="Service">Service</option>
                  <option value="Unit">Unit</option>
              </select>
              <label>Type <sup class="red-text">*</sup></label>
          </div>
          <div class="input-field col s12 m8">
            <textarea id="edit_prod_writeup" name="prod_writeup" class="materialize-textarea" required></textarea>
            <label for="prod_writeup">Specification Write-Up <sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('product.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Product</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Product</strong>?</p>
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
        $.get('product/'+id, function(response){
            var data = response.data;
            $('#edit_id').val(data.id);
            $('#edit_site_code option[value="'+data.site_code+'"]').prop('selected', true);
            $('#edit_site_code').formSelect();
            $('#edit_prodcat_id option[value="'+data.prodcat_id+'"]').prop('selected', true);
            $('#edit_prodcat_id').formSelect();
            $('#edit_prod_name').val(data.prod_name);
            $('#edit_prod_code').val(data.prod_code);
            $('#edit_prod_writeup').val(data.prod_writeup);
            $('#edit_prod_type option[value="'+data.prod_type+'"]').prop('selected', true);
            $('#edit_prod_type').formSelect();
            $('#editModal').modal('open');
            M.updateTextFields();
            $('.materialize-textarea').each(function (index) {
                M.textareaAutoResize(this);
            });
        });
    }

  function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var product_dt = $('#product-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        //"aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/product/all",
        "columns": [
            {  "data": "id" },
            {  "data": "site",
                "render": function ( data, type, row, meta ) {
                    return row.site.site_desc;
                } 
            },
            {  "data": "prod_cat",
                "render": function ( data, type, row, meta ) {
                    return row.prod_cat.prodcat_name;
                } 
            },
            {  "data": "prod_name" },
            {  "data": "prod_code" },
            {  "data": "prod_type" },
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
