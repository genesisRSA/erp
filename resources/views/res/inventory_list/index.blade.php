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

          {{-- <div class="col s3 m3 l3 left-align" style="
          margin-top: 60px;
          margin-left: 20px;
      ">
            <span   multiple="true">Location:</span>
            <select multiple="true" id="officeFltr">
            </select>
          </div> --}}
        
          <div class="card-content">
            <table class="responsive-table highlight" id="inventory-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Unit of Measure</th>
                    <th>Quantity</th>
                    <th>Safety Stock</th>
                    <th>Maximum Stock</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      {{-- @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Receiving" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif --}}
    </div>

  </div>
 
  <!-- MODALS -->

  <div id="viewModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Item Details</h4><br>
 
        <div class="row"  style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="view_item_code" name="item_code" type="text" class="validate" placeholder="" readonly>
            <label for="item_code">Item Code<sup class="red-text"></sup></label>
          </div>
          <div class="input-field col s12 m6 l6">
            <input id="view_item_desc" name="item_desc" type="text" class="validate" placeholder="" readonly>
            <label for="item_desc">Description<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="" name="" type="text" class="validate" placeholder="to be completed.." readonly>
            <label for=""><sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="" name="" type="text" class="validate" placeholder="to be completed.." readonly>
            <label for=""><sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="" name="" type="text" class="validate" placeholder="to be completed.." readonly>
            <label for=""><sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="" name="" type="text" class="validate" placeholder="to be completed.." readonly>
            <label for=""><sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="" name="" type="text" class="validate" placeholder="to be completed.." readonly>
            <label for=""><sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="" name="" type="text" class="validate" placeholder="to be completed.." readonly>
            <label for=""><sup class="red-text"></sup></label>
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

  $(document).ready(function () {

    // $('#officeFltr').on('change', function(){
    // 	var search = [];
      
    //   $.each($('#officeFltr option:selected'), function(){
    //   		search.push($(this).val());
    //   });
      
    //   search = search.join('|');
    //   table.column(2).search(search, true, false).draw();  
    // });


  });

  const viewReceiving = (id, loc) => {
      console.log(id); 
      console.log(loc); 
      $('#viewModal').modal('open');
    $.get('list/'+id+'/'+loc+'/item_details', (response) => {
      var data = response.data[0];
      console.log(data);
      $('#view_item_code').val(data.item_code);
      $('#view_item_desc').val(data.item_details.item_desc);
      // $('#view_item_desc').val(data.item_details.item_desc);
    });
  };

  var inventory = $('#inventory-dt').DataTable({
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
        // initComplete: function () {
        //   this.api().columns([3]).every( function () {
        //     var column = this;
        //     var select = $("#officeFltr"); 
        //     column.data().each( function ( d ) {
        //       select.append( '<option value="'+d+'">'+d+'</option>' )
        //     } );
        //   } );
        //   $("#officeFltr").formSelect();
        // }, 
        
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/inventory/list/all",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="#!" onclick="viewReceiving(\''+row.item_code+'\',\''+row.inventory_location_code+'\')">'+row.item_code+'</a>';
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
                  return row.quantity;
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
        ]
 
       
  });

  </script>
    <!-- End of SCRIPTS -->
@endsection