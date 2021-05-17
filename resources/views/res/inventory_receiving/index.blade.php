@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>Receiving</h4>
    </div>
  </div>
  <div class="row main-content">

    <div id="ongoing" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="receiving-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Receiving Code</th>
                    <th>Delivery No.</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Receiving" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>

  </div>
 
  <!-- MODALS -->

  <div id="addModal" class="modal" style="width: 800px;">
    <form method="POST" action="{{route('receiving.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Receiving Details</h4><br><br>

        <div class="row">
          <div class="input-field col s12 m6 l6">
            <input id="add_receiving_code" name="receiving_code" type="text" class="validate" placeholder="" value="-RCV{{date('Ymd')}}-{{$count}}" required readonly>
            <label for="receiving_code">Receiving Code<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6 l6">
            <select id="add_site_code" name="site_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($site as $sites)
                <option value="{{$sites->site_code}}">{{$sites->site_desc}}</option>
              @endforeach
            </select>
            <label for="site_code">Site<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="add_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" required>
            <label for="delivery_date">Delivery Date<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6 l6">
            <input id="add_delivery_no" name="delivery_no" type="text" class="validate" placeholder="" required>
            <label for="delivery_no">Delivery No.<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="add_po_no" name="po_no" type="text" class="validate" placeholder="" required>
            <label for="po_no">P.O No.<sup class="red-text">*</sup></label>
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
    <form method="POST" action="{{route('receiving.patch')}}">
      @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Edit Receiving Details</h4><br><br>

        <div class="row">
          <div class="input-field col s12 m6 l6">
            <input type="hidden" id="edit_id" name="id">
            <input id="edit_receiving_code" name="receiving_code" type="text" class="validate" placeholder="" required readonly>
            <label for="receiving_code">Receiving Code<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6 l6">
            <select id="edit_site_code" name="site_code" required>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($site as $sites)
                <option value="{{$sites->site_code}}">{{$sites->site_desc}}</option>
              @endforeach
            </select>
            <label for="site_code">Site<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="edit_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" >
            <label for="delivery_date">Delivery Date<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6 l6">
            <input id="edit_delivery_no" name="delivery_no" type="text" class="validate" placeholder="" required>
            <label for="delivery_no">Delivery No.<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="edit_po_no" name="po_no" type="text" class="validate" placeholder="" required>
            <label for="po_no">P.O No.<sup class="red-text">*</sup></label>
          </div>
        </div>

      </div>

      <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>
  
  <div id="viewModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Receiving Details</h4><br><br>

      <div class="row">
        <div class="input-field col s12 m6 l6">
          <input type="hidden" id="view_id" name="id">
          <input id="view_receiving_code" name="receiving_code" type="text" class="validate" placeholder="" readonly>
          <label for="receiving_code">Receiving Code<sup class="red-text">*</sup></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6 l6">
          <select id="view_site_code" name="site_code"  disabled>
            <option value="" disabled selected>Choose your option</option>
            @foreach ($site as $sites)
              <option value="{{$sites->site_code}}">{{$sites->site_desc}}</option>
            @endforeach
          </select>
          <label for="site_code">Site<sup class="red-text">*</sup></label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="view_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" disabled>
          <label for="delivery_date">Delivery Date<sup class="red-text">*</sup></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6 l6">
          <input id="view_delivery_no" name="delivery_no" type="text" class="validate" placeholder="" readonly>
          <label for="delivery_no">Delivery No.<sup class="red-text">*</sup></label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="view_po_no" name="po_no" type="text" class="validate" placeholder="" readonly>
          <label for="po_no">P.O No.<sup class="red-text">*</sup></label>
        </div>
      </div>

    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
    </div>
  </div>

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('receiving.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Inventory Location</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Inventory Receiving</strong>?</p>
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

  var delCount = {{$count}};
  const str = new Date().toISOString().slice(0, 10);

  var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
  $(document).ready(function () {
    
      $('#add_site_code').on('change', function(){
          deliveryCode($(this).val(),'add');
      });
    
      $('#edit_site_code').on('change', function(){
          deliveryCode($(this).val(),'edit');
      });
    
  });

  const deliveryCode = (site, loc) => {
      if(loc=="add"){
        $('#add_receiving_code').val( site + '-RCV' + newtoday + '-00' + delCount);
      } else {
        var str = $('#edit_receiving_code').val();
        var count = str.substr(-3, 3);
        $('#edit_receiving_code').val( site + '-RCV' + newtoday + '-00' + count);
      }
  };

  const editReceiving = (id) => {
    $.get('receiving/'+id, (response) => {
      var data = response.data;
      $('#edit_id').val(id);
      $('#edit_site_code option[value="'+data.site_code+'"]').prop('selected', true);
      $('#edit_site_code').formSelect();
 
      $('#edit_receiving_code').val(data.receiving_code);
      $('#edit_delivery_date').val(data.delivery_date);
      $('#edit_delivery_no').val(data.delivery_no);
      $('#edit_po_no').val(data.po_no);

      $('#editModal').modal('open');
    });
  }

  const deleteItem = (id) => {
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
  }

  const viewReceiving = (id) => {
    $.get('receiving/'+id, (response) => {
      var data = response.data;
      $('#view_id').val(id);
      $('#view_site_code option[value="'+data.site_code+'"]').prop('selected', true);
      $('#view_site_code').formSelect();
 
      $('#view_receiving_code').val(data.receiving_code);
      $('#view_delivery_date').val(data.delivery_date);
      $('#view_delivery_no').val(data.delivery_no);
      $('#view_po_no').val(data.po_no);

      $('#viewModal').modal('open');
    });
  }

  const printModal = (id) => {
    console.log(id);
    $('#id').val(id);
    // $('#objectPDF').prop("data", "location/barcodes/"+id+"#toolbar=1&navpanes=0&scrollbar=1&page=1&zoom=100");
    $( "object" ).replaceWith('<object data="location/barcodes/'+id+'#toolbar=1&navpanes=0&scrollbar=1&page=1&zoom=100" type="application/pdf" width="100%" height="280px"></object>');
    $('#printModal').modal('open');
  }

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

  var receiving = $('#receiving-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/inventory/receiving/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="#!" onclick="viewReceiving('+data+')">'+row.receiving_code+'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.delivery_no;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.delivery_date;
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  switch (row.status) {
                    case "Received":
                      return  '<span class="new badge green white-text" data-badge-caption="">Received</span>';
                        break;
                    case "With RTV":
                      return  '<span class="new orange darken-3 black white-text" data-badge-caption="">With RTV</span>';
                        break;
                    case 'Voided':
                      return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                        break;
                  }
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  // return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editReceiving('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+data+')"><i class="material-icons">delete</i></a> <a href="#" class="btn-small blue waves-effect waves-light" onclick="printModal('+data+')"><i class="material-icons">print</i></a>';
                  return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editReceiving('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+data+')"><i class="material-icons">delete</i></a>';
                }
            },   
        ]
  });

  </script>
    <!-- End of SCRIPTS -->
@endsection