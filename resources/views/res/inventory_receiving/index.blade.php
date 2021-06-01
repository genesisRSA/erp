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
                    <th>Site</th>
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

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('receiving.store')}}">
    @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Add Receiving Details</h4>

        <ul id="rcvTab" class="tabs">
          <li id="rcvs" class="tab col s12 m4 l4"><a class="active" href="#receiving">Receving Details</a></li>
          <li id="itms" class="tab col s12 m4 l4 disabled"><a href="#items">Item Details</a></li>
        </ul><br>
        
        <div id="receiving" name="receiving">
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

          <div class="row col s12 m12 l12" style="padding-bottom: 4px; margin-bottom: 30px;">
            <div class="col s12 m6 l6 left-align"></div>
            <div class="col s12 m6 l6 right-align" style="padding-right: 10px;padding-left: 12px;">
              <a href="#!" class="blue waves-effect waves-light btn" onclick="nextTab('itms','add')"><i class="material-icons left">arrow_forward</i>Next</a>
              <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
            </div>
          </div>
        </div>

        <div id="items" name="items">
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="add_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="">
              <span id="add_current_stock" name="add_current_stock" class="badge" style="font-size: 12px">Current Stock: 0</span>
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
              
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="add_inventory_location" name="inventory_location">
                <option value="" disabled selected>Choose your option</option>
                @foreach ($inventloc as $inventlocs)
                  <option value="{{$inventlocs->location_code}}">{{$inventlocs->location_name}}</option>
                @endforeach
              </select>
              <label for="inventory_location">Inventory Location<sup class="red-text">*</sup></label>
            </div>
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

          <div class="row">
            <div class="input-field col s12 m12 l12">
              <textarea class="materialize-textarea" type="text" id="add_remarks" name="remarks" placeholder="Please input remarks here.." style="height: 150px; border-left: 10px; border-color: black; padding-left:20px;" required disabled></textarea>
              <label for="remarks">Remarks<sup class="red-text">*</sup></label>
            </div>    
          </div>

          <div class="row col s12 m12 l12" style="padding-bottom: 4px; margin-bottom: 30px;">
            <div class="col s12 m3 l3 left-align" style="padding-right: 10px;padding-left: 12px;">
              <a href="#!" class="amber waves-effect waves-dark btn left-align" onclick="prevTab('rcvs','add')"><i class="material-icons left">arrow_back</i>Back</a>
            </div>
            <div class="col s12 m3 l3 left-align"></div>
            <div id="btnExit" class="col s12 m6 l6 right-align">
              <button id="btnAddSave" class="green waves-effect waves-light btn right-align" disabled><i class="material-icons left">check_circle</i>Save</button>
              <a href="#!" class="modal-close red waves-effect waves-dark btn right-align"><i class="material-icons left">cancel</i>Cancel</a>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>

  <div id="editModal" class="modal">
    <form method="POST" action="{{route('receiving.patch')}}">
      @csrf
      <div class="modal-content" style="padding-bottom: 0px;">
        <h4>Edit Receiving Details</h4>
        
        <ul id="edit_rcvTab" class="tabs">
          <li id="edit_rcvs" class="tab col s12 m4 l4"><a class="active" href="#edit_receiving">Receving Details</a></li>
          <li id="edit_itms" class="tab col s12 m4 l4 disabled"><a href="#edit_items">Item Details</a></li>
        </ul><br>
        
        <div id="edit_receiving" name="edit_receiving">
          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input type="hidden" id="edit_id" name="id">
              <input id="edit_receiving_code" name="receiving_code" type="text" class="validate" placeholder="" value="-RCV{{date('Ymd')}}-{{$count}}" required readonly>
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
              <input id="edit_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" required>
              <label for="delivery_date">Delivery Date<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input id="edit_delivery_no" name="delivery_no" type="text" class="validate" placeholder="" required readonly>
              <label for="delivery_no">Delivery No.<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="edit_po_no" name="po_no" type="text" class="validate" placeholder="" required readonly>
              <label for="po_no">P.O No.<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row col s12 m12 l12" style="padding-bottom: 4px; margin-bottom: 30px;">
            <div class="col s12 m6 l6 left-align"></div>
            <div class="col s12 m6 l6 right-align" style="padding-right: 10px;padding-left: 12px;">
              <a href="#!" class="blue waves-effect waves-light btn" onclick="nextTab('edit_itms','edit')"><i class="material-icons left">arrow_forward</i>Next</a>
              <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
            </div>
          </div>
        </div>

        <div id="edit_items" name="edit_items">
          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="edit_item_code" name="item_code" type="text" class="validate" autocomplete="" placeholder="">
              <span id="edit_current_stock" name="edit_current_stock" class="badge" style="font-size: 12px">Current Stock: 0</span>
              <label for="item_code">Item Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="edit_inventory_location" name="inventory_location">
                <option value="" disabled selected>Choose your option</option>
                @foreach ($inventloc as $inventlocs)
                  <option value="{{$inventlocs->location_code}}">{{$inventlocs->location_name}}</option>
                @endforeach
              </select>
              <label for="inventory_location">Inventory Location<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <select id="edit_currency_code" name="currency_code">
                <option value="" disabled selected>Choose your option</option>
                @foreach ($currency as $currency)
                  <option value="{{$currency->currency_code}}">{{$currency->symbol}} - {{$currency->currency_name}}</option>
                @endforeach
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="edit_quantity" name="quantity" type="number" class="validate" placeholder="">
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6">
              <input id="edit_unit_price" name="unit_price" type="number" class="validate" placeholder="">
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input id="edit_total_price" name="total_price" type="text" class="validate" placeholder="" readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" style="margin-bottom: 0px;">
            <div class="input-field col s12 m6 l6 left-align">
              <button type="button" class="blue waves-effect waves-light btn right-align" id="edit_btnAdd"><i class="material-icons left">add_circle</i>Add Item</button>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="edit_items-dt">
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

          <div class="row">
            <div class="input-field col s12 m12 l12">
              <textarea class="materialize-textarea" type="text" id="edit_remarks" name="remarks" placeholder="Please input remarks here.." style="height: 150px; border-left: 10px; border-color: black; padding-left:20px;" required></textarea>
              <label for="remarks">Remarks<sup class="red-text">*</sup></label>
            </div>    
          </div>

          <div class="row col s12 m12 l12" style="padding-bottom: 4px; margin-bottom: 30px;">
            <div class="col s12 m3 l3 left-align" style="padding-right: 10px;padding-left: 12px;">
              <a href="#!" class="amber waves-effect waves-dark btn left-align" onclick="prevTab('edit_rcvs','edit')"><i class="material-icons left">arrow_back</i>Back</a>
            </div>
            <div class="col s12 m3 l3 left-align"></div>
            <div id="btnExit" class="col s12 m6 l6 right-align">
              <button id="btnEditSave" class="green waves-effect waves-light btn right-align" disabled><i class="material-icons left">check_circle</i>Save</button>
              <a href="#!" class="modal-close red waves-effect waves-dark btn right-align"><i class="material-icons left">cancel</i>Cancel</a>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
  
  <div id="viewModal" class="modal">
    <div class="modal-content" style="padding-bottom: 0px;">
      <h4>Receiving Details</h4> 

        <div class="row" style="margin-bottom: 0px;"> 
          <div class="input-field col s12 m6 l6">
            <input id="view_receiving_code" name="receiving_code" type="text" class="validate" placeholder="" required readonly>
            <label for="receiving_code">Receiving Code<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <select id="view_site_code" name="site_code" required disabled>
              <option value="" disabled selected>Choose your option</option>
              @foreach ($site as $sites)
                <option value="{{$sites->site_code}}">{{$sites->site_desc}}</option>
              @endforeach
            </select>
            <label for="site_code">Site<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_delivery_date" name="delivery_date" type="text" class="datepicker" placeholder="" required disabled>
            <label for="delivery_date">Delivery Date<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m6 l6">
            <input id="view_delivery_no" name="delivery_no" type="text" class="validate" placeholder="" required readonly>
            <label for="delivery_no">Delivery No.<sup class="red-text"></sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <input id="view_po_no" name="po_no" type="text" class="validate" placeholder="" required readonly>
            <label for="po_no">P.O No.<sup class="red-text"></sup></label>
          </div>
        </div>

        <div class="row" style="margin-bottom: 0px;">
          <div class="input-field col s12 m12 l12">
            <textarea class="materialize-textarea" type="text" id="view_remarks" name="remarks" placeholder="Please input remarks here.." style="height: 150px; border-left: 10px; border-color: black; padding-left:20px;" disabled></textarea>
            <label for="remarks">Remarks<sup class="red-text"></sup></label>
          </div>   
        </div>

        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; margin-top: 0px; background-color:#0d47a1" class="white-text"><b>Item List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight" id="view_items-dt">
                  <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Currency</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row col s12 m12 l12" style="padding-bottom: 4px; margin-bottom: 30px;">
          <div class="col s12 m6 l6 left-align"></div>
          <div class="col s12 m6 l6 right-align" style="padding-right: 10px;padding-left: 12px;">
            <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
          </div>
        </div>

    </div>
  </div>

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('receiving.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Inventory Receiving</h4><br><br>
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

  <div id="removeItemModal" class="modal">
    <div class="modal-content">
      <h4>Remove Item</h4>
      <div class="row">
          <div class="col s12 m12 l12">
              <input type="hidden" name="id" id="del_index">
              <p>Are you sure you want to remove this <strong>Item</strong> on the list?</p>
          </div>
      </div>
    </div>
    <div class="modal-footer">
        <a onclick="removeItem();" class="green waves-effect waves-dark btn"><i class="material-icons left">check_circle</i>Yes</a>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>No</a>
    </div>
  </div>

  <!-- End of MODALS -->

    <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

    var delCount = {{$count}};
    const str = new Date().toISOString().slice(0, 10);
    var newtoday = str.replace(/[^a-zA-Z0-9]/g,"");
    
    var add_items = [];
    var edit_items = [];
    var view_items = [];

    $(document).ready(function () {
              
        $.get('/api/reiss/item_master/all', (response) => {
          var data = response.data;
          var autodata = {};
          for(var i = 0; i < data.length; i++)
          {
            autodata[data[i].item_code] = 'https://icons.iconarchive.com/icons/icojam/blueberry-basic/32/check-icon.png';
          }
          $('input#add_item_code').autocomplete({
            data : autodata,
          });

          $('input#edit_item_code').autocomplete({
            data : autodata,
          });

          $('input#add_item_code').keypress(function(event) {
              if (event.keyCode == 13) {
                  event.preventDefault();
              }
          });

          $('input#edit_item_code').keypress(function(event) {
              if (event.keyCode == 13) {
                  event.preventDefault();
              }
          });
        });

        $('#add_site_code').on('change', function(){
          deliveryCode($(this).val(),'add');
        });

        $('#add_item_code').on('blur', function(){
          if($('#add_inventory_location').val())
          {
            $.get('receiving/'+$('#add_item_code').val()+'/'+$('#add_inventory_location').val()+'/getCurrentStock', (response) => {
              $('#add_current_stock').html('Current Stock: '+response.data);
            });
          }
          $('#add_item_code').prop('disabled', true);
        });

        $('#add_inventory_location').on('change', function(){
          if($('#add_item_code').val())
          {
            $.get('receiving/'+$('#add_item_code').val()+'/'+$('#add_inventory_location').val()+'/getCurrentStock', (response) => {
              $('#add_current_stock').html('Current Stock: '+response.data);
            });
          }
        });

        $('#add_unit_price').on('keyup', function(){
          this.value = this.value.replace(/[^0-9\.]/g,'');
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_quantity').on('keyup', function(){
          this.value = this.value.replace(/[^0-9\.]/g,'');
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_currency_code').on('change', function(){
          computeTotalPrice(($('#add_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#add_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
        });

        $('#add_remarks').on('keyup', function(){
          if(this.value.length > 0)
          { 
            if(trim($(this).val())){
              $('#btnAddSave').prop('disabled', false);
            }
          } else {
            $('#btnAddSave').prop('disabled', true);
          }
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
                $.get('receiving/'+item.item_code+'/'+$('#add_inventory_location').val()+'/getCurrentStock', (response) => {
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



        $('#edit_site_code').on('change', function(){
          deliveryCode($(this).val(),'edit');
        });

        $('#edit_item_code').on('blur', function(){
          if($('#edit_inventory_location').val())
          {
            $.get('receiving/'+$('#edit_item_code').val()+'/'+$('#edit_inventory_location').val()+'/getCurrentStock', (response) => {
              $('#edit_current_stock').html('Current Stock: '+response.data);
            });
          }
          $('#edit_item_code').prop('disabled', true);
        });

        $('#edit_inventory_location').on('change', function(){
          if($('#edit_item_code').val())
          {
            $.get('receiving/'+$('#edit_item_code').val()+'/'+$('#edit_inventory_location').val()+'/getCurrentStock', (response) => {
              $('#edit_current_stock').html('Current Stock: '+response.data);
            });
          }
        });

        $('#edit_unit_price').on('keyup', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#edit_unit_price').val()),parseFloat($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_quantity').on('keyup', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#edit_unit_price').val()),parseFloat($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_currency_code').on('change', function(){
          computeTotalPrice(($('#edit_currency_code option:selected').text().split(" - ")[0] == "Choose your option" ? "" : $('#edit_currency_code option:selected').text().split(" - ")[0]),parseFloat($('#edit_unit_price').val()),parseFloat($('#edit_quantity').val()),$('#edit_total_price'));
        });

        $('#edit_remarks').on('keyup', function(){
          if(this.value.length > 0)
          { 
            if(trim($(this).val())){
              $('#btnEditSave').prop('disabled', false);
            }
          } else {
            $('#btnEditSave').prop('disabled', true);
          }
        });

        $('#edit_btnAdd').on('click', function(){
          if($('#edit_item_code').val() &&
              $('#edit_inventory_location').val() &&
              $('#edit_currency_code').val() &&
              $('#edit_quantity').val() &&
              $('#edit_unit_price').val() &&
              $('#edit_total_price').val()
          ){
            $.get('../item_master/getItemDetails/'+$('#edit_item_code').val(), (response) => {
              var item = response.data;
              if(item){
                $.get('receiving/'+item.item_code+'/'+$('#add_inventory_location').val()+'/getCurrentStock', (response) => {
                  var current_stock = parseInt(response.data) + parseInt($('#edit_quantity').val());
                  var maximum_stock = parseInt(item.maximum_stock);
                  addItem('edit',current_stock, maximum_stock);
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
    
    const deliveryCode = (site, loc) => {
        if(loc=="add"){
          $('#add_receiving_code').val( site + '-RCV' + newtoday + '-00' + delCount);
        } else {
          var str = $('#edit_receiving_code').val();
          var count = str.substr(-3, 3);
          $('#edit_receiving_code').val( site + '-RCV' + newtoday + '-00' + count);
        }
    };

    const nextTab = (tab, loc) => {
      if(loc=='add')
      {
        $.get('receiving/'+trim($('#add_delivery_no').val())+'/DR', (response) => {
          var data = response.data;
          if(data.length > 0)
          {
            alert('Delivery no. already exist! Please check DR before proceeding..');
          } else {

            var currentDate = "{{date('Y-m-d')}}";
            if(currentDate > trim($('#add_delivery_date').val()))
            {
                alert("You're not allowed to receive late deliveries!");
            } else {
              if(trim($('#add_site_code').val()) && 
                trim($('#add_delivery_date').val()) && 
                trim($('#add_delivery_no').val()) && 
                trim($('#add_po_no').val()))
              {
                $('#'+tab).removeClass("disabled");   
                $('#rcvs').addClass("disabled");
                $('.tabs').tabs('select', 'items');
                $('.tabs').tabs();
              } else {
                alert('Please fill up all receiving details!');
              }
            }
          }
        });  
      } else {
            if(trim($('#edit_site_code').val()) && 
              trim($('#edit_delivery_date').val()) && 
              trim($('#edit_delivery_no').val()) && 
              trim($('#edit_po_no').val()))
            {
              $('#'+tab).removeClass("disabled");   
              $('#edit_rcvs').addClass("disabled");
              $('.tabs').tabs('select', 'edit_items');
              $('.tabs').tabs();
            } else {
              alert('Please fill up all receiving details!');
            }
      }
    };

    const prevTab = (tab, loc) => {
      if(loc=='add'){
        $('#'+tab).removeClass("disabled");   
        $('#itms').addClass("disabled");
        $('.tabs').tabs('select', 'receiving');
        $('.tabs').tabs();
      } else {
        $('#'+tab).removeClass("disabled");   
        $('#edit_itms').addClass("disabled");
        $('.tabs').tabs('select', 'edit_receiving');
        $('.tabs').tabs();
      }
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
          if(items.length > 0){
            $('#add_remarks').prop('disabled', false);
          } else {
            $('#add_remarks').prop('disabled', true);
          };
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

    const addItem = (loc, current_stock = 0, maximum_stock = 0) => {
      var found = false;
      var cindex = 0;
      if(loc=='add')
      {
    
        if(parseFloat($('#add_unit_price').val()) <= 0){
          alert('Unit Price must be greater than 0!');
        }else if(parseFloat($('#add_quantity').val()) <= 0){
          alert('Quantity must be greater than 0!');
        }else{
          $.each(add_items,(index,row) => {
            if(row.item_code == $('#add_item_code').val() && row.inventory_location == $('#add_inventory_location').val()){
              cindex = index;
              found = true;
              return false;
            }
          });

          if(found){

              var current_stocks = parseInt(current_stock) + parseInt(add_items[cindex].quantity);
              add_items[cindex].currency_code = $('#add_currency_code').val();
              add_items[cindex].currency = $('#add_currency_code option:selected').text();
              add_items[cindex].unit_price = parseFloat($('#add_unit_price').val());
              add_items[cindex].quantity = parseFloat(add_items[cindex].quantity) + parseFloat($('#add_quantity').val());
              add_items[cindex].total_price = add_items[cindex].unit_price * add_items[cindex].quantity;
              if(current_stocks > maximum_stock)
              {
                alert("You're above the maximum stock level of the item!");
              } else  if(current_stocks == maximum_stock) {
                alert("You reach the maximum stock level of the item!");
              } 
              $('#add_item_code').prop('disabled', false);
              $('#add_current_stock').html('Current Stock: 0');
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");

          }else{

              var current_stocks = parseInt(current_stock);
              add_items.push({ "item_code": $('#add_item_code').val(),
                          "inventory_location": $('#add_inventory_location').val(),
                          "currency_code": $('#add_currency_code').val(),
                          "currency": $('#add_currency_code option:selected').text(),
                          "unit_price": parseFloat($('#add_unit_price').val()),
                          "quantity": parseFloat($('#add_quantity').val()),
                          "total_price": parseFloat($('#add_unit_price').val())*parseFloat($('#add_quantity').val()),
                        });
              if(current_stocks > maximum_stock)
              {
                alert("You're above the maximum stock level of the item!");
              } else  if(current_stocks == maximum_stock) {
                alert("You reach the maximum stock level of the item!");
              } 
              $('#add_item_code').prop('disabled', false);
              $('#add_current_stock').html('Current Stock: 0');
              renderItems(add_items,$('#items-dt tbody'),'add');
              resetItemDetails("add");

          }

        }
      } else {
        if($('#edit_unit_price').val() <= 0){
          alert('Unit Price must be greater than 0!');
        }else if($('#edit_quantity').val() <= 0){
          alert('Quantity must be greater than 0!');
        }else{
          $.each(edit_items,(index,row) => {
            if(row.item_code == $('#edit_item_code').val()  && row.inventory_location == $('#edit_inventory_location').val() ){
              cindex = index;
              found = true;
              return false;
            }
          });

          if(found){
            alert("You're not allowed to add quantity of the said item! Please create another receiving to add it on inventory.");
            $('#edit_item_code').prop('disabled', false);
            $('#edit_item_code').val("");
            $('#edit_quantity').prop('disabled', false);
            $('#edit_quantity').val("");
            $('#edit_unit_price').prop('disabled', false);
            $('#edit_unit_price').val("");
 
            $('#edit_total_price').val("");

            $('#edit_inventory_location option[value=""]').prop('selected', true);
            $('#edit_inventory_location').prop('disabled', false);
            $('#edit_currency_code option[value=""]').prop('selected', true);
            $('#edit_currency_code').prop('disabled', false);

          }else{
              var current_stocks = parseInt(current_stock);
            if(current_stocks >= maximum_stock)
            {
              edit_items.push({ "item_code": $('#edit_item_code').val(),
                          "inventory_location": $('#edit_inventory_location').val(),
                          "currency_code": $('#edit_currency_code').val(),
                          "currency": $('#edit_currency_code option:selected').text(),
                          "unit_price": parseFloat($('#edit_unit_price').val()),
                          "quantity": parseFloat($('#edit_quantity').val()),
                          "total_price": parseFloat($('#edit_unit_price').val())*parseFloat($('#edit_quantity').val()),
                        });

              if(current_stocks > maximum_stock)
              {
                alert("You're above the maximum stock level of the item!");
              } else  if(current_stocks = maximum_stock) {
                alert("You reach the maximum stock level of the item!");
              } 

              $('#btnEditSave').prop('disabled', false);
              $('#edit_current_stock').html('Current Stock: 0');
              renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
              resetItemDetails("edit");
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
              $('#edit_current_stock').html('Current Stock: 0');
              renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
              resetItemDetails("edit");
            }
          
          }

        }
      }
    }

    const removeItem = () => {
        var index = $('#del_index').val();
        add_items.splice(index,1);
        $('#removeItemModal').modal('close');
        renderItems(add_items,$('#items-dt tbody'),'add');
        if(add_items.length  == 0 ){ $('#btnAddSave').prop('disabled', true); $('#add_item_code').prop('disabled', false);}
    };

    const deleteItem = (index,loc) => {
      $('#del_index').val(index);
      $('#removeItemModal').modal('open');
    };

    const deleteReceiving = (id) => {
      $('#del_id').val(id);
      $('#deleteModal').modal('open');
    };

    const openModal = () => {
      $('#rcvs').removeClass("disabled");   
      $('#itms').addClass("disabled");
      $('.tabs').tabs('select', 'receiving');

      $('#btnAddSave').prop('disabled', true);
      $('#add_site_code option[value=""]').prop('selected', true);
      $('#add_site_code').formSelect();
      $('#add_receiving_code').val('-RCV{{date('Ymd')}}-{{$count}}');
      $('#add_delivery_date').val("");
      $('#add_delivery_no').val("");
      $('#add_po_no').val("");
      add_items = []
      renderItems(add_items,$('#items-dt tbody'),'edit');
      resetItemDetails('add');

      $('#addModal').modal('open');
    };

    const editReceiving = (id) => {
        $('#edit_rcvs').removeClass("disabled");   
        $('#edit_itms').addClass("disabled");
        $('.tabs').tabs('select', 'edit_receiving');
        $('#editModal').modal('open');
        edit_items = [];
      $.get('receiving/'+id, (response) => {
        var data = response.data;
        $('#edit_id').val(id);
        $('#edit_site_code option[value="'+data.site_code+'"]').prop('selected', true);
        $('#edit_site_code').formSelect();
        
        $('#edit_receiving_code').val(data.receiving_code);
        $('#edit_delivery_date').val(data.delivery_date);
        $('#edit_delivery_no').val(data.delivery_no);
        $('#edit_po_no').val(data.po_no);
        $('#edit_remarks').val(data.remarks);

        M.updateTextFields();
        $('.materialize-textarea').each(function (index) {
            M.textareaAutoResize(this);
        });

        $.get('receiving/'+data.receiving_code+'/items', (response) => {
          var data = response.data;
          $.each(data, (index, row) => {
            edit_items.push({"item_code": row.item_code,
                            "inventory_location": row.inventory_location_code,
                            "currency_code": row.currency_code,
                            "currency": row.currency.symbol + ' - ' + row.currency.currency_name,
                            "unit_price":  row.unit_price,
                            "quantity": row.quantity,
                            "total_price":  row.total_price,
                            });
          });
          renderItems(edit_items,$('#edit_items-dt tbody'),'edit');
        });
      });
    };

    const viewReceiving = (id) => {
        view_items = [];
        $('#viewModal').modal('open');
      $.get('receiving/'+id, (response) => {
        var data = response.data;
        $('#view_id').val(id);
        $('#view_site_code option[value="'+data.site_code+'"]').prop('selected', true);
        $('#view_site_code').formSelect();
  
        $('#view_receiving_code').val(data.receiving_code);
        $('#view_delivery_date').val(data.delivery_date);
        $('#view_delivery_no').val(data.delivery_no);
        $('#view_po_no').val(data.po_no);
        $('#view_remarks').html(data.remarks);
        
        M.updateTextFields();
        $('.materialize-textarea').each(function (index) {
            M.textareaAutoResize(this);
        });

        $.get('receiving/'+data.receiving_code+'/items', (response) => {
          var data = response.data;
          $.each(data, (index, row) => {
            view_items.push({"item_code": row.item_code,
                            "inventory_location": row.inventory_location_code,
                            "currency_code": row.currency_code,
                            "currency": row.currency.symbol + ' - ' + row.currency.currency_name,
                            "unit_price":  row.unit_price,
                            "quantity": row.quantity,
                            "total_price":  row.total_price,
                            });
          });
          renderItems(view_items,$('#view_items-dt tbody'),'view');
        });
      });
    };

    const trim = (str) => {
        return str.replace(/^\s+|\s+$/gm,'');
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
                    return row.sites.site_desc;
                  }
              },
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
 
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editReceiving('+data+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteReceiving('+data+')" disabled><i class="material-icons">delete</i></a>';
                  }
              },   
          ]
    });

  </script>
    <!-- End of SCRIPTS -->
@endsection