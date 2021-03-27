@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales <i class="material-icons">arrow_forward_ios</i></span> Sales Order</h4>
    </div>
  </div>
  <div class="row main-content">
  
    {{-- <ul id="tabs-swipe-demo" class="tabs"> --}}
    <ul id="quotation_tab" class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#ongoing">Sales Order</a></li>
      <li class="tab col s12 m4 l4"><a href="#approval">For Approval</a></li>
    </ul>

    <div id="ongoing" name="ongoing">

        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="order-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Site</th>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
      </div>
      <a href="#askModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button"  data-position="left" data-tooltip="Add Sales Order"><i class="material-icons">add</i></a>
    </div>

    <div id="approval" name="approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Site</th>
                    <th>Order Code</th>
                    <th>Filed By</th>
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
  <div id="askModal" class="modal dismissable">
    <div class="modal-content">
      <h4>Sales Order</h4><i class="material-icons left">assignment</i>
      <p>Do you want to create an order based on your sales quotation?</p>
    </div>
    <div class="modal-footer">
      <a href="#addModal" class="modal-close green waves-effect waves-dark btn modal-trigger" id="showaddQuotation"><i class="material-icons left">check_circle</i>Yes</a>
      <a href="#addModal" class="modal-close red waves-effect waves-dark btn modal-trigger" id="showaddModal"><i class="material-icons left">highlight_off</i>No</a>
    </div>
  </div>

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('order.store')}}" enctype="multipart/form-data">
      {{-- <form> --}}
      @csrf
      <div class="modal-content">
        <h4>Add Sales Order</h4>
        <ul id="tabs-swipe-demo" class="tabs add">
          <li class="tab col s12 m4 l4"><a class="active" href="#order">Order Details</a></li>
          {{-- need auth ID and module for getApprover()  --}}
          <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="order" name="order">

          <div class="row" id="rowQouteAdd">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="add_order_code" name="order_code" value="{{$lastid}}" readonly/>
              <label for="order_code">Order Code<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" id="rowQouteAdd">
            <div class="input-field col s12 m6 l6">
              <select id="add_customer_code">
                <option value="" disabled selected>Choose Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{$customer->cust_code}}">{{$customer->cust_name}}</option>
                @endforeach
              </select>
              <input type="hidden" id="customer_code" name="customer_code"/>
              <label class="active">Customer<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="add_quotation_code">
                <option value="" disabled selected>Choose Quotation</option>
              </select>
              <input type="hidden" id="quotation_code" name="quotation_code"/>
              <label class="active">Quotation<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row" id="rowAdd">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="add_order_code" name="order_code" value="{{$lastid}}" readonly/>
              <label for="order_code">Order Code<sup class="red-text">*</sup></label>
            </div>
        
            <div class="input-field col s12 m6 l6">
              <select id="add_customer_code">
                <option value="" disabled selected>Choose Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{$customer->cust_code}}">{{$customer->cust_name}}</option>
                @endforeach
              </select>
              <input type="hidden" id="customer_code" name="customer_code"/>
              <label class="active">Customer<sup class="red-text">*</sup></label>
            </div>
          </div>
          
          <div class="row">
            <div class="input-field col s12 m6 l6">
              <select id="add_payment_term" required>
                <option value="" disabled selected>Choose Payment Term</option>
                @foreach ($payment as $payments)
                  <option value="{{$payments->id}}">{{$payments->term_name}}</option>
                @endforeach
              </select>
              <input type="hidden" id="payment_term" name="payment_term"/>
              <label class="active">Payment Term<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="add_currency_code" required>
                <option value="" disabled selected>Choose Currency</option>
                @foreach ($currencies as $curr)
                  <option value="{{$curr->currency_code}}">{{$curr->symbol}} - {{$curr->currency_name}}</option>
                @endforeach
              </select>
              <input type="hidden" id="currency_code" name="currency_code"/>
              <label class="active">Currency<sup class="red-text">*</sup></label>
            </div>
          </div>
          
          <div class="row">
            <div class="input-field file-field col s12 m6 l6">
                <label class="active">Customer PO Specs <sup class="red-text">*</sup></label><br>
                <div class="btn">
                    <span>Upload file</span>
                    <input type="file" id="customer_po_specs" name="customer_po_specs" required>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" id="customer_po_specs_filename" type="text">
                </div>
            </div>

            <div class="input-field col s12 m6 l6">
              <input type="text" name="customer_po_no" id="customer_po_no" placeholder="e.g. PO-1234" required/>
              <label class="active">Customer PO No.<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m12 l12 right-align">
              <button type="button" class="orange waves-effect waves-light btn" id="btn_add_reset" style="display:none;"><i class="material-icons left">cached</i>Reset Details</button>
            </div>
          </div>

          <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 1em; background-color:#0d47a1" class="white-text"><b>Product Details</b></h6>
          
          <div class="row">
            <div class="input-field col s12 m4 l4">
              <select id="add_site_code" name="site_code" disabled="true">
                <option value="" disabled selected>Choose Site</option>
                @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l5">
              <select id="add_prod_code" name="prod_code" disabled="true">
                <option value="" disabled selected>Choose Product</option>
              </select>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="add_uom_code" name="uom_code" disabled="true">
                <option value="" disabled selected>Choose Unit of Measure</option>
                @foreach ($uoms as $uom)
                  <option value="{{$uom->uom_code}}">{{$uom->uom_name}}</option>
                @endforeach
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row" style="margin-bottom: 0px">
            <div class="input-field col s12 m4 l4">
              <input placeholder="0.00" id="add_unit_price" name="unit_price" type="number" style="text-align: right" class="number validate" readonly>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="add_quantity" name="quantity" type="number" style="text-align: right" class="number validate" readonly>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="add_total_price" name="total_price" type="text" style="text-align: right" class="number" readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
            
            <div class="input-field col s12 m12 l12">
              <button type="button" class="blue waves-effect waves-light btn right-align" id="btnAdd" disabled="true"><i class="material-icons left">add_circle</i>Add Product</button>
            </div>
          </div>
           
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Product List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="product-dt">
                    <thead>
                      <tr>
                          <th class="center-align">Product Code</th> 
                          <th class="center-align">Product Name</th> 
                          <th class="center-align">Unit of Measure</th>
                          <th class="center-align">Currency</th>
                          <th class="center-align">Unit Price</th>
                          <th class="center-align">Quantity</th>
                          <th class="center-align">Total Price</th>
                          <th class="center-align">Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="row col s12 m12 l12">
              <div class="col s12 m8 l8"></div>
              <div class="col s12 m4 l4 right-align">
              <input placeholder="0" id="add_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
              <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
            </div>
          </div>
          
        </div>

        <div id="signatories" name="signatories">

          {{-- current signatories --}}
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
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn" id="btnAddSave" disabled><i class="material-icons left">check_circle</i>Save</button>
        <button type="button" id="closeAddModal" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</button>
      </div>
    </form>
  </div>

  <!--editModal-->
  <div id="editModal" class="modal">
    <form method="POST" action="{{route('quotation.patch')}}">
    @csrf
      <div class="modal-content">
        <h4>Edit Sales Quotation</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#edit-quotation">Quotation Details</a></li>
          {{-- need auth ID and module for getApprover()  --}}
          <li class="tab col s12 m4 l4"><a href="#edit-signatories" onclick="getApprover(2,'edit','Sales Quotation');">Signatories</a></li>
        </ul><br>

        <div id="edit-quotation" name="quotation">
            <input type="hidden" id="edit_id" name="id">
          <div class="row" style="display: none" id="efcode">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="edit_forecast_code" name="forecast_code" placeholder="0" readonly/>
              <label for="forecast_code">Forecast Code<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row">

            <div class="input-field col s12 m6 l6">
              <input type="text" id="edit_quotation_code" name="quotation_code" placeholder="0" readonly/>
              <label for="quotation_code">Quotation Code<sup class="red-text">*</sup></label>
            </div>
        
            <div class="input-field col s12 m6 l6">
              <select id="edit_customer_code" name="customer_code">
                <option value="" disabled selected>Choose Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{$customer->cust_code}}">{{$customer->cust_name}}</option>
                @endforeach
              </select>
              <label for="customer_code">Customer<sup class="red-text">*</sup></label>
            </div>

          </div>
          
          <div class="row">
            <div class="input-field col s12 m6 l6">
              <select id="edit_payment_term" name="payment_term" required>
                <option value="0" disabled selected>Choose Payment Term</option>
                @foreach ($payment as $payments)
                  <option value="{{$payments->id}}">{{$payments->term_name}}</option>
                @endforeach
              </select>
              <label for="payment_term">Payment Term<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="edit_currency_code" name="currency_code" onchange="computeTotal('edit');" required>
                <option value="0" disabled selected>Choose Currency</option>
                @foreach ($currencies as $curr)
                  <option value="{{$curr->currency_code}}">{{$curr->symbol}} - {{$curr->currency_name}}</option>
                @endforeach
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>
          </div>

          <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 1em; background-color:#0d47a1" class="white-text"><b>Product Details</b></h6>
          
          <div class="row">
            <div class="input-field col s12 m4 l4">
              <select id="edit_site_code" name="site_code" required>
                <option value="" disabled selected>Choose Site</option>
                @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l5">
              <select id="edit_prod_code" name="prod_code" required>
                <option value="" disabled selected>Choose Product</option>
              </select>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="edit_uom_code" name="uom_code" required>
                <option value="0" disabled selected>Choose Unit of Measure</option>
                @foreach ($uoms as $uom)
                  <option value="{{$uom->uom_code}}">{{$uom->uom_name}}</option>
                @endforeach
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row" style="margin-bottom: 0px">
            <div class="input-field col s12 m4 l4">
              <input placeholder="0.00" id="edit_unit_price" name="unit_price" type="number" style="text-align: right" class="number validate"required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="edit_quantity" name="quantity" type="number" style="text-align: right" class="number validate"required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="edit_total_price" name="total_price" type="text" style="text-align: right" class="number" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
            
            <div class="input-field col s12 m12 l12">
              <a class="blue waves-effect waves-light btn right-align" id="btnAdd"><i class="material-icons left">add_circle</i>Add Product</a>
            </div>

          </div>
           
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Product List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="product-dt-e">
                    <thead>
                      <tr>
                          {{-- <th></th> --}}
                          <th class="left-align">Product Code</th> 
                          <th class="left-align">Product Name</th> 
                          <th class="left-align">Unit of Measure</th>
                          <th class="left-align">Currency</th>
                          <th class="left-align">Unit Price</th>
                          <th class="left-align">Quantity</th>
                          <th class="left-align">Total Price</th>
                          <th class="left-align">Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="row col s12 m12 l12">
              <div class="col s12 m8 l8"></div>
              <div class="col s12 m4 l4 right-align">
              <input placeholder="0" id="edit_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
              <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
            </div>
          </div>
          
        </div>

        <div id="edit-signatories" name="signatories">

          {{-- current signatories --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
 
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-e">
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
      <div class="modal-footer">
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Update</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>
  
  <!--viewModal-->
  <div id="viewModal" class="modal">
    <div class="modal-content">
      <h4>Sales Order</h4>
      <ul id="tabs-swipe-demo" class="tabs add">
        <li class="tab col s12 m4 l4"><a class="active" href="#order">Order Details</a></li>
        {{-- need auth ID and module for getApprover()  --}}
        <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
      </ul><br>

      <div id="order" name="order">

        <div class="row" id="rowQouteAdd">
          <div class="input-field col s12 m6 l6">
            <input type="text" id="add_order_code" name="order_code" value="{{$lastid}}" readonly/>
            <label for="order_code">Order Code<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row" id="rowQouteAdd">
          <div class="input-field col s12 m6 l6">
            <select id="add_customer_code">
              <option value="" disabled selected>Choose Customer</option>
              @foreach ($customers as $customer)
                <option value="{{$customer->cust_code}}">{{$customer->cust_name}}</option>
              @endforeach
            </select>
            <input type="hidden" id="customer_code" name="customer_code"/>
            <label class="active">Customer<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <select id="add_quotation_code">
              <option value="" disabled selected>Choose Quotation</option>
            </select>
            <input type="hidden" id="quotation_code" name="quotation_code"/>
            <label class="active">Quotation<sup class="red-text">*</sup></label>
          </div>
        </div>
        
        <div class="row">
          <div class="input-field col s12 m6 l6">
            <select id="add_payment_term" required>
              <option value="" disabled selected>Choose Payment Term</option>
              @foreach ($payment as $payments)
                <option value="{{$payments->id}}">{{$payments->term_name}}</option>
              @endforeach
            </select>
            <input type="hidden" id="payment_term" name="payment_term"/>
            <label class="active">Payment Term<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m6 l6">
            <select id="add_currency_code" required>
              <option value="" disabled selected>Choose Currency</option>
              @foreach ($currencies as $curr)
                <option value="{{$curr->currency_code}}">{{$curr->symbol}} - {{$curr->currency_name}}</option>
              @endforeach
            </select>
            <input type="hidden" id="currency_code" name="currency_code"/>
            <label class="active">Currency<sup class="red-text">*</sup></label>
          </div>
        </div>
        
        <div class="row">
          <div class="input-field file-field col s12 m6 l6">
              <label class="active">Customer PO Specs <sup class="red-text">*</sup></label><br>
              <div class="btn">
                  <span>Upload file</span>
                  <input type="file" id="customer_po_specs" name="customer_po_specs" required>
              </div>
              <div class="file-path-wrapper">
                  <input class="file-path validate" id="customer_po_specs_filename" type="text">
              </div>
          </div>

          <div class="input-field col s12 m6 l6">
            <input type="text" name="customer_po_no" id="customer_po_no" placeholder="e.g. PO-1234" required/>
            <label class="active">Customer PO No.<sup class="red-text">*</sup></label>
          </div>
        </div>

        <div class="row">
          <div class="col s12 m12 l12 right-align">
            <button type="button" class="orange waves-effect waves-light btn" id="btn_add_reset" style="display:none;"><i class="material-icons left">cached</i>Reset Details</button>
          </div>
        </div>

        <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 1em; background-color:#0d47a1" class="white-text"><b>Product Details</b></h6>
        
        <div class="row">
          <div class="input-field col s12 m4 l4">
            <select id="add_site_code" name="site_code" disabled="true">
              <option value="" disabled selected>Choose Site</option>
              @foreach ($sites as $site)
                <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
              @endforeach
            </select>
            <label for="site_code">Site<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l5">
            <select id="add_prod_code" name="prod_code" disabled="true">
              <option value="" disabled selected>Choose Product</option>
            </select>
            <label for="prod_code">Product<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l3">
            <select id="add_uom_code" name="uom_code" disabled="true">
              <option value="" disabled selected>Choose Unit of Measure</option>
              @foreach ($uoms as $uom)
                <option value="{{$uom->uom_code}}">{{$uom->uom_name}}</option>
              @endforeach
            </select>
            <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
          </div>

        </div>

        <div class="row" style="margin-bottom: 0px">
          <div class="input-field col s12 m4 l4">
            <input placeholder="0.00" id="add_unit_price" name="unit_price" type="number" style="text-align: right" class="number validate" readonly>
            <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <input placeholder="0" id="add_quantity" name="quantity" type="number" style="text-align: right" class="number validate" readonly>
            <label for="quantity">Quantity<sup class="red-text">*</sup></label>
          </div>

          <div class="input-field col s12 m4 l4">
            <input placeholder="0" id="add_total_price" name="total_price" type="text" style="text-align: right" class="number" readonly>
            <label for="total_price">Total Price<sup class="red-text">*</sup></label>
          </div>
          
          <div class="input-field col s12 m12 l12">
            <button type="button" class="blue waves-effect waves-light btn right-align" id="btnAdd" disabled="true"><i class="material-icons left">add_circle</i>Add Product</button>
          </div>
        </div>
         
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card">
              <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Product List</b></h6><hr style="margin: 0px">
              <div class="card-content" style="padding: 10px; padding-top: 0px">
                <table class="highlight responsive-table" id="product-dt">
                  <thead>
                    <tr>
                        <th class="center-align">Product Code</th> 
                        <th class="center-align">Product Name</th> 
                        <th class="center-align">Unit of Measure</th>
                        <th class="center-align">Currency</th>
                        <th class="center-align">Unit Price</th>
                        <th class="center-align">Quantity</th>
                        <th class="center-align">Total Price</th>
                        <th class="center-align">Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row col s12 m12 l12">
            <div class="col s12 m8 l8"></div>
            <div class="col s12 m4 l4 right-align">
            <input placeholder="0" id="add_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
            <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
          </div>
        </div>
        
      </div>

      <div id="signatories" name="signatories">

        {{-- current signatories --}}
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
    <div class="modal-footer" style="padding-right: 30px;">
      <a href="#!" class="modal-close green waves-effect waves-light btn"><i class="material-icons left">keyboard_return</i>Return</a>
    </div>
  </div>

  <!--appModal-->
  <div id="appModal" class="modal">
    <form method="POST" action="{{route('quotation.approve')}}">
      {{-- <form> --}}
    @csrf
      <div class="modal-content" style="padding-bottom: 0px">
        <h4>Sales Quotation Approval</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#app_details">Quotation Details</a></li>
          {{-- need auth ID and module for getApprover()  --}}
          {{-- onclick="getApprover(2,'view','Sales Quotation');" --}}
          <li class="tab col s12 m4 l4"><a href="#app_signatory" >Signatories</a></li>
        </ul><br>

        {{-- hidden items --}}
        <input type="hidden" name="id" id="id_app"/>
        <input type="hidden" name="seq" id="seq_app"/>
        <input type="hidden" name="appid" id="appid_app"/>
        <input type="hidden" name="appname" id="appname_app">
        {{-- hidden items --}}

        <div id="app_details" name="app_details">

          <div class="row" style="display:none" id="facode">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="app_forecast_code" name="forecast_code" placeholder="0" readonly/>
              <label for="forecast_code">Forecast<sup class="red-text">*</sup></label>
            </div>
          </div>  

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="app_quotation_code" name="quotation_code" placeholder="0" readonly/>
              <label for="quotation_code">Quotation Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input type="text" id="app_customer_code" name="customer_code" placeholder="0" readonly/>
              <label for="customer_code">Customer<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row">

            <div class="input-field col s12 m6 l6">
              <input type="text" id="app_payment_term" name="payment_term" placeholder="0" readonly/>
              <label for="payment_term">Payment Term<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input type="text" id="app_currency_code" name="currency_code" placeholder="0" readonly/>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

          </div>
            
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Product List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="product-dt-app">
                    <thead>
                      <tr>
                          {{-- <th></th> --}}
                          <th class="left-align">Product Code</th> 
                          <th class="left-align">Product Name</th> 
                          <th class="left-align">Unit of Measure</th>
                          <th class="left-align">Currency</th>
                          <th class="left-align">Unit Price</th>
                          <th class="left-align">Quantity</th>
                          <th class="left-align">Total Price</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="row col s12 m12 l12">
              <div class="col s12 m8 l8"></div>
              <div class="col s12 m4 l4 right-align">
                <input placeholder="0" id="app_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
                <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
              </div>
          </div>
            
        </div>
        <hr style="padding:1px;color:blue;background-color:blue">

        <div id="app_signatory" name="app_signatory">

          {{-- current signatories --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
 
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-app">
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

          {{-- approval history --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
 
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-app-h">
                    <thead>
                      <tr>
                          <th>Sequence</th> 
                          <th>Approver Name</th> 
                          <th>Status</th> 
                          <th>Remarks</th> 
                          <th>Action Date</th> 
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
      <div class="modal-footer" style="padding-right: 30px;">
      
        <div class="row" style="padding: 10px">
          <div class="input-field col s12 m9 l9">

            <textarea class="materialize-textarea" type="text" id="app_remarks" name="remarks" placeholder="Please input remarks here.." style="height: 150px; border-left: 10px; border-color: black; padding-left:20px;" required/></textarea>
            <label for="icon_prefix2">Remarks</label>

          </div>
          
          <div class="input-field col s12 m3 l3">
            <input type="hidden" id="status" name="status">

            <button id="btnApp" name="approve" value="Approve" onclick="getStatus('Approved');" class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Approve</button>
            
            <button id="btnRej" name="reject" value="Reject" onclick="getStatus('Reject');" class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Reject&nbsp;&nbsp;&nbsp;</button>

            <a href="#!" class="modal-close orange waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Cancel&nbsp;&nbsp;</a>
          </div>
        </div>

      </div>
    </form>
  </div>

  <!--deleteModal-->
  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('order.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Sales Order</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <input type="hidden" name="quot" id="del_quot">
                    <p>Are you sure you want to delete this <strong>Sales Order</strong>?</p>
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
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script> 
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">
    var add_products = [];
    var edit_products = [];
    var is_qoute = false;

    //Functions
    const FormatNumber = (number) => {
        var n = number.toString().split(".");
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        n[1] = n[1] ? n[1] : '00';
        return n.join(".");
    }

    const calculateTotal = (symbol = '$', unit_price = 0, quantity = 0, field_total) => {
      const total = unit_price * quantity;
      field_total.val(symbol+" "+FormatNumber(total ? parseFloat(total) : 0));
    }

    const calculateGrandTotal = (symbol, products, field_grand_total) => {
      var grand_total = 0.0;
      $.each(products,(index,row) => {
          grand_total = parseFloat(grand_total) + parseFloat(row.total_price);
      });

      field_grand_total.val(symbol+" "+FormatNumber(grand_total));

    }

    const reset = (transaction) => {
      add_products = [];
      edit_products = [];
      is_qoute = false;
      if(transaction == "add"){
        $('#customer_code').val("");
        $('#payment_term').val("");
        $('#currency_code').val("");
        $('#customer_po_specs').val("");
        $('#customer_po_specs_filename').val("");
        $('#customer_po_no').val("");
        $('#customer_po_no').prop('readonly', false);
        $('#add_customer_code').prop('disabled', false);
        $('#add_customer_code').val("");
        $('#add_customer_code').formSelect();
        $('#add_quotation_code').prop('disabled', false);
        $('#add_quotation_code').val("");
        $('#add_quotation_code').formSelect();
        $('#add_payment_term').prop('disabled', false);
        $('#add_payment_term').val("");
        $('#add_payment_term').formSelect();
        $('#add_currency_code').prop('disabled', false);
        $('#add_currency_code').val("");
        $('#add_currency_code').formSelect();
        $('#btn_add_reset').hide();
        $('#add_site_code').val("");
        $('#add_site_code').prop('disabled', true);
        $('#add_site_code').formSelect();
        $('#add_prod_code').val("");
        $('#add_prod_code').prop('disabled', true);
        $('#add_prod_code').formSelect();
        $('#add_uom_code').val("");
        $('#add_uom_code').prop('disabled', true);
        $('#add_uom_code').formSelect();
        $('#add_unit_price').val(0);
        $('#add_unit_price').prop('readonly', true);
        $('#add_quantity').val(0);
        $('#add_quantity').prop('readonly', true);
        $('#add_total_price').val(0);
        $('#add_grand_total').val(0);
        $('#product-dt tbody').html("");
        $('#btnAdd').prop('disabled', true);
        $('#btnAddSave').prop('disabled', true);
      }else{
        
      }
    }

    const resetProductDetails = (transaction) => {
      if (transaction == "add"){
        $('#add_site_code').val("");
        $('#add_site_code').formSelect();
        $('#add_prod_code').val("");
        $('#add_prod_code').formSelect();
        $('#add_uom_code').val("");
        $('#add_uom_code').formSelect();
        $('#add_unit_price').val(0);
        $('#add_quantity').val(0);
        $('#add_total_price').val(0);
      }else{

      }
    }

    const checkDetails = (transaction) => {
      if(transaction == "add" && !is_qoute){
        if($('#customer_code').val() &&
           $('#payment_term').val() &&
           $('#currency_code').val() &&
           $('#customer_po_specs').val() &&
           $('#customer_po_no').val()){
            $('#btnAdd').prop('disabled', false);
            $('#btn_add_reset').show();
            $('#add_site_code').prop('disabled', false);
            $('#add_site_code').formSelect();
            $('#add_prod_code').prop('disabled', false);
            $('#add_prod_code').formSelect();
            $('#add_uom_code').prop('disabled', false);
            $('#add_uom_code').formSelect();
            $('#add_unit_price').prop('readonly', false);
            $('#add_quantity').prop('readonly', false);
            
            $('#add_customer_code').prop('disabled',true);
            $('#add_customer_code').formSelect();
            $('#add_payment_term').prop('disabled',true);
            $('#add_payment_term').formSelect();
            $('#add_currency_code').prop('disabled',true);
            $('#add_currency_code').formSelect();
            $('#customer_po_specs').prop("visibility","hidden");
            $('#customer_po_no').prop('readonly', true);
           }
      }else if(transaction == "add" && is_qoute){
        if($('#customer_code').val() &&
           $('#payment_term').val() &&
           $('#currency_code').val() &&
           $('#customer_po_specs').val() &&
           $('#customer_po_no').val() &&
           $('#quotation_code').val()){
            $('#btnAdd').prop('disabled', false);
            $('#btn_add_reset').show();
            $('#add_site_code').prop('disabled', false);
            $('#add_site_code').formSelect();
            $('#add_prod_code').prop('disabled', false);
            $('#add_prod_code').formSelect();
            $('#add_uom_code').prop('disabled', false);
            $('#add_uom_code').formSelect();
            $('#add_unit_price').prop('readonly', false);
            $('#add_quantity').prop('readonly', false);
          
            $('#add_customer_code').prop('disabled',true);
            $('#add_customer_code').formSelect();
            $('#add_quotation_code').prop('disabled',true);
            $('#add_quotation_code').formSelect();
            $('#add_payment_term').prop('disabled',true);
            $('#add_payment_term').formSelect();
            $('#add_currency_code').prop('disabled',true);
            $('#add_currency_code').formSelect();
            $('#customer_po_specs').css("visibility","hidden");
            $('#customer_po_no').prop('readonly', true);
           }
      }else{

      }
    }

    const renderProductTable = (products,table) =>{
      table.html("");
      $.each(products, (index,row) => {
        table.append('<tr>'+
                     '<td class="center-align">'+row.prod_code+'</td>'+
                     '<td class="center-align">'+row.prod_name+'</td>'+
                     '<td class="center-align">'+row.currency+'</td>'+
                     '<td class="center-align">'+row.uom+'</td>'+
                     '<td class="right-align">'+$('#add_currency_code option:selected').text().split(" - ")[0]+" "+FormatNumber(row.unit_price)+'</td>'+
                     '<td class="right-align">'+row.quantity+'</td>'+
                     '<td class="right-align">'+$('#add_currency_code option:selected').text().split(" - ")[0]+" "+FormatNumber(row.total_price)+'</td>'+
                     '<td><button type="button" class="btn-small red waves-effect waves-light" onclick="removeProduct(\''+index+'\',\'add\')"><i class="material-icons small icon-demo">delete_sweep</i></button></td>'+
                     '<input type="hidden" name="details_prod_code[]" value="'+row.prod_code+'"/>'+
                     '<input type="hidden" name="details_prod_name[]" value="'+row.prod_name+'"/>'+
                     '<input type="hidden" name="details_uom_code[]" value="'+row.uom_code+'"/>'+
                     '<input type="hidden" name="details_currency_code[]" value="'+row.currency_code+'"/>'+
                     '<input type="hidden" name="details_unit_price[]" value="'+row.unit_price+'"/>'+
                     '<input type="hidden" name="details_quantity[]" value="'+row.quantity+'"/>'+
                     '<input type="hidden" name="details_total_price[]" value="'+row.total_price+'"/>'+
                     '</tr>'
                    );
      });
    }

    const removeProduct = (index, transaction) => {
      if(transaction == "add"){
        add_products.splice(index,1);
        renderProductTable(add_products,$('#product-dt tbody'));
        calculateGrandTotal($('#add_currency_code option:selected').text().split(" - ")[0],add_products,$('#add_grand_total'));
        if(add_products.length  == 0 ){ $('#btnAddSave').prop('disabled', true); }
      }else{

      }
    }

    const viewOrder = (id) => {
      $.get('order/'+id, (response) => {
        var data = response.data;
        
      });
    }

    //AddModal Listeners
    $('body').on('click','#showaddModal',function(){
      $('div[id="rowQouteAdd"]').hide();
      $('div[id="rowAdd"]').show();
      $('.tabs.add').tabs('select','order');
      $.get('approver/{{Auth::user()->emp_no}}/Sales Order/my_matrix', function(response){
        var data = response.data;
        var tabledata = '';
        if(data){
        var matrix = data.matrix;
          $.each(JSON.parse(matrix),(index, row) => {
              tabledata +=  '<tr>'+
                              '<td>'+row.sequence+'</td>'+
                              '<td>'+row.approver_emp_no+'</td>'+
                              '<td>'+row.approver_name+'</td>'+
                              '<input type="hidden" name="sequence[]" value="'+row.sequence+'"/>'+
                              '<input type="hidden" name="approver_emp_no[]" value="'+row.sequence+'"/>'+
                              '<input type="hidden" name="approver_name[]" value="'+row.sequence+'"/>'+
                            '</tr>'

          });
          
          $('#matrix-dt tbody').html(tabledata);
        }else{
          // alert('You don\'t have approver matrix.');
          // $('#closeAddModal').click();
        }
      });
    });

    $('body').on('click','#showaddQuotation',function(){
      $('div[id="rowAdd"]').hide();
      $('div[id="rowQouteAdd"]').show();
      is_qoute = true;
    });

    $('body').on('change','#add_currency_code',function(){
      calculateTotal($('#add_currency_code option:selected').text().split(" - ")[0],parseFloat($('#add_unit_price').val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
      $('#currency_code').val($(this).val());
      checkDetails("add");
    });

    $('body').on('change','#add_payment_term',function(){
      $('#payment_term').val($(this).val());
      checkDetails("add");
    });

    $('body').on('change','#add_customer_code',function(){
      $('#customer_code').val($(this).val());
      if(is_qoute){
        $.get('quotation/'+$(this).val()+'/allbycustomer', (response) => {
          var data = response.data;
          var select = '<option value="" disabled selected>Choose Quotation</option>';
          $.each(data, function(index, row){
            select += '<option value="'+row.id+'">'+row.quot_code+'</option>';
          });
          
          $('#add_quotation_code').html(select);
          $('#add_quotation_code').formSelect();
        });
      }
      checkDetails("add");
    });

    $('body').on('change','#add_quotation_code',function(){
      $('#quotation_code').val($('#add_quotation_code option:selected').text());
      $.get('quotation/'+$(this).val(), (response) => {
          var data = response.data;
                    
          $('#add_payment_term').val(data.payment_term_id);
          $('#payment_term').val(data.payment_term_id);
          $('#add_payment_term').formSelect();

          $('#add_currency_code').val(data.currency_code);
          $('#currency_code').val(data.currency_code);
          $('#add_currency_code').formSelect();
        });
      checkDetails("add");
    });

    $('body').on('blur','#customer_po_no',function(){
      checkDetails("add");
    });

    $('body').on('change','#customer_po_specs',function(){
      checkDetails("add");
    });

    $('body').on('change','#add_site_code',function(){
      $.get('product/'+$(this).val()+'/allbysite', function(response){
        var data = response.data;
        var select = '<option value="" disabled selected>Choose Product</option>';
        $.each(data, function(index, row){
          select += '<option value="'+row.prod_code+'">'+row.prod_name+'</option>';
        });
        
        $('#add_prod_code').html(select);
        $('#add_prod_code').formSelect();
      });
    });

    $('body').on('keyup','#add_unit_price',function(){
      calculateTotal($('#add_currency_code option:selected').text().split(" - ")[0],parseFloat($(this).val()),parseFloat($('#add_quantity').val()),$('#add_total_price'));
    });

    $('body').on('keyup','#add_quantity',function(){
      calculateTotal($('#add_currency_code option:selected').text().split(" - ")[0],parseFloat($('#add_unit_price').val()),parseFloat($(this).val()),$('#add_total_price'));
    });

    $('body').on('click','#btnAdd', function(){
      var found = false;
      var cindex = 0;

      if($('#add_prod_code').val() &&
        $('#add_uom_code').val() &&
        $('#add_unit_price').val() &&
        $('#add_quantity').val()
      ){
        if($('#add_unit_price').val() <= 0){
          alert('Unit Price must be greater than 0!');
        }else if($('#add_quantity').val() <= 0){
          alert('Quantity must be greater than 0!');
        }else{
          $.each(add_products,(index,row) => {
            if(row.prod_code == $('#add_prod_code').val()){
              cindex = index;
              found = true;
              return false;
            }
          });

          if(found){
            add_products[cindex].unit_price = parseFloat(add_products[cindex].unit_price) + parseFloat($('#add_unit_price').val());
            add_products[cindex].quantity = parseFloat(add_products[cindex].quantity) + parseFloat($('#add_quantity').val());
            add_products[cindex].total_price = add_products[cindex].unit_price * add_products[cindex].quantity;
          }else{
            add_products.push({ "prod_code": $('#add_prod_code').val(),
                                "prod_name": $('#add_prod_code option:selected').text(),
                                "uom_code": $('#add_uom_code').val(),
                                "uom": $('#add_uom_code option:selected').text(),
                                "currency_code": $('#add_currency_code').val(),
                                "currency": $('#add_currency_code option:selected').text(),
                                "unit_price": parseFloat($('#add_unit_price').val()),
                                "quantity": parseFloat($('#add_quantity').val()),
                                "total_price": parseFloat($('#add_unit_price').val())*parseFloat($('#add_quantity').val()),
                              });
          }

          $('#btnAddSave').prop('disabled', false);
          renderProductTable(add_products,$('#product-dt tbody'));
          calculateGrandTotal($('#add_currency_code option:selected').text().split(" - ")[0],add_products,$('#add_grand_total'));
          resetProductDetails("add");
        }
      }else{
        alert("Please fill up product details!");
      }
      
    });

    $('body').on('click','#btn_add_reset, #closeAddModal',() => {
      reset("add");
    });
    
    //ongoing-dt
    var order_dt = $('#order-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/order/all/{{Illuminate\Support\Facades\Crypt::encrypt(Auth::user()->emp_no)}}",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.sites.site_desc;
                }
            },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    // return row.order_code;
                    return  '<a href="#" onclick="viewOrder('+data+')">'+row.order_code+'</a>';
                }
            },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.customers.cust_name;
                }
            },
            {
                "data": "status",
                "render": function ( data, type, row, meta ) {
                  switch(data){
                    case 'Approved':
                      return  '<span class="new badge green white-text" data-badge-caption="">Approved</span>';
                    break;
                    case 'Pending':
                      return  '<span class="new badge blue white-text" data-badge-caption="">Pending</span>';
                    break;
                    case 'Rejected':
                      return  '<span class="new badge red white-text" data-badge-caption="">Rejected</span>';
                    break;
                    case 'For Approval':
                      return  '<span class="new badge yellow white-text" data-badge-caption="">For Approval</span>';
                    break;
                    case 'For Review':
                      return  '<span class="new badge yellow black-text" data-badge-caption="">For Review</span>';
                    break;
                    case 'Voided':
                      return  '<span class="new badge black white-text" data-badge-caption="">Voided</span>';
                    break;
 
                  }
                   
                }
            },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    if(row.status=='Pending')
                    {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="getApprover(\'{{Auth::user()->emp_no}}\',\'edit\',\'Sales Quotation\'), editItem(\''+(row.quot_code)+'\')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red lighten-1  waves-effect waves-light" onclick="voidItem('+(data)+')"><i class="material-icons">grid_off</i></a>';
                    }
                    else if(row.status=='Voided')
                    {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a> <a href="#" class="btn-small red lighten-1 waves-effect waves-light" disabled><i class="material-icons">grid_off</i></a>';
                    }
                    else
                    {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" disabled><i class="material-icons">create</i></a> <a href="#" class="btn-small red lighten-1  waves-effect waves-light" onclick="voidItem('+(data)+')"><i class="material-icons">grid_off</i></a>';
                    }

                }
            }
          ]
    });

  </script>

  <!-- End of SCRIPTS -->

@endsection
