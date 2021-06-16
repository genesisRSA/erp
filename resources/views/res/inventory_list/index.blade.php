@extends('layouts.resmain')
 
@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>Inventory List</h4>
    </div>
  </div>
  <div class="row main-content">

    <div id="ongoing" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="inventory-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Unit of Measure</th>
                    <th>Safety Stock</th>
                    <th>Maximum Stock</th>
                    <th>Warning Level</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
    </div>

  </div>
 
  <!-- MODALS -->

  <div id="viewModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Item Details</h4><br>
 
        <div class="row"  style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="view_item_code" name="item_code" type="text" class="" placeholder="" readonly>
            <label for="item_code">Item Code<sup class="red-text"></sup></label>
          </div>
          <div class="input-field col s12 m6 l6">
            <textarea id="view_item_desc" name="item_desc" class="materialize-textarea" placeholder="" readonly></textarea>
            <label for="item_desc">Description<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="view_location_code" name="location_code" type="text" class="" placeholder="" readonly>
            <label for="location_code">Location Code<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_inventory_location" name="inventory_location" type="text" class="" placeholder="" readonly>
            <label for="inventory_location">Location Name<sup class="red-text"></sup></label>
          </div>
        </div>
        

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="view_uom" name="uom" type="text" class="" placeholder="" readonly>
            <label for="uom">Unit of Measure<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_current_stock" name="current_stock" type="text" class="" placeholder="" readonly>
            <label for="current_stock">Current Stock(s)<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m4 l4">
            <input id="view_safety_stock" name="safety_stock" type="text" class="" placeholder="" readonly>
            <label for="safety_stock">Safety Stock(s)<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <input id="view_maximum_stock" name="maximum_stock" type="text" class="" placeholder="" readonly>
            <label for="maximum_stock">Maximum Stock(s)<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <input id="view_warning_level" name="warning_level" type="text" class="" placeholder="" readonly>
            <label for="warning_level">Warning Level<sup class="red-text"></sup></label>
          </div>
        </div>


        <div id="fab_details" style="display: none">
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="fab_length" name="length" type="text" class="" placeholder="" readonly>
              <label for="length">Length<sup class="red-text"></sup></label>
            </div>
  
            <div class="input-field col s12 m6 l6">
              <input id="fab_width" name="width" type="text" class="" placeholder="" readonly>
              <label for="width">Width<sup class="red-text"></sup></label>
            </div>
          </div>
  
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="fab_thickness" name="thickness" type="text" class="" placeholder="" readonly>
              <label for="thickness">Thickness<sup class="red-text"></sup></label>
            </div>
  
            <div class="input-field col s12 m6 l6">
              <input id="fab_radius" name="radius" type="text" class="" placeholder="" readonly>
              <label for="radius">Radius<sup class="red-text"></sup></label>
            </div>
          </div>
        </div>

 

    </div>

    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
      <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
    </div>
  </div>
  
  <!-- End of MODALS -->

    <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

 
  const str = new Date().toISOString().slice(0, 10);
  var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
  
  var add_items = [];
  var edit_items = [];
  var view_items = [];

  const viewReceiving = (id, loc) => {
    $('#viewModal').modal('open');
    $.get('list/'+id+'/'+loc+'/item_details', (response) => {
      var data = response.data;
      $('#view_item_code').val(data.item_code);
      $('#view_item_desc').val(data.item_details.item_desc);
      $('#view_location_code').val(data.loctype.location_code);
      $('#view_inventory_location').val(data.loctype.location_name);
      $('#view_current_stock').val(data.quantity ? data.quantity : 0);
      $('#view_uom').val(data.item_details.uom_code ? data.item_details.uom_code : 0);
      $('#view_safety_stock').val(data.item_details.safety_stock ? data.item_details.safety_stock : 0);
      $('#view_maximum_stock').val(data.item_details.maximum_stock ? data.item_details.maximum_stock : 0);
      $('#view_warning_level').val(data.item_details.warning_level ? data.item_details.warning_level : 0);

      if(data.item_details.cat_code == "FAB"){
        var x = document.getElementById("fab_details");
            x.style.display = "block";
      
        $('#fab_length').val(data.item_details.length ? data.item_details.length : 0);
        $('#fab_width').val(data.item_details.width ? data.item_details.width : 0);
        $('#fab_thickness').val(data.item_details.thickness ? data.item_details.thickness : 0);
        $('#fab_radius').val(data.item_details.radius ? data.item_details.radius : 0);

      } else {
        var x = document.getElementById("fab_details");
            x.style.display = "none";
      }

    });
  };

  var inventory = $('#inventory-dt').DataTable({
        @if($permission[0]["masterlist"]==true)
          dom: 'Bfrtip',
          "buttons": [
            {
              text: "Export to Excel",
              extend: 'excelHtml5',
              title: 'REISS - Inventory Report' 
            },
            {
              text: "Export to PDF",
              extend: 'pdfHtml5',
              title: 'REISS - Inventory Report'
            }
          ],
        @endif

        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/inventory/list/all",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  @if($permission[0]["view"]==true || $permission[0]["masterlist"]==true)
                    return '<a href="#!" onclick="viewReceiving(\''+row.item_code+'\',\''+row.inventory_location_code+'\')">'+row.item_code+'</a>';
                  @else
                    return row.item_code;
                  @endif
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.item_details.item_desc;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.loctype.location_name;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.item_details.uom_code;
                }
            },
          
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.item_details.safety_stock;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.item_details.maximum_stock;
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.item_details.warning_level;
                }
            },

            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  if(row.quantity >= row.item_details.safety_stock){
                    return '<p class="green-text">'+row.quantity.toFixed(5)+'</p>';
                  } else if(row.quantity <= row.item_details.safety_stock){
                    return '<p class="orange-text">'+row.quantity.toFixed(5)+'</p>';
                  } else if(row.quantity < row.item_details.warning_level) {
                    return '<p class="red-text">'+row.quantity.toFixed(5)+'</p>';
                  } 
                }
            },
            {  "data": "id",
                "render": function ( data, type, row, meta ) {
                  if(row.quantity >= row.item_details.safety_stock){
                    return '<i class="material-icons green-text">arrow_drop_up</i>';
                  } else if(row.quantity <= row.item_details.safety_stock){
                    return '<i class="material-icons orange-text">import_export</i>';
                  } else if(row.quantity < row.item_details.warning_level) {
                    return '<i class="material-icons red-text">arrow_drop_down</i>';
                  } 
                }
            },
        ]
 
       
  });

  </script>
    <!-- End of SCRIPTS -->
@endsection