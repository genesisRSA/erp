@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Parts Preparation<i class="material-icons">arrow_forward_ios</i></span>Inventory Issuance</h4>
    </div>
  </div>
  <div class="row main-content">
    <ul id="project_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#Request">Request</a></li>
      <li class="tab col s12 m4 l4"><a class="active" href="#Issuance">Issuance</a></li>
      <li class="tab col s12 m4 l4"><a class="active" href="#Approval">Approval</a></li>
    </ul>

    <div id="Request" name="ongoing">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="issuance-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Issuance Code</th>
                    <th>Requestor</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Inventory Issuance" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>

    <div id="Issuance" name="Issuance">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="issuance-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Issuance Code</th>
                    <th>Requestor</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
      @if($permission[0]["add"]==true)
        <a href="#!" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button" data-position="left" data-tooltip="Add Inventory Issuance" onclick="openModal();"><i class="material-icons">add</i></a>
      @endif
    </div>

    <div id="Approval" name="Approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="issuance-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Issuance Code</th>
                    <th>Requestor</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      
     
    </div>

  </div>
 
  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('issuance.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Inventory Issuance</h4>

        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#issuance">Issuance Details</a></li>
           <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="issuance" name="issuance">
          <div class="row">
              <div class="input-field col s12 m6 l6">
                <input id="add_issuance_code" name="issuance_code" type="text" class="validate" placeholder="" value="ISS{{date('Ymd')}}-00{{$count}}" required readonly>
                <label for="issuance_code">Issuance Code<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <select id="add_site_code" name="site_code" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($sites as $site)
                      <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                    @endforeach
                </select>
                <label for="site_code">Site<sup class="red-text">*</sup></label>
              </div>
          </div>

          <div class="row">
              <div class="input-field col s12 m6 l6">
                  <select id="add_requestor" name="requestor" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($employee as $emp)
                      <option value="{{$emp->emp_no}}">{{$emp->full_name}}</option>                 
                    @endforeach
                  </select>
                  <label for="requestor">Requestor<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <select id="add_purpose" name="purpose" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="Office Use">Office Use</option>
                    <option value="Project">Project</option>
                </select>
                <label for="purpose">Purpose<sup class="red-text">*</sup></label>
              </div>
          </div>

          <div class="row" style="display: none" id="project_details">
              <div class="input-field col s12 m6 l6">
                <select id="add_project_code" name="project_code" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($projects as $project)
                        <option value="{{$project->project_code}}">{{$project->project_name}}</option>
                    @endforeach
                </select>
                <label for="project_code">Project Code<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <select id="add_assy_code" name="assy_code" required>
                  <option value="" disabled selected>Choose your option</option>
                </select>
                <label for="assy_code">Assy Code<sup class="red-text">*</sup></label>
              </div>
          </div>

          <div class="row">
            <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 1em; background-color:#0d47a1" class="white-text"><b>Item Details</b></h6>
          </div>
            
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <select id="add_inventory_location" name="inventory_location">
                <option value="" disabled selected>Choose your option</option>
                @foreach ($inventloc as $inventlocs)
                  <option value="{{$inventlocs->location_code}}">{{$inventlocs->location_name}}</option>
                @endforeach
              </select>
              <label for="inventory_location">Inventory Location<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="add_item_code" name="item_code">
                <option value="" disabled selected>Choose your option</option>
                {{-- @foreach ($inventloc as $inventlocs)
                  <option value="{{$inventlocs->location_code}}">{{$inventlocs->location_name}}</option>
                @endforeach --}}
              </select>
              <label for="item_code">Item Name<sup class="red-text">*</sup></label>
            </div>
            
            {{-- <div class="input-field col s12 m6 l6">
              <input id="add_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="">
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
            </div> --}}
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <select id="add_currency_code" name="currency_code">
                <option value="" disabled selected>Choose your option</option>
                @foreach ($currency as $currencyx)
                  <option value="{{$currencyx->currency_code}}">{{$currencyx->symbol}} - {{$currencyx->currency_name}}</option>
                @endforeach
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="add_quantity" name="quantity" type="number" class="validate" placeholder="">
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="add_unit_price" name="unit_price" type="number" class="validate" placeholder="">
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="add_total_price" name="total_price" type="text" class="validate" placeholder="" readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6 left-align">
              <button type="button" class="blue waves-effect waves-light btn right-align" id="btnAdd"><i class="material-icons left">add_circle</i>Add Item</button>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="items-dt">
                    <thead>
                      <tr>
                          <th>Item Code</th>
                          <th>Currency</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Total Price</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div id="signatories" name="signatories">
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt">
                    <thead>
                      <tr>
                          <th>Sequence</th> 
                          <th>Approver ID</th> 
                          <th>Approver Name</th> 
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <button class="green waves-effect waves-light btn" id="btnAddSave" disabled><i class="material-icons left">check_circle</i>Save</button>
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
                      {{-- @foreach ($itemcat as $ic)
                          <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
                      @endforeach --}}
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
                      {{-- @foreach ($itemcat as $ic)
                          <option value="{{$ic->cat_code}}">{{$ic->cat_desc}}</option>
                      @endforeach --}}
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
      <h4>Inventory Location Barcode</h4>
      <input type="hidden" id="id">
      <div>
        <object id="objectPDF" type="application/pdf" width="100%" height="280px"> 
        </object>
      </div> 
    </div>
    <div class="modal-footer" style="padding-right: 32px; padding-bottom: 4px; margin-bottom: 30px;">
        <a href="#!" class="red waves-effect waves-dark btn" onclick="closePrint();"><i class="material-icons left">keyboard_return</i>Return</a>
    </div>
  </div>

  <!-- End of MODALS -->

    <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

  var issueCount = {{$count}};
  const str = new Date().toISOString().slice(0, 10);
  var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");

  var add_items = [];
  var edit_items = [];
  var view_items = [];

  $(document).ready(function () {
    
      $('#add_site_code').on('change', function(){
        issuanceCode($(this).val(), 'add');
      });
      
      $('#add_purpose').on('change', function(){
        if($(this).val()=='Project')
        {
          var x = document.getElementById('project_details');
            x.style.display = "block";
        } else {
          var x = document.getElementById('project_details');
            x.style.display = "none";
        }
      });

      $('#add_project_code').on('change', function(){
        $.get('../projects/view/'+$(this).val()+'/view_assy', (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose your option</option>';
          $.each(data, (index,row) => {
              select += '<option value="'+row.assy_code+'">'+row.assy_desc+'</option>';
          });
          $('#add_assy_code').html(select);
          $('#add_assy_code').formSelect();
        });
      });

      $('#add_unit_price').on('keyup', function(){
        computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
      });

      $('#add_quantity').on('keyup', function(){
        computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
      });

      $('#add_currency_code').on('change', function(){
        computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
      });

      $('#btnAdd').on('click', function(){
        if($('#add_item_code').val() &&
            $('#add_inventory_location').val() &&
            $('#add_currency_code').val() &&
            $('#add_quantity').val() &&
            $('#add_unit_price').val() &&
            $('#add_total_price').val()
        ){
          $.get('../item_master/getItemDetails/'+$('#add_item_code').val(), (response) => {
            var item = response.data;
            if(item){
              $.get('receiving/'+item.item_code+'/getCurrentStock', (response) => {
                var current_stock = parseInt(response.data) + parseInt($('#add_quantity').val());
                var maximum_stock = parseInt(item.maximum_stock);
                addItem('add',current_stock, maximum_stock);
              });
            } else {
              alert('Item code does not exist! Please the check item code before adding item details..');
            }
          });
        }else{
          alert("Please fill up product details!");
        }
      });


  });

  const FormatNumber = (number) => {
        var n = number.toString().split(".");
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        n[1] = n[1] ? n[1] : '00';
        return n.join(".");
  };
  
  const computeTotalPrice = (symbol = '$', unit_price = 0, quantity = 0, input_total) => {
    const total = unit_price * quantity;
    input_total.val(symbol+" "+FormatNumber(total ? parseFloat(total) : 0));
  };

  const resetItemDetails = (loc) => {
    if(loc=="add"){
      $('#add_inventory_location').val("");
      $('#add_inventory_location').formSelect();
      $('#add_currency_code').val("");
      $('#add_currency_code').formSelect();
      $('#add_item_code').val("");
      $('#add_quantity').val("");
      $('#add_unit_price').val("");
      $('#add_total_price').val("");
    } else {
      $('#edit_inventory_location').val("");
      $('#edit_inventory_location').formSelect();
      $('#edit_currency_code').val("");
      $('#edit_currency_code').formSelect();
      $('#edit_item_code').val("");
      $('#edit_quantity').val("");
      $('#edit_unit_price').val("");
      $('#edit_total_price').val("");
    }
  }

  const issuanceCode = (site, loc) => {
      if(loc=='add'){
        $('#add_issuance_code').val( site + '-ISS' + newtoday + '-00' + issueCount );
      } else {
        var str = $('#edit_issuance_code').val();
        var count = str.substr(-3, 3);
        $('#edit_issuance_code').val( site + '-ISS' + newtoday + '-00' + count);
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
  };

  const renderItems = (items, table, loc) => {
    table.html("");
    $.each(items, (index, row) => {
      if(loc=='add'){
        table.append('<tr>'+
                    '<td class="left-align">'+row.item_code+'</td>'+
                    '<td class="left-align">'+row.currency+'</td>'+
                    '<td class="left-align">'+row.quantity+'</td>'+
                    '<td class="left-align">'+row.currency.split(" - ")[0]+" "+FormatNumber(row.unit_price)+'</td>'+
                    '<td class="left-align">'+row.currency.split(" - ")[0]+" "+FormatNumber(row.total_price)+'</td>'+
                    '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="deleteItem(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                    '<input type="hidden" name="itm_item_code[]" value="'+row.item_code+'"/>'+
                    '<input type="hidden" name="itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                    '<input type="hidden" name="itm_currency[]" value="'+row.currency+'"/>'+
                    '<input type="hidden" name="itm_currency_code[]" value="'+row.currency_code+'"/>'+
                    '<input type="hidden" name="itm_unit_price[]" value="'+row.unit_price+'"/>'+
                    '<input type="hidden" name="itm_quantity[]" value="'+row.quantity+'"/>'+
                    '<input type="hidden" name="itm_total_price[]" value="'+row.total_price+'"/>'+
                    '</tr>'
                  );
      } else if(loc=='edit'){
        table.append('<tr>'+
                    '<td class="left-align">'+row.item_code+'</td>'+
                    '<td class="left-align">'+row.currency+'</td>'+
                    '<td class="left-align">'+row.quantity+'</td>'+
                    '<td class="left-align">'+row.currency.split(" - ")[0]+" "+FormatNumber(row.unit_price)+'</td>'+
                    '<td class="left-align">'+row.currency.split(" - ")[0]+" "+FormatNumber(row.total_price)+'</td>'+
                    '<td><button type="button" class="btn-small red waves-effect waves-light" disabled><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                    '<input type="hidden" name="e_itm_item_code[]" value="'+row.item_code+'"/>'+
                    '<input type="hidden" name="e_itm_inventory_location[]" value="'+row.inventory_location+'"/>'+
                    '<input type="hidden" name="e_itm_currency[]" value="'+row.currency+'"/>'+
                    '<input type="hidden" name="e_itm_currency_code[]" value="'+row.currency_code+'"/>'+
                    '<input type="hidden" name="e_itm_unit_price[]" value="'+row.unit_price+'"/>'+
                    '<input type="hidden" name="e_itm_quantity[]" value="'+row.quantity+'"/>'+
                    '<input type="hidden" name="e_itm_total_price[]" value="'+row.total_price+'"/>'+
                    '</tr>'
                  );
      } else {
        table.append('<tr>'+
                    '<td class="left-align">'+row.item_code+'</td>'+
                    '<td class="left-align">'+row.currency+'</td>'+
                    '<td class="left-align">'+row.quantity+'</td>'+
                    '<td class="left-align">'+row.currency.split(" - ")[0]+" "+FormatNumber(row.unit_price)+'</td>'+
                    '<td class="left-align">'+row.currency.split(" - ")[0]+" "+FormatNumber(row.total_price)+'</td>'+
                    '</tr>'
                  );
      }
    });

    if(items.length > 0){
      $('#btnAddSave').prop('disabled', false);
    };
  };

  const deleteItem = (id) => {
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
  };

  const addItem = (loc, current_stock = 0, maximum_stock = 0) => {
    var found = false;
    var cindex = 0;
    if(loc=='add')
    {
   
      if($('#add_unit_price').val() <= 0){
      alert('Unit Price must be greater than 0!');
      }else if($('#add_quantity').val() <= 0){
        alert('Quantity must be greater than 0!');
      }else{
        $.each(add_items,(index,row) => {
          if(row.item_code == $('#add_item_code').val()){
            cindex = index;
            found = true;
            return false;
          }
        });

        if(found){
              var current_stocks = parseInt(current_stock) + parseInt(add_items[cindex].quantity);
              var stock_percentage = ((current_stocks / maximum_stock) * 100).toFixed(1);
          if(stock_percentage >= 90)
          {
            if(stock_percentage <= 99.9)
            {
              add_items[cindex].unit_price = parseFloat(add_items[cindex].unit_price) + parseFloat($('#add_unit_price').val());
              add_items[cindex].quantity = parseFloat(add_items[cindex].quantity) + parseFloat($('#add_quantity').val());
              add_items[cindex].total_price = add_items[cindex].unit_price * add_items[cindex].quantity;

              alert("You're about "+stock_percentage+"% on the allowed maximum stock of the item!");
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            } else if (stock_percentage >= 100) {
              alert("You will reach the maximum stock level of the item! Action Cancelled!");
              resetItemDetails("add");
            }
          } else {
            add_items[cindex].unit_price = parseFloat(add_items[cindex].unit_price) + parseFloat($('#add_unit_price').val());
            add_items[cindex].quantity = parseFloat(add_items[cindex].quantity) + parseFloat($('#add_quantity').val());
            add_items[cindex].total_price = add_items[cindex].unit_price * add_items[cindex].quantity;

            renderItems(add_items,$('#items-dt tbody'),'add');
            resetItemDetails("add");
          }
         
        }else{
              var current_stocks = parseInt(current_stock);
              var stock_percentage = ((current_stocks / maximum_stock) * 100).toFixed(1); 
          if(stock_percentage >= 90)
          {
            if(stock_percentage <= 99.9)
            {
              add_items.push({ "item_code": $('#add_item_code').val(),
                          "inventory_location": $('#add_inventory_location').val(),
                          "currency_code": $('#add_currency_code').val(),
                          "currency": $('#add_currency_code option:selected').text(),
                          "unit_price": parseFloat($('#add_unit_price').val()),
                          "quantity": parseFloat($('#add_quantity').val()),
                          "total_price": parseFloat($('#add_unit_price').val())*parseFloat($('#add_quantity').val()),
                        });

              alert("You're about "+stock_percentage+"% on the allowed maximum stock of the item!");
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");
            } else if (stock_percentage >= 100) {
              alert("You will reach the maximum stock level of the item! Action Cancelled!");
              resetItemDetails("add");
            }
          } else {
            add_items.push({ "item_code": $('#add_item_code').val(),
                          "inventory_location": $('#add_inventory_location').val(),
                          "currency_code": $('#add_currency_code').val(),
                          "currency": $('#add_currency_code option:selected').text(),
                          "unit_price": parseFloat($('#add_unit_price').val()),
                          "quantity": parseFloat($('#add_quantity').val()),
                          "total_price": parseFloat($('#add_unit_price').val())*parseFloat($('#add_quantity').val()),
                        });

            renderItems(add_items,$('#items-dt tbody'),'add');
            resetItemDetails("add");
          }
        
        }

      }
    } else {
      if($('#edit_unit_price').val() <= 0){
        alert('Unit Price must be greater than 0!');
      }else if($('#edit_quantity').val() <= 0){
        alert('Quantity must be greater than 0!');
      }else{
        $.each(edit_items,(index,row) => {
          if(row.item_code == $('#edit_item_code').val()){
            cindex = index;
            found = true;
            return false;
          }
        });

        if(found){
              var current_stocks = parseInt(current_stock) + parseInt(edit_items[cindex].quantity);
              var stock_percentage = ((current_stocks / maximum_stock) * 100).toFixed(1);
          if(stock_percentage >= 90)
          {
            if(stock_percentage <= 99.9)
            {
              edit_items[cindex].unit_price = parseFloat(edit_items[cindex].unit_price) + parseFloat($('#edit_unit_price').val());
              edit_items[cindex].quantity = parseFloat(edit_items[cindex].quantity) + parseFloat($('#edit_quantity').val());
              edit_items[cindex].total_price = edit_items[cindex].unit_price * edit_items[cindex].quantity;

              alert("You're about "+stock_percentage+"% on the allowed maximum stock of the item!");

              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
              resetItemDetails("edit");
            } else if (stock_percentage >= 100) {
              alert("You will reach the maximum stock level of the item! Action Cancelled!");
              resetItemDetails("edit");
            }
          } else {
            edit_items[cindex].unit_price = parseFloat(edit_items[cindex].unit_price) + parseFloat($('#edit_unit_price').val());
            edit_items[cindex].quantity = parseFloat(edit_items[cindex].quantity) + parseFloat($('#edit_quantity').val());
            edit_items[cindex].total_price = edit_items[cindex].unit_price * edit_items[cindex].quantity;

            $('#btnEditSave').prop('disabled', false);
            renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
            resetItemDetails("edit");
          }
         
        }else{
              var current_stocks = parseInt(current_stock);
              var stock_percentage = ((current_stocks / maximum_stock) * 100).toFixed(1); 
          if(stock_percentage >= 90)
          {
            if(stock_percentage <= 99.9)
            {
              edit_items.push({ "item_code": $('#edit_item_code').val(),
                          "inventory_location": $('#edit_inventory_location').val(),
                          "currency_code": $('#edit_currency_code').val(),
                          "currency": $('#edit_currency_code option:selected').text(),
                          "unit_price": parseFloat($('#edit_unit_price').val()),
                          "quantity": parseFloat($('#edit_quantity').val()),
                          "total_price": parseFloat($('#edit_unit_price').val())*parseFloat($('#edit_quantity').val()),
                        });

              alert("You're about "+stock_percentage+"% on the allowed maximum stock of the item!");

              $('#btnEditSave').prop('disabled', false);
              renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
              resetItemDetails("edit");
            } else if (stock_percentage >= 100) {
              alert("You will reach the maximum stock level of the item! Action Cancelled!");
              resetItemDetails("edit");
            }
          } else {
            edit_items.push({ "item_code": $('#edit_item_code').val(),
                          "inventory_location": $('#edit_inventory_location').val(),
                          "currency_code": $('#edit_currency_code').val(),
                          "currency": $('#edit_currency_code option:selected').text(),
                          "unit_price": parseFloat($('#edit_unit_price').val()),
                          "quantity": parseFloat($('#edit_quantity').val()),
                          "total_price": parseFloat($('#edit_unit_price').val())*parseFloat($('#edit_quantity').val()),
                        });

            $('#btnEditSave').prop('disabled', false);
            renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
            resetItemDetails("edit");
          }
        
        }

      }
    }
  };

  

  const printModal = (id) => {
    console.log(id);
    $('#id').val(id);
    // $('#objectPDF').prop("data", "location/barcodes/"+id+"#toolbar=1&navpanes=0&scrollbar=1&page=1&zoom=100");
    $( "object" ).replaceWith('<object data="location/barcodes/'+id+'#toolbar=1&navpanes=0&scrollbar=1&page=1&zoom=100" type="application/pdf" width="100%" height="280px"></object>');
    $('#printModal').modal('open');
  };

  const trim = (str) => {
      return str.replace(/^\s+|\s+$/gm,'');
  };
    
  const openModal = () => {
    $('#add_site_code option[value=""]').prop('selected', true);
    $('#add_site_code').formSelect();
    $('#add_requestor option[value=""]').prop('selected', true);
    $('#add_requestor').formSelect();
    $('#add_purpose option[value=""]').prop('selected', true);
    $('#add_purpose').formSelect();
    $('#addModal').modal('open');
    loadApprover();
  };

  const closePrint = () => {
    $('#printModal').modal('close');
  }; 

  const loadApprover = () => {
    $.get('../approver/{{Auth::user()->emp_no}}/Issuance/my_matrix', (response) => {
      var data = response.data;
      var tabledata = '';
      if(data){
        var matrix = data.matrix;
        $.each(JSON.parse(matrix),(index, row) => {
            tabledata +=  '<tr>'+
                            '<td>'+row.sequence+'</td>'+
                            '<td>'+row.approver_emp_no+'</td>'+
                            '<td>'+row.approver_name+'</td>'+
                            '<input type="hidden" name="app_seq[]" value="'+row.sequence+'"/>'+
                            '<input type="hidden" name="app_id[]" value="'+row.approver_emp_no+'"/>'+
                            '<input type="hidden" name="app_fname[]" value="'+row.approver_name+'"/>'+
                            '<input type="hidden" name="app_nstatus[]" value="'+row.next_status+'"/>'+
                            '<input type="hidden" name="app_gate[]" value="'+row.is_gate+'"/>'+
                          '</tr>'
        });
        $('#matrix-dt tbody').html(tabledata);
      } else {
        
      }
    });
  };

  

  var issuance = $('#issuance-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/inventory/issuance/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<a href="#!" onclick="viewLocation('+data+')">'+ row.location_code; +'</a>';
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
                  return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editLocation('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+data+')"><i class="material-icons">delete</i></a> <a href="#" class="btn-small blue waves-effect waves-light" onclick="printModal('+data+')"><i class="material-icons">print</i></a>';
                }
            },   
        ]
  });

  </script>
    <!-- End of SCRIPTS -->
@endsection