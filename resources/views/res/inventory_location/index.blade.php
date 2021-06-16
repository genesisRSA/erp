@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>Inventory Location</h4>
    </div>
  </div>
  <div class="row main-content">

    <div id="ongoing" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="location-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Location Code</th>
                    <th>Name</th>
                    <th>Required Item Category</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true || $permission[0]["masterlist"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Inventory Location" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>

  </div>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('location.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Inventory Location</h4><br><br>

        <div class="row">
        
            <div class="input-field col s12 m6 l6">
                <select id="add_required_item_category" name="required_item_category" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($itemcat as $ic)
                        <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
                    @endforeach
                </select>
                <label for="required_item_category">Required Item Category<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
                <select id="add_category" name="category" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="DF">Default</option>
                    <option value="SM">Slow Moving</option>
                    <option value="NM">Non-Moving</option>
                    <option value="FM">Fast Moving</option>
                </select>
                <label for="category">Category<sup class="red-text">*</sup></label>
            </div>

        </div>

        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input id="add_location_code" name="location_code" type="text" class="validate" placeholder="" required readonly>
                <label for="location_code">Location Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
                <input id="add_location_name" name="location_name" type="text" class="validate" placeholder="" required>
                <label for="location_name">Location Name<sup class="red-text">*</sup></label>
            </div>
        </div>

      </div>

      <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('location.patch')}}">
      @csrf
        <div class="modal-content" style="padding-bottom: 0px;">
          <h4>Edit Inventory Location</h4><br><br>
  
          <div class="row">
              <input type="hidden" id="editID" name="id">
              <div class="input-field col s12 m6 l6">
                  <select id="edit_required_item_category" name="required_item_category" required>
                      <option value="" disabled selected>Choose your option</option>
                      @foreach ($itemcat as $ic)
                          <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
                      @endforeach
                  </select>
                  <label for="required_item_category">Required Item Category<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                  <select id="edit_category" name="category" required>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="DF">Default</option>
                      <option value="SM">Slow Moving</option>
                      <option value="NM">Non-Moving</option>
                      <option value="FM">Fast Moving</option>
                  </select>
                  <label for="category">Category<sup class="red-text">*</sup></label>
              </div>
              
          </div>
  
          <div class="row">
              <div class="input-field col s12 m6 l6">
                  <input id="edit_location_code" name="location_code" type="text" class="validate" placeholder="" required readonly>
                  <label for="location_code">Location Code<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                  <input id="edit_location_name" name="location_name" type="text" class="validate" placeholder="" required>
                  <label for="location_name">Location Name<sup class="red-text">*</sup></label>
              </div>
          </div>
  
        </div>
  
        <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
          <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
        </div>
    </form>
  </div>
  
  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('location.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Inventory Location</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Inventory Location</strong>?</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Yes</button>
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
        </div>
    </form>
  </div> 

  <div id="viewModal" class="modal">
        <div class="modal-content" style="padding-bottom: 0px;">
          <h4>Inventory Location Details</h4><br><br>
  
          <div class="row">
              <input type="hidden" id="editID" name="id">
              <div class="input-field col s12 m6 l6">
                  <select id="view_required_item_category" name="required_item_category" required disabled>
                      <option value="" disabled selected>Choose your option</option>
                      @foreach ($itemcat as $ic)
                          <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
                      @endforeach
                  </select>
                  <label for="required_item_category">Required Item Category<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                  <select id="view_category" name="category" required disabled>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="DF">Default</option>
                      <option value="SM">Slow Moving</option>
                      <option value="NM">Non-Moving</option>
                      <option value="FM">Fast Moving</option>
                  </select>
                  <label for="category">Category<sup class="red-text">*</sup></label>
              </div>
              
          </div>
  
          <div class="row">
              <div class="input-field col s12 m6 l6">
                  <input id="view_location_code" name="location_code" type="text" class="validate" placeholder="" required readonly>
                  <label for="location_code">Location Code<sup class="red-text">*</sup></label>
              </div>
  
              <div class="input-field col s12 m6 l6">
                  <input id="view_location_name" name="location_name" type="text" class="validate" placeholder="" required readonly>
                  <label for="location_name">Location Name<sup class="red-text">*</sup></label>
              </div>
          </div>
        </div>
  
        <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
          <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
        </div>
  </div>

  <div id="printModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Inventory Location QR Code</h4>
      <input type="hidden" id="id">
      <div>
        <object id="objectPDF" type="application/pdf" width="100%" height="280px"> 
        </object>
      </div> 
    </div>
    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <input type="button" id="bt" onclick="print()" value="Print PDF" />
        <a href="#!" class="red waves-effect waves-dark btn" onclick="closePrint();"><i class="material-icons left">keyboard_return</i>Return</a>
    </div>
  </div>

  <!-- End of MODALS -->

    <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

  var locCount = {{$count}};

  $(document).ready(function () {
    
      $('#add_required_item_category').on('change', function(){
          var cat =   ($('#add_category').val() == null ? '' : $('#add_category').val());
          var type =  ($('#add_location_type').val() == null ? '' : $('#add_location_type').val());
          locationCode($(this).val(), cat, type, 'add');
      });
      
      $('#add_category').on('change', function(){
          var req =   ($('#add_required_item_category').val() == null ? '' : $('#add_required_item_category').val());
          var type =  ($('#add_location_type').val() == null ? '' : $('#add_location_type').val());
          locationCode(req, $(this).val(), type, 'add');
      });

      $('#add_location_type').on('change', function(){
          var req =   ($('#add_required_item_category').val() == null ? '' : $('#add_required_item_category').val());  
          var cat =   ($('#add_category').val() == null ? '' : $('#add_category').val());
          locationCode(req, cat, $(this).val(), 'add');
      });

      $('#edit_required_item_category').on('change', function(){
          var cat =   ($('#edit_category').val() == null ? '' : $('#edit_category').val());
          var type =  ($('#edit_location_type').val() == null ? '' : $('#edit_location_type').val());
          locationCode($(this).val(), cat, type, 'edit');
      });
      
      $('#edit_category').on('change', function(){
          var req =   ($('#edit_required_item_category').val() == null ? '' : $('#edit_required_item_category').val());
          var type =  ($('#edit_location_type').val() == null ? '' : $('#edit_location_type').val());
          locationCode(req, $(this).val(), type, 'edit');
      });

      $('#edit_location_type').on('change', function(){
          var req =   ($('#edit_required_item_category').val() == null ? '' : $('#edit_required_item_category').val());  
          var cat =   ($('#edit_category').val() == null ? '' : $('#edit_category').val());
          locationCode(req, cat, $(this).val(), 'edit');
      });

  });

  const locationCode = (req, cat, type, loc) => {
      if(loc=="add"){
        $('#add_location_code').val( 'INL' + req + '-' + cat + '-' + type + '00' + locCount);
      } else {
        var str = $('#edit_location_code').val();
        var count = str.substr(-3, 3);
        $('#edit_location_code').val( 'INL' + req + '-' + cat + '-' + type + count);
      }
  };

  const viewLocation = (id) => {
    $.get('location/'+id, (response) => {
      var data = response.data;
      $('#view_required_item_category option[value="'+data.required_item_category+'"]').prop('selected', true);
      $('#view_required_item_category').formSelect();
      $('#view_category option[value="'+data.category+'"]').prop('selected', true);
      $('#view_category').formSelect();
      $('#view_location_code').val(data.location_code);
      $('#view_location_name').val(data.location_name);
      $('#viewModal').modal('open');
    });
  };

  const editLocation = (id) => {
    $.get('location/'+id, (response) => {
      var data = response.data;
      $('#editID').val(data.id);
      $('#edit_required_item_category option[value="'+data.required_item_category+'"]').prop('selected', true);
      $('#edit_required_item_category').formSelect();
      $('#edit_category option[value="'+data.category+'"]').prop('selected', true);
      $('#edit_category').formSelect();
      $('#edit_location_code').val(data.location_code);
      $('#edit_location_name').val(data.location_name);
      $('#editModal').modal('open');
    });
  }

  const deleteItem = (id) => {
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
  };

  const printModal = (id) => {
    $('#id').val(id);
    $( "object" ).replaceWith('<object data="location/barcodes/'+id+'#toolbar=1&navpanes=1&scrollbar=1&page=1&zoom=100" type="application/pdf" width="100%" height="280px"></object>');
    $('#printModal').modal('open');
  };

  const trim = (str) => {
      return str.replace(/^\s+|\s+$/gm,'');
  };
    
  const openModal = () => {
    $('#add_required_item_category option[value=""]').prop('selected', true);
    $('#add_required_item_category').formSelect();
    $('#add_category option[value=""]').prop('selected', true);
    $('#add_category').formSelect();
    $('#add_location_code').val("");
    $('#add_location_name').val("");
    $('#addModal').modal('open');
  };

  const closePrint = () => {
    $('#printModal').modal('close');
  }; 

  let print = () => {
    	let objFra = document.getElementById('myFrame');
        objFra.contentWindow.focus();
        objFra.contentWindow.print();
    }

  var locations = $('#location-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/inventory/location/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["view"]==true || $permission[0]["masterlist"]==true)
                    return '<a href="#!" onclick="viewLocation('+data+')">'+ row.location_code +'</a>';
                  @else
                    return row.location_code;
                  @endif
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.location_name;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.reqcat.cat_desc;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  switch (row.category) {
                    case "DF":
                        return "Default"
                      break;
                    case "SM":
                        return "Slow Moving"
                      break;
                    case "NM":
                        return "Non-Moving"
                      break;
                    case "FM":
                        return "Fast Moving"
                      break;
                  }
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["masterlist"]==true)
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editLocation('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+data+')"><i class="material-icons">delete</i></a> <a href="#" class="btn-small blue waves-effect waves-light" onclick="printModal('+data+')"><i class="material-icons">print</i></a>';
                  @else
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" disabled><i class="material-icons">delete</i></a> <a href="#" class="btn-small blue waves-effect waves-light" disabled><i class="material-icons">print</i></a>';
                  @endif
                }
            },   
        ]
  });

  </script>
    <!-- End of SCRIPTS -->
@endsection