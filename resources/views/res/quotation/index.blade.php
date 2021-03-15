@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales<i class="material-icons">arrow_forward_ios</i></span> Sales Quotation</h4>
    </div>
  </div>
  <div class="row main-content">
  
    {{-- <ul id="tabs-swipe-demo" class="tabs"> --}}
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#ongoing">Sales Quotation</a></li>
      <li class="tab col s12 m4 l4"><a href="#approval">For Approval</a></li>
    </ul>

    <div id="ongoing" name="ongoing">

        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="quotation-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Site Code</th>
                    <th>Quotation Code</th>
                    <th>Customer Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
      </div>
      {{--  onclick="getApprover(2,'add','Sales Quotation');" --}}
      <a href="#askModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button"  data-position="left" data-tooltip="Add Sales Quotation Details"><i class="material-icons">add</i></a>
    </div>

    <div id="approval" name="approval">
        <div class="card" style="margin-top: 0px">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Site Code</th>
                    <th>Quotation Code</th>
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
  <div id="askModal" class="modal">
    <div class="modal-content">
      <h4>Sales Quotation</h4><i class="material-icons left">assignment</i>
      <p>Do you want to create a quotation based on your sales forecast?</p>
    </div>
    <div class="modal-footer">
      <a href="#addForecast" class="modal-close green waves-effect waves-dark btn modal-trigger" onclick="callModal('yes'), getApprover(2,'forecast','Sales Quotation');"  ><i class="material-icons left">check_circle</i>Yes</a>
      <a href="#addModal" class="modal-close red waves-effect waves-dark btn modal-trigger" onclick="callModal('no'), getApprover(2,'add','Sales Quotation');"><i class="material-icons left">highlight_off</i>No</a>
    </div>
  </div>

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('quotation.store')}}">
      {{-- <form> --}}
    @csrf
      <div class="modal-content">
        <h4>Add Sales Quotation</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#quotation">Quotation Details</a></li>
          {{-- need auth ID and module for getApprover()  --}}
          <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="quotation" name="quotation">

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="add_quotation_code" name="quotation_code" value="{{$quot}}{{$today}}-{{$lastquotation}}" readonly/>
              <label for="quotation_code">Quotation Code<sup class="red-text">*</sup></label>
            </div>
        
            <div class="input-field col s12 m6 l6">
              <select id="add_customer_code" name="customer_code">
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
              <select id="add_payment_term" name="payment_term" required>
                <option value="0" disabled selected>Choose Payment Term</option>
                @foreach ($payment as $payments)
                  <option value="{{$payments->id}}">{{$payments->term_name}}</option>
                @endforeach
              </select>
              <label for="payment_term">Payment Term<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <select id="add_currency_code" name="currency_code" onchange="computeTotal('add');" required>
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
              <select id="add_site_code" name="site_code" required>
                <option value="" disabled selected>Choose Site</option>
                @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l5">
              <select id="add_prod_code" name="prod_code" required>
                <option value="" disabled selected>Choose Product</option>
              </select>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="add_uom_code" name="uom_code" required>
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
              <input placeholder="0.00" id="add_unit_price" name="unit_price" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('add');" required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="add_quantity" name="quantity" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('add');" required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="add_total_price" name="total_price" type="text" style="text-align: right" class="number" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
            
            <div class="input-field col s12 m12 l12">
              <a class="blue waves-effect waves-light btn right-align" id="btnAdd" onclick="addProduct('m');"><i class="material-icons left">add_circle</i>Add Product</a>
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
      
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

  <div id="addForecast" class="modal">
    <form method="POST" action="{{route('quotation.store')}}">
      <form>
    @csrf
      <div class="modal-content">
        <h4>Add Sales Quotation Using Forecast</h4>
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#forecast">Quotation Details</a></li>
          {{-- need auth ID and module for getApprover()  --}}
          <li class="tab col s12 m4 l4"><a href="#signatory">Signatories</a></li>
        </ul><br>

        <div id="forecast" name="forecast">

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="f_quotation_code" name="quotation_code" value="{{$quot}}{{$today}}-{{$lastquotation}}" readonly/>
              <label for="quotation_code">Quotation Code<sup class="red-text">*</sup></label>
            </div>
          </div>  

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <select id="add_customer_code" name="customer_code">
                <option value="" disabled selected>Choose Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{$customer->cust_code}}">{{$customer->cust_name}}</option>
                @endforeach
              </select>
              <label for="customer_code">Customer<sup class="red-text">*</sup></label>
            </div>
        
            <div class="input-field col s12 m6 l6">
              <select id="f_forecast_code" name="forecast_code">
                <option value="0" disabled selected>Choose Forecast Code</option>
                @foreach ($forecast_code as $forecast_codes)
                  <option value="{{$forecast_codes->forecast_code}}">{{$forecast_codes->forecast_code}}</option>
                @endforeach
              </select>
              <label for="forecast_code">Forecast<sup class="red-text">*</sup></label>
            </div>
          </div>


          <div id="details" style="display:none">

            <div class="row">

              <div class="input-field col s12 m6 l6">
                <select id="f_payment_term" name="payment_term" required>
                  <option value="0" disabled selected>Choose Payment Term</option>
                  @foreach ($payment as $payments)
                    <option value="{{$payments->id}}">{{$payments->term_name}}</option>
                  @endforeach
                </select>
                <label for="payment_term">Payment Term<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m6 l6">
                <select id="f_currency_code" name="currency_code" onchange="computeTotal('f');" required>
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
                <select id="f_site_code" name="site_code" required>
                  <option value="" disabled selected>Choose Site</option>
                  @foreach ($sites as $site)
                    <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                  @endforeach
                </select>
                <label for="site_code">Site<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m4 l5">
                <select id="f_prod_code" name="prod_code" required>
                  <option value="" disabled selected>Choose Product</option>
                </select>
                <label for="prod_code">Product<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m4 l3">
                <select id="f_uom_code" name="uom_code" required>
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
                <input placeholder="0.00" id="f_unit_price" name="unit_price" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('f');" required>
                <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m4 l4">
                <input placeholder="0" id="f_quantity" name="quantity" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('f');" required>
                <label for="quantity">Quantity<sup class="red-text">*</sup></label>
              </div>

              <div class="input-field col s12 m4 l4">
                <input placeholder="0" id="f_total_price" name="total_price" type="text" style="text-align: right" class="number" required readonly>
                <label for="total_price">Total Price<sup class="red-text">*</sup></label>
              </div>
              
              <div class="input-field col s12 m12 l12">
                <a class="blue waves-effect waves-light btn right-align" id="btnAddF" onclick="addProduct('f');"><i class="material-icons left">add_circle</i>Add Product</a>
              </div>

            </div>
            
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="card">
                  <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Product List</b></h6><hr style="margin: 0px">
                  <div class="card-content" style="padding: 10px; padding-top: 0px">
                    <table class="highlight responsive-table" id="product-dt-f">
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
                  <input placeholder="0" id="f_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
                  <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
                </div>
            </div>
          
          </div>
          
        </div>

        <div id="signatory" name="signatory">

          {{-- current signatories --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
 
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-f">
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
      
        <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
        <a href="#!" class="modal-close red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
      </div>
    </form>
  </div>

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
              <input placeholder="0.00" id="edit_unit_price" name="unit_price" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('edit');" required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="edit_quantity" name="quantity" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('edit');" required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l4">
              <input placeholder="0" id="edit_total_price" name="total_price" type="text" style="text-align: right" class="number" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
            
            <div class="input-field col s12 m12 l12">
              <a class="blue waves-effect waves-light btn right-align" id="btnAdd" onclick="addProduct('e');"><i class="material-icons left">add_circle</i>Add Product</a>
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

  <div id="viewModal" class="modal">
      <form>
    @csrf
      <div class="modal-content" style="padding-bottom: 0px">
        <h4>Sales Quotation</h4>
        <ul id="tabs tabs-fixed-width tab-demo z-depth-1" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#view_details">Quotation Details</a></li>
          {{-- need auth ID and module for getApprover()  --}}
          {{-- onclick="getApprover(2,'view','Sales Quotation');" --}}
          <li class="tab col s12 m4 l4"><a href="#view_signatory" >Signatories</a></li>
        </ul><br>

        <div id="view_details" name="view_details">

          <div class="row" style="display:none" id="fcode">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="v_forecast_code" name="forecast_code" placeholder="0" readonly/>
              <label for="forecast_code">Forecast<sup class="red-text">*</sup></label>
            </div>
          </div>  

          <div class="row">
            <div class="input-field col s12 m6 l6">
              <input type="text" id="v_quotation_code" name="quotation_code" placeholder="0" readonly/>
              <label for="quotation_code">Quotation Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input type="text" id="v_customer_code" name="customer_code" placeholder="0" readonly/>
              <label for="customer_code">Customer<sup class="red-text">*</sup></label>
            </div>
          </div>

          <div class="row">

            <div class="input-field col s12 m6 l6">
              <input type="text" id="v_payment_term" name="payment_term" placeholder="0" readonly/>
              <label for="payment_term">Payment Term<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m6 l6">
              <input type="text" id="v_currency_code" name="currency_code" placeholder="0" readonly/>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

          </div>
            
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Product List</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight responsive-table" id="product-dt-v">
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
                <input placeholder="0" id="v_grand_total" name="grand_total" type="text" style="text-align: right; left: 75%; font-size: 25px" class="number" required readonly>
                <label for="grand_total" style="left: 75%; font-size:20px;"><b>Grand Total Price</b><sup class="red-text"></sup></label>
              </div>
          </div>
            
        </div>

        <div id="view_signatory" name="view_signatory">

          {{-- current signatories --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
 
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-v">
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
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
 
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Approval History</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-v-h">
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
      
        <a href="#!" class="modal-close green waves-effect waves-light btn"><i class="material-icons left">keyboard_return</i>Okay</a>

      </div>
    </form>
  </div>

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

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('quotation.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Sales Quotation Details</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <input type="hidden" name="quot" id="del_quot">
                    <p>Are you sure you want to delete this <strong>Sales Quotation Details</strong>?</p>
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
        var Prod_code = [];
        var Prod_codeF = [];
        var Prod_codeE = [];
    $(document).ready(function () {
        $('#add_site_code').change(function () {
             var id = $(this).val();

          $('#add_prod_code').find('option').remove();

            $.ajax({
              url:'/reiss/forecast/getProducts/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#add_prod_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  dropdown.append('<option value="" disabled selected>Choose your option</option>');
                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].prod_code;
                            var name = response.data[i].prod_name;

                            var option = "<option value='"+id+"'>"+name+"</option>"; 
                            dropdown.append(option);
                      }
                  }
                  dropdown.formSelect();
              }
            });
        });

        $('#f_site_code').change(function () {
             var id = $(this).val();

          $('#f_prod_code').find('option').remove();

            $.ajax({
              url:'/reiss/forecast/getProducts/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#f_prod_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  dropdown.append('<option value="" disabled selected>Choose your option</option>');
                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].prod_code;
                            var name = response.data[i].prod_name;

                            var option = "<option value='"+id+"'>"+name+"</option>"; 
                            dropdown.append(option);
                      }
                  }
                  dropdown.formSelect();
              }
            });
        });

        $('#edit_site_code').change(function () {
             var id = $(this).val();

          $('#edit_prod_code').find('option').remove();

            $.ajax({
              url:'/reiss/forecast/getProducts/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#edit_prod_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  dropdown.append('<option value="" disabled selected>Choose your option</option>');
                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].prod_code;
                            var name = response.data[i].prod_name;

                            var option = "<option value='"+id+"'>"+name+"</option>"; 
                            dropdown.append(option);
                      }
                  }
                  dropdown.formSelect();
              }
            });
        });

        $('.number').on('keypress', function(evt){
          var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
        })

        $('#app_signatories').on('click', function(){
          var id = $('#id_app').val();
          getApproverMatrix(id);
        })

        $("select[name='forecast_code']").on('change', function()
        {
            var id = $(this).val();
            var x = document.getElementById("details");
            x.style.display = "block";

            $.get('quotation/getForecast/'+id, function(response){
              var AppendString = "";
              var i, j = "";
              var data = response.data;
              var quot_code = $('#f_quotation_code').val();
              var product = data.products;
              var uoms = data.uoms;
              var uom_name = uoms.uom_name;
              var uom_code = uoms.uom_code;
              var uom = uom_code + ' - ' + uom_name;
              
              var curr = data.currency;
              var curr_code = curr.currency_code;
              var curr_sym = curr.symbol;
              var currency = curr_sym + ' - ' + curr_code;

              var myTable = document.getElementById('product-dt-f');
              var rowCount = myTable.rows.length;
              
              var prod_code = data.prod_code;

              Prod_codeF.push(prod_code);

              var forecastx = 'f';
              var AppendString =  "<tr>"+
                                    "<td>" + prod_code + "</td>" +
                                    "<td>" + product.prod_name + "</td>" +
                                    "<td>" + uom + "</td>" +
                                    "<td>" + curr_code  + "</td>" +
                                    "<td>" + data.unit_price + "</td>" +
                                    "<td>" + data.quantity + "</td>" +
                                    "<td>" + data.total_price + "</td>" +
                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                    '</td><input type="hidden" name="f_seq_code[]" value="'+ rowCount +'"/>' +
                                          '<input type="hidden" name="f_quot_code[]" value="'+ quot_code +'"/>' +
                                          '<input type="hidden" name="f_prod_code[]" value="'+ prod_code +'"/>' +
                                          '<input type="hidden" name="f_prod_name[]" value="'+ product.prod_name +'"/>' +
                                          '<input type="hidden" name="f_uom[]" value="'+ uom +'"/>' +
                                          '<input type="hidden" name="f_currency_code[]" value="'+ curr_code +'"/>' +
                                          '<input type="hidden" name="f_unit_price[]" value="'+ data.unit_price +'"/>' +
                                          '<input type="hidden" name="f_quantity[]" value="'+ data.quantity +'"/>' +
                                          '<input type="hidden" name="f_total_price[]" value="'+ data.total_price +'"/></tr>';
                                          
             
              for (var x = rowCount-1; x>0; x--) 
              {
                myTable.deleteRow(x); 
              }

              $('#product-dt-f').find('tbody').append(AppendString);
              $('#f_grand_total').val(myTable.rows[1].cells[6].innerHTML);

              //computeGrandTotal('f');     

            });
        })
    });

    function callModal(checker)
    {
      var check = checker;
      var x = document.getElementById("details");
      x.style.display = "none";
      $('#checker').val(check);
      $('#f_forecast_code option[value="0"]').prop('selected', true);
      $('#f_forecast_code').formSelect();
      if(check=='yes')
      {
        $('.tabs').tabs('select','forecast');
      }
      else
      {
        $('.tabs').tabs('select','quotation');
      }

    }

    function getStatus(status)
    {
      var stat = status;
      $('#status').val(stat);
    }

    function getApprover(id, loc, modules)
    {
          $.get('quotation/getApprover/'+id+'/'+modules, function(response){

                var AppendString = "";
                var i, j = "";
                var data = response.data;
                var dataMatrix = data.matrix;
                var matrix = JSON.parse(dataMatrix);
               

                if(loc=='add'){
                  var myTable = document.getElementById("matrix-dt");
                } 
                else if(loc=='forecast') {
                  var myTable = document.getElementById("matrix-dt-f");
                }
                else if(loc=='view') {
                  var myTable = document.getElementById("matrix-dt-v");
                } 
                else if(loc=='edit') {
                  var myTable = document.getElementById("matrix-dt-e");
                } 
              
                var rowCount = myTable.rows.length;
                for (var x=rowCount-1; x>0; x--) 
                  {
                    myTable.deleteRow(x); 
                  }

               
                for(i in matrix)
                  {
                    for(j in matrix[i].sequence)
                    {
                      AppendString += 
                      "<tr><td>" + matrix[i].sequence + 
                        "</td><td>" + matrix[i].approver_emp_no + 
                          "</td><td>" + matrix[i].approver_name + 
                            '<input type="hidden" name="app_seq[]" value="'+matrix[i].sequence+'"/>' + 
                            '<input type="hidden" name="app_id[]" value="'+matrix[i].approver_emp_no+'"/>'+
                            '<input type="hidden" name="app_fname[]" value="'+matrix[i].approver_name+'"/>'+
                            '<input type="hidden" name="app_nstatus[]" value="'+matrix[i].next_status+'"/>'+
                            '<input type="hidden" name="app_gate[]" value="'+matrix[i].is_gate+'"/>'+
                            "</td></tr>";
                    }
                  }
                if(loc=='add'){
                  $('#matrix-dt').find('tbody').append(AppendString);
                }  
                else if(loc=='forecast') {
                  $('#matrix-dt-f').find('tbody').append(AppendString);
                }
                else if(loc=='view') {
                  $('#matrix-dt-v').find('tbody').append(AppendString);
                }
                else if(loc=='edit') {
                  $('#matrix-dt-e').find('tbody').append(AppendString);
                }
          });
    } 

    function getApproverMatrix(id, loc)
    {
          $.get('quotation/getApproverMatrix/'+id, function(response){

                var locx = loc;
                var AppendString = "";
                var AppendStringH = "";

                var i, j, k, l = "";
                var data = response.data;
                var dataMatrix = data.matrix;
                var dataMatrixH = data.matrix_h;
                
                var matrix = JSON.parse(dataMatrix);
                var matrixh = JSON.parse(dataMatrixH);


                if(locx=='v')
                {
                var myTable = document.getElementById("matrix-dt-v");
                var myTableH = document.getElementById("matrix-dt-v-h");
                }
                else
                {
                var myTable = document.getElementById("matrix-dt-app");
                var myTableH = document.getElementById("matrix-dt-app-h");
                }
    
                var rowCount = myTable.rows.length;
                for (var x=rowCount-1; x>0; x--) 
                  {
                    myTable.deleteRow(x); 
                  }

                var rowCountH = myTableH.rows.length;
                for (var h=rowCountH-1; h>0; h--) 
                  {
                    myTableH.deleteRow(h); 
                  }

                for(i in matrix)
                  {
                    for(j in matrix[i].sequence)
                    {
                      AppendString += 
                      "<tr><td>" + matrix[i].sequence + 
                      "</td><td>" + matrix[i].approver_emp_no + 
                      "</td><td>" + matrix[i].approver_name + 
                            '<input type="hidden" name="app_seq[]" value="'+matrix[i].sequence+'"/>' + 
                            '<input type="hidden" name="app_id[]" value="'+matrix[i].approver_emp_no+'"/>'+
                            '<input type="hidden" name="app_fname[]" value="'+matrix[i].approver_name+'"/>'+
                            '<input type="hidden" name="app_nstatus[]" value="'+matrix[i].next_status+'"/>'+
                            '<input type="hidden" name="app_gate[]" value="'+matrix[i].is_gate+'"/>'+
                      "</td></tr>";
                    }
                  }

                for(k in matrixh)
                  {
                    for(l in matrixh[k].sequence)
                    {
                      AppendStringH += 
                      "<tr><td>" + matrixh[k].sequence + 
                      "</td><td>" + matrixh[k].approver_name + 
                      "</td><td>" + matrixh[k].status + 
                      "</td><td>" + matrixh[k].remarks +
                      "</td><td>" + matrixh[k].action_date +    
                      "</td></tr>";
                    }
                  }

                  if(locx=='v')
                  {
                  $('#matrix-dt-v').find('tbody').append(AppendString);
                  $('#matrix-dt-v-h').find('tbody').append(AppendStringH);
                  }
                  else
                  {
                  $('#matrix-dt-app').find('tbody').append(AppendString);
                  $('#matrix-dt-app-h').find('tbody').append(AppendStringH);
                  }
          });
    }

    function getForecast()
    {
      var fc = document.getElementById('f_forecast_code');
      var forecast_code = fc.options[fc.selectedIndex].text;



    }

    function computeTotal(loc)
    {
      
      if(loc=='add')
      {
        var unit_price = $('#add_unit_price').val();
        var quantity = $('#add_quantity').val();

        var e = document.getElementById('add_currency_code');
        var currency = e.options[e.selectedIndex].text;
        currency = currency.substr(currency, 1);

      } else if (loc=='edit') {
        var unit_price = $('#edit_unit_price').val();
        var quantity = $('#edit_quantity').val();

        var e = document.getElementById('edit_currency_code');
        var currency = e.options[e.selectedIndex].text;
        currency = currency.substr(currency, 1);
      } else if (loc=='f') {
        var unit_price = $('#f_unit_price').val();
        var quantity = $('#f_quantity').val();

        var e = document.getElementById('f_currency_code');
        var currency = e.options[e.selectedIndex].text;
        currency = currency.substr(currency, 1);
      }

      if(unit_price == ''){
        unit_price = 0;
      }

      if(quantity == ''){
        quantity = 0;
      }

      if(currency == null){
        currency = '';
      }

      const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 4,      
        maximumFractionDigits: 4,
      });

      var total_price = unit_price * quantity;
      var totalprice  = formatter.format(total_price);
      var total_price_w_com = addCommas(totalprice);
      var total_w_currency = currency + ' ' + total_price_w_com;
      //var total_w_currency = total_price_w_com + ' ' + currency;

      if(loc=='add')
      {
        $('#add_total_price').val(total_w_currency);
      } else if(loc=='edit'){
        $('#edit_total_price').val(total_w_currency);
      } else if(loc=='f'){
        $('#f_total_price').val(total_w_currency);
      }
    }

    function computeGrandTotal(loc)
    {
        var locx = loc
        const formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 4,      
            maximumFractionDigits: 4,
          });
        if(locx=='f')
        {
          var cf = document.getElementById('f_currency_code');
          var currency_f = cf.options[cf.selectedIndex].text;
              currency_f = currency_f.substr(currency_f, 1); // currency

          var myTableF =  document.getElementById("product-dt-f");
          var rowCountF = myTableF.rows.length;
          if(rowCountF>1){
            var currencyF = myTableF.rows[1].cells[3].innerHTML;
          }  
          var resultF = 0;
          
          for (var f=1; f < rowCountF; f++)
          {
            resultF = resultF + (parseFloat(myTableF.rows[f].cells[4].innerHTML) * parseFloat(myTableF.rows[f].cells[5].innerHTML));
          }

          if(resultF<=0){
            var gt_w_curr_f = '';
          } else {
            var grand_total_f = formatter.format(resultF);
            var gt_w_curr_f = currency_f + ' ' + grand_total_f;
          }
          $('#f_grand_total').val(gt_w_curr_f); 

        } 
        else if(locx=='v')
        {
          var cf = $('#v_currency_code').val();
 
          var currency_f = cf.substr(cf, 1); // currency

          var myTableF =  document.getElementById("product-dt-v");
          var rowCountF = myTableF.rows.length;
          if(rowCountF>1){
            var currencyF = myTableF.rows[1].cells[3].innerHTML;
          }  
          var resultF = 0;
          
          for (var f=1; f < rowCountF; f++)
          {
            resultF = resultF + (parseFloat(myTableF.rows[f].cells[4].innerHTML) * parseFloat(myTableF.rows[f].cells[5].innerHTML));
          }

          if(resultF<=0){
            var gt_w_curr_f = '';
          } else {
            var grand_total_f = formatter.format(resultF);
            var gt_w_curr_f = currency_f + ' ' + grand_total_f;
          }
          $('#v_grand_total').val(gt_w_curr_f); 

        }
        else if(locx=='a')
        {
          var cf = $('#app_currency_code').val();
 
          var currency_f = cf.substr(cf, 1); // currency

          var myTableF =  document.getElementById("product-dt-app");
          var rowCountF = myTableF.rows.length;
          if(rowCountF>1){
            var currencyF = myTableF.rows[1].cells[3].innerHTML;
          }  
          var resultF = 0;
          
          for (var f=1; f < rowCountF; f++)
          {
            resultF = resultF + (parseFloat(myTableF.rows[f].cells[4].innerHTML) * parseFloat(myTableF.rows[f].cells[5].innerHTML));
          }

          if(resultF<=0){
            var gt_w_curr_f = '';
          } else {
            var grand_total_f = formatter.format(resultF);
            var gt_w_curr_f = currency_f + ' ' + grand_total_f;
          }
          $('#app_grand_total').val(gt_w_curr_f); 

        }
        else if(locx=='e')
        {
          
          var cf = document.getElementById('edit_currency_code');
          var currency_f = cf.options[cf.selectedIndex].text;
          var currency_f = currency_f.substr(currency_f, 1); // currency

          var myTableF =  document.getElementById("product-dt-e");
          var rowCountF = myTableF.rows.length;
          var resultF = 0;
          
          for (var f=1; f < rowCountF; f++)
          {
            resultF = resultF + (parseFloat(myTableF.rows[f].cells[4].innerHTML) * parseFloat(myTableF.rows[f].cells[5].innerHTML));
          }

          if(resultF<=0){
            var gt_w_curr_f = '';
          } else {
            var grand_total_f = formatter.format(resultF);
            var gt_w_curr_f = currency_f + ' ' + grand_total_f;
          }
          $('#edit_grand_total').val(gt_w_curr_f); 

        }
        else
        {
          var cf = document.getElementById('add_currency_code');
          var currency_f = cf.options[cf.selectedIndex].text;
              currency_f = currency_f.substr(currency_f, 1); // currency

          var myTable =  document.getElementById("product-dt");
          var rowCount = myTable.rows.length;
          if(rowCount>1){
            var currency = myTable.rows[1].cells[3].innerHTML;
          }  
          var result = 0;
          
          for (var i=1; i < rowCount; i++)
          {
            result = result + (parseFloat(myTable.rows[i].cells[4].innerHTML) * parseFloat(myTable.rows[i].cells[5].innerHTML));
          }

          if(result<=0){
            var gt_w_curr = '';
          } else {
            var grand_total = formatter.format(result);
            var gt_w_curr = currency_f + ' ' + grand_total;
          }
          $('#add_grand_total').val(gt_w_curr);
         
        }
    }

    function addCommas(x) 
    {
      var parts = x.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
    }

    function addProduct(loc)
    {
        const formatter = new Intl.NumberFormat('en-US', {
              minimumFractionDigits: 4,      
              maximumFractionDigits: 4,
            });
            
        var locx = loc;

        if(locx=='f')
        {
          
          var quot_code_f = $('#f_quot_code').val(); // quot code
          var prod_code_f = $('#f_prod_code').val(); // product code
          var pc_f = document.getElementById('f_prod_code');
          var prod_name_f = pc_f.options[pc_f.selectedIndex].text; // product name
         
          var unit_price_f = $('#f_unit_price').val(); //unit price
          var quantity_f = $('#f_quantity').val(); //quantity
          var total_price_f = $('#f_total_price').val(); //total price

          var cf = document.getElementById('f_currency_code');
          var currency_f = cf.options[cf.selectedIndex].text;
              currency_f = currency_f.substr(currency_f, 1); // currency
          
          var currency_codex = $('#f_currency_code').val(); // currency code

          var uomx = document.getElementById('f_uom_code');
          var uomx_name = uomx.options[uomx.selectedIndex].text; // uom name
          var uom_f = $('#f_uom_code').val(); //uom
          var uom = uom_f + ' - ' + uomx_name;

          var forecastx = 'f';

          var myTable = document.getElementById('product-dt-f');
          var rowCount = myTable.rows.length;
   
          var quantity = 0;
          var result = 0;
          var found = false;

          if($.inArray(prod_code_f,Prod_codeF) > -1){
            found = true;
          } else {
            found = false;
          }

          if(!found) // hindi nakita
            {
              if (prod_code_f!='Choose Product' && unit_price_f != '' && quantity_f != '' && total_price_f != '')
              {
                Prod_codeF.push(prod_code_f);
         
                $('#product-dt-f').find('tbody').append("<tr>"+
                                    "<td>" + prod_code_f + "</td>" +
                                    "<td>" + prod_name_f + "</td>" +
                                    "<td>" + uom + "</td>" +
                                    "<td>" + currency_codex  + "</td>" +
                                    "<td>" + unit_price_f + "</td>" +
                                    "<td>" + quantity_f + "</td>" +
                                    "<td>" + total_price_f + "</td>" +
                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                      '</td><input type="hidden" name="f_seq_code[]" value="'+ rowCount  +'"/>' +
                                          '<input type="hidden" name="f_quot_code[]" value="'+ quot_code_f +'"/>' +
                                          '<input type="hidden" name="f_prod_code[]" value="'+ prod_code_f +'"/>' +
                                          '<input type="hidden" name="f_prod_name[]" value="'+ prod_name_f +'"/>' +
                                          '<input type="hidden" name="f_uom[]" value="'+ uom +'"/>' +
                                          '<input type="hidden" name="f_currency_code[]" value="'+ currency_codex +'"/>' +
                                          '<input type="hidden" name="f_unit_price[]" value="'+ unit_price_f +'"/>' +
                                          '<input type="hidden" name="f_quantity[]" value="'+ quantity_f +'"/>' +
                                          '<input type="hidden" name="f_total_price[]" value="'+ total_price_f +'"/></tr>');
              }
            } 
          else // nakita
            { 
              const formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 4,      
                maximumFractionDigits: 4,
              });

              for(var i = 1; i < rowCount; i++)
              {
                if(prod_code_f == myTable.rows[i].cells[0].innerHTML)
                {
 
                  var row_q = parseFloat(myTable.rows[i].cells[5].innerHTML);
                  var row_up = parseInt(myTable.rows[i].cells[4].innerHTML);

                  var cf = document.getElementById('f_currency_code');
                  var currency_f = cf.options[cf.selectedIndex].text;
                      currency_f = currency_f.substr(currency_f, 1); // currency
                  
                  var adtl_q = parseFloat(quantity_f);
                  var curr_q = adtl_q + row_q;
                  var curr_tp = curr_q * row_up;
                      curr_tp = formatter.format(curr_tp);
                  var curr_tp_w_crnc = currency_f + ' ' + curr_tp;
                                  
                  $('#product-dt-f').find('tbody').append("<tr>" +
                                                    "<td>" + prod_code_f + "</td>" +
                                                    "<td>" + prod_name_f + "</td>" +
                                                    "<td>" + uom + "</td>" +
                                                    "<td>" + currency_codex  + "</td>" +
                                                    "<td>" + unit_price_f + "</td>" +
                                                    "<td>" + curr_q + "</td>" +
                                                    "<td>" + curr_tp_w_crnc + "</td>" +
                                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                                    '</td><input type="hidden" name="f_seq_code[]" value="'+ rowCount +'"/>' +
                                                          '<input type="hidden" name="f_quot_code[]" value="'+ quot_code_f +'"/>' +
                                                          '<input type="hidden" name="f_prod_code[]" value="'+ prod_code_f +'"/>' +
                                                          '<input type="hidden" name="f_prod_name[]" value="'+ prod_name_f +'"/>' +
                                                          '<input type="hidden" name="f_uom[]" value="'+ uom +'"/>' +
                                                          '<input type="hidden" name="f_currency_code[]" value="'+ currency_codex +'"/>' +
                                                          '<input type="hidden" name="f_unit_price[]" value="'+ unit_price_f +'"/>' +
                                                          '<input type="hidden" name="f_quantity[]" value="'+ curr_q +'"/>' +
                                                          '<input type="hidden" name="f_total_price[]" value="'+ curr_tp_w_crnc +'"/></tr>');
                }
                else
                {
             
                  $('#product-dt-f').find('tbody').append("<tr>" +
                                                      "<td>" + myTable.rows[i].cells[0].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[1].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[2].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[3].innerHTML  + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[4].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[5].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[6].innerHTML + "</td>" +
                                                      "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' +
                                                      '</td><input type="hidden" name="f_seq_code[]" value="'+ rowCount +'"/>' +
                                                            '<input type="hidden" name="f_quot_code[]" value="'+ quot_code_f +'"/>' +
                                                            '<input type="hidden" name="f_prod_code[]" value="'+ myTable.rows[i].cells[0].innerHTML +'"/>' +
                                                            '<input type="hidden" name="f_prod_name[]" value="'+ myTable.rows[i].cells[1].innerHTML +'"/>' +
                                                            '<input type="hidden" name="f_uom[]" value="'+ myTable.rows[i].cells[2].innerHTML +'"/>' +
                                                            '<input type="hidden" name="f_currency_code[]" value="'+ myTable.rows[i].cells[3].innerHTML +'"/>' +
                                                            '<input type="hidden" name="f_unit_price[]" value="'+ myTable.rows[i].cells[4].innerHTML +'"/>' +
                                                            '<input type="hidden" name="f_quantity[]" value="'+ myTable.rows[i].cells[5].innerHTML +'"/>' +
                                                            '<input type="hidden" name="f_total_price[]" value="'+ myTable.rows[i].cells[6].innerHTML +'"/></tr>');
                }
              }
              for (var x = rowCount-1; x>0; x--) 
                {
                  myTable.deleteRow(x); 
                }
            }

          computeGrandTotal(locx);  
        }
        else if(locx=='e')
        {
          
          var quot_code_e = $('#edit_quotation_code').val(); // quot code
          var prod_code_e = $('#edit_prod_code').val(); // product code
          var pc_e = document.getElementById('edit_prod_code');
          var prod_name_e = pc_e.options[pc_e.selectedIndex].text; // product name
         
          var unit_price_e = $('#edit_unit_price').val(); //unit price
          var quantity_e = $('#edit_quantity').val(); //quantity
          var total_price_e = $('#edit_total_price').val(); //total price

          var cf = document.getElementById('edit_currency_code');
          var currency_e = cf.options[cf.selectedIndex].text;
              currency_e = currency_e.substr(currency_e, 1); // currency
          
          var currency_codex = $('#edit_currency_code').val(); // currency code

          var uomx = document.getElementById('edit_uom_code');
          var uomx_name = uomx.options[uomx.selectedIndex].text; // uom name
          var uom_e = $('#edit_uom_code').val(); //uom
          var uom = uom_e + ' - ' + uomx_name;

          var forecastx = 'e';

          var myTable = document.getElementById('product-dt-e');
          var rowCount = myTable.rows.length;
   
          var quantity = 0;
          var result = 0;
          var found = false;

          if($.inArray(prod_code_e,Prod_codeE) > -1){
            found = true;
          } else {
            found = false;
          }

          if(!found) // hindi nakita
            {
              if (prod_code_e!='Choose Product' && unit_price_e != '' && quantity_e != '' && total_price_e != '')
              {
                Prod_codeE.push(prod_code_e);
         
                $('#product-dt-e').find('tbody').append("<tr>"+
                                    "<td>" + prod_code_e + "</td>" +
                                    "<td>" + prod_name_e + "</td>" +
                                    "<td>" + uom + "</td>" +
                                    "<td>" + currency_codex  + "</td>" +
                                    "<td>" + unit_price_e + "</td>" +
                                    "<td>" + quantity_e + "</td>" +
                                    "<td>" + total_price_e + "</td>" +
                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                      '</td><input type="hidden" name="e_seq_code[]" value="'+ rowCount  +'"/>' +
                                          '<input type="hidden" name="e_quot_code[]" value="'+ quot_code_e +'"/>' +
                                          '<input type="hidden" name="e_prod_code[]" value="'+ prod_code_e +'"/>' +
                                          '<input type="hidden" name="e_prod_name[]" value="'+ prod_name_e +'"/>' +
                                          '<input type="hidden" name="e_uom[]" value="'+ uom +'"/>' +
                                          '<input type="hidden" name="e_curr_code[]" value="'+ currency_codex +'"/>' +
                                          '<input type="hidden" name="e_unit_price[]" value="'+ unit_price_e +'"/>' +
                                          '<input type="hidden" name="e_quantity[]" value="'+ quantity_e +'"/>' +
                                          '<input type="hidden" name="e_total_price[]" value="'+ total_price_e +'"/></tr>');
              }
            } 
          else // nakita
            { 
              const formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 4,      
                maximumFractionDigits: 4,
              });

              for(var i = 1; i < rowCount; i++)
              {
                if(prod_code_e == myTable.rows[i].cells[0].innerHTML)
                {
 
                  var row_q = parseFloat(myTable.rows[i].cells[5].innerHTML);
                  var row_up = parseInt(myTable.rows[i].cells[4].innerHTML);

                  var cf = document.getElementById('edit_currency_code');
                  var currency_e = cf.options[cf.selectedIndex].text;
                      currency_e = currency_e.substr(currency_e, 1); // currency
                  
                  var adtl_q = parseFloat(quantity_e);
                  var curr_q = adtl_q + row_q;
                  var curr_tp = curr_q * row_up;
                      curr_tp = formatter.format(curr_tp);
                  var curr_tp_w_crnc = currency_e + ' ' + curr_tp;
                                  
                  $('#product-dt-e').find('tbody').append("<tr>" +
                                                    "<td>" + prod_code_e + "</td>" +
                                                    "<td>" + prod_name_e + "</td>" +
                                                    "<td>" + uom + "</td>" +
                                                    "<td>" + currency_codex  + "</td>" +
                                                    "<td>" + unit_price_e + "</td>" +
                                                    "<td>" + curr_q + "</td>" +
                                                    "<td>" + curr_tp_w_crnc + "</td>" +
                                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                                    '</td><input type="hidden" name="e_seq_code[]" value="'+ rowCount +'"/>' +
                                                          '<input type="hidden" name="e_quot_code[]" value="'+ quot_code_e +'"/>' +
                                                          '<input type="hidden" name="e_prod_code[]" value="'+ prod_code_e +'"/>' +
                                                          '<input type="hidden" name="e_prod_name[]" value="'+ prod_name_e +'"/>' +
                                                          '<input type="hidden" name="e_uom[]" value="'+ uom +'"/>' +
                                                          '<input type="hidden" name="e_curr_code[]" value="'+ currency_codex +'"/>' +
                                                          '<input type="hidden" name="e_unit_price[]" value="'+ unit_price_e +'"/>' +
                                                          '<input type="hidden" name="e_quantity[]" value="'+ curr_q +'"/>' +
                                                          '<input type="hidden" name="e_total_price[]" value="'+ curr_tp_w_crnc +'"/></tr>');
                }
                else
                {
             
                  $('#product-dt-e').find('tbody').append("<tr>" +
                                                      "<td>" + myTable.rows[i].cells[0].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[1].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[2].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[3].innerHTML  + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[4].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[5].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[6].innerHTML + "</td>" +
                                                      "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' +
                                                      '</td><input type="hidden" name="e_seq_code[]" value="'+ rowCount +'"/>' +
                                                            '<input type="hidden" name="e_quot_code[]" value="'+ quot_code_e +'"/>' +
                                                            '<input type="hidden" name="e_prod_code[]" value="'+ myTable.rows[i].cells[0].innerHTML +'"/>' +
                                                            '<input type="hidden" name="e_prod_name[]" value="'+ myTable.rows[i].cells[1].innerHTML +'"/>' +
                                                            '<input type="hidden" name="e_uom[]" value="'+ myTable.rows[i].cells[2].innerHTML +'"/>' +
                                                            '<input type="hidden" name="e_curr_code[]" value="'+ myTable.rows[i].cells[3].innerHTML +'"/>' +
                                                            '<input type="hidden" name="e_unit_price[]" value="'+ myTable.rows[i].cells[4].innerHTML +'"/>' +
                                                            '<input type="hidden" name="e_quantity[]" value="'+ myTable.rows[i].cells[5].innerHTML +'"/>' +
                                                            '<input type="hidden" name="e_total_price[]" value="'+ myTable.rows[i].cells[6].innerHTML +'"/></tr>');
                }
              }
              for (var x = rowCount-1; x>0; x--) 
                {
                  myTable.deleteRow(x); 
                }
            }

          computeGrandTotal(locx);  
        }
        else
        {
          var quot_code = $('#add_quot_code').val(); // quot code
          var product_code = $('#add_prod_code').val(); // product code
          var pc = document.getElementById('add_prod_code');
          var product_name = pc.options[pc.selectedIndex].text; // product name
 
          var unit_price = $('#add_unit_price').val(); //unit price
          var quantity = $('#add_quantity').val(); //quantity
          var total_price = $('#add_total_price').val(); //total price

          var c = document.getElementById('add_currency_code');
          var currency = c.options[c.selectedIndex].text;
          currency = currency.substr(currency, 1); // currency

          var currency_codex = $('#add_currency_code').val(); // currency code

          var uomx = document.getElementById('add_uom_code');
          var uomx_name = uomx.options[uomx.selectedIndex].text; // uom name
          var uom_f = $('#add_uom_code').val(); //uom
          var uom = uom_f + ' - ' + uomx_name;


          var forecastx = 'm';

          var myTable = document.getElementById('product-dt');
          var rowCount = myTable.rows.length;
          var quantity_m = 0;
          var result_m = 0;
          var found = false;

          if($.inArray(product_code,Prod_code) > -1){
            found = true;
          } else {
            found = false;
          }

          if(!found) // hindi nakita
            {
              if (product_code!='Choose Product' && unit_price != '' && quantity != '' && total_price != '')
              {
                Prod_code.push(product_code);

                $('#product-dt').find('tbody').append("<tr>"+
                                    "<td>" + product_code + "</td>" +
                                    "<td>" + product_name + "</td>" +
                                    "<td>" + uom + "</td>" +
                                    "<td>" + currency  + "</td>" +
                                    "<td>" + unit_price + "</td>" +
                                    "<td>" + quantity + "</td>" +
                                    "<td>" + total_price + "</td>" +
                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                    '</td><input type="hidden" name="seq_code[]" value="'+ rowCount +'"/>' +
                                          '<input type="hidden" name="quot_code[]" value="'+ quot_code +'"/>' +
                                          '<input type="hidden" name="prod_code[]" value="'+ product_code +'"/>' +
                                          '<input type="hidden" name="prod_name[]" value="'+ product_name +'"/>' +
                                          '<input type="hidden" name="uom[]" value="'+ uom +'"/>' +
                                          '<input type="hidden" name="curr_code[]" value="'+ currency_codex +'"/>' +
                                          '<input type="hidden" name="unit_price[]" value="'+ unit_price +'"/>' +
                                          '<input type="hidden" name="quantity[]" value="'+ quantity +'"/>' +
                                          '<input type="hidden" name="total_price[]" value="'+ total_price +'"/></tr>');
              }
            } 
          else // nakita
            {  
              const formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 4,      
                maximumFractionDigits: 4,
              });

              for(var i = 1; i < rowCount; i++)
              {
                if(product_code == myTable.rows[i].cells[0].innerHTML)
                {
                  var row_q = parseFloat(myTable.rows[i].cells[5].innerHTML);
                  var row_up = parseInt(myTable.rows[i].cells[4].innerHTML);
                  var currency = myTable.rows[i].cells[3].innerHTML;
                  
                  var adtl_q = parseFloat(quantity);
                  var curr_q = adtl_q + row_q;
                  var curr_tp = curr_q * row_up;
                      curr_tp = formatter.format(curr_tp);
                      
                  var curr_tp_w_crnc = currency + ' ' + curr_tp;
                                  
                  $('#product-dt').find('tbody').append("<tr>" +
                                                    "<td>" + product_code + "</td>" +
                                                    "<td>" + product_name + "</td>" +
                                                    "<td>" + uom + "</td>" +
                                                    "<td>" + currency  + "</td>" +
                                                    "<td>" + unit_price + "</td>" +
                                                    "<td>" + curr_q + "</td>" +
                                                    "<td>" + curr_tp_w_crnc + "</td>" +
                                                    "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                                    '</td><input type="hidden" name="seq_code[]" value="'+ rowCount +'"/>' +
                                                          '<input type="hidden" name="quot_code[]" value="'+ quot_code +'"/>' +
                                                          '<input type="hidden" name="prod_code[]" value="'+ product_code +'"/>' +
                                                          '<input type="hidden" name="prod_name[]" value="'+ product_name +'"/>' +
                                                          '<input type="hidden" name="uom[]" value="'+ uom +'"/>' +
                                                          '<input type="hidden" name="curr_code[]" value="'+ currency_codex +'"/>' +
                                                          '<input type="hidden" name="unit_price[]" value="'+ unit_price +'"/>' +
                                                          '<input type="hidden" name="quantity[]" value="'+ curr_q +'"/>' +
                                                          '<input type="hidden" name="total_price[]" value="'+ curr_tp_w_crnc +'"/></tr>');
                }
                else
                {
                  $('#product-dt').find('tbody').append("<tr>" +
                                                      "<td>" + myTable.rows[i].cells[0].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[1].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[2].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[3].innerHTML  + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[4].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[5].innerHTML + "</td>" +
                                                      "<td>" + myTable.rows[i].cells[6].innerHTML + "</td>" +
                                                      "<td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' +
                                                      '</td><input type="hidden" name="seq_code[]" value="'+ rowCount +'"/>' +
                                                            '<input type="hidden" name="quot_code[]" value="'+ quot_code +'"/>' +
                                                            '<input type="hidden" name="prod_code[]" value="'+ myTable.rows[i].cells[0].innerHTML +'"/>' +
                                                            '<input type="hidden" name="prod_name[]" value="'+ myTable.rows[i].cells[1].innerHTML +'"/>' +
                                                            '<input type="hidden" name="uom[]" value="'+ myTable.rows[i].cells[2].innerHTML +'"/>' +
                                                            '<input type="hidden" name="curr_code[]" value="'+ myTable.rows[i].cells[3].innerHTML +'"/>' +
                                                            '<input type="hidden" name="unit_price[]" value="'+ myTable.rows[i].cells[4].innerHTML +'"/>' +
                                                            '<input type="hidden" name="quantity[]" value="'+ myTable.rows[i].cells[5].innerHTML +'"/>' +
                                                            '<input type="hidden" name="total_price[]" value="'+ myTable.rows[i].cells[6].innerHTML +'"/></tr>');
                }
              }
              for (var x = rowCount-1; x>0; x--) 
                {
                  myTable.deleteRow(x); 
                }
            }

          computeGrandTotal(locx);  
        }
        
    }

    function editItem(id)
    {
        $('.tabs').tabs('select','edit-quotation');
        $.get('quotation/getAllEdit/'+id, function(response){
                var AppendString = "";
                var i, j = "";
                var data = response.data;

                console.log(data);
    
                var cust = data.customers;
                var curr = data.currency;
                var paym = data.payment;

                var forecast = data.forecast_code;
                  console.log(forecast);
                var quot_code = data.quot_code;
                var customer = cust.cust_code;
                var payment = paym.id;
                var currency = curr.currency_code;

                var currencyx = curr.currency_name;
                var symbol = curr.symbol;

                var curr_w_sym = symbol + ' - ' + currencyx;

                var productsMatrix = data.products;
                var products = JSON.parse(productsMatrix);

                var myTablex = document.getElementById("product-dt-e");

                var rowCount = myTablex.rows.length;
                for (var x=rowCount-1; x>0; x--) 
                  {
                    myTablex.deleteRow(x); 
                  }
                
                var forecastx = 'e';
                
                for(i in products)
                  {
                    for(j in products[i].seq)
                    {
                      Prod_codeE.push(products[i].prod_code);

                      AppendString += 
                          "<tr><td>" + products[i].prod_code + 
                          "</td><td>" + products[i].prod_name + 
                          "</td><td>" + products[i].uom_code + 
                          "</td><td>" + products[i].currency_code  + 
                          "</td><td>" + products[i].unit_price  + 
                          "</td><td>" + products[i].quantity   + 
                          "</td><td>" + products[i].total_price  + 
                          "</td><td>" + '<a href="#" class="btn-small red waves-effect waves-light" onclick="deleteRow(this,\''+ forecastx +'\')" ><i class="material-icons small icon-demo">delete_sweep</i></a>' + 
                                          '</td><input type="hidden" name="e_seq_code[]" value="'+ rowCount +'"/>' +
                                          '<input type="hidden" name="e_quot_code[]" value="'+ quot_code +'"/>' +
                                          '<input type="hidden" name="e_prod_code[]" value="'+ products[i].prod_code +'"/>' +
                                          '<input type="hidden" name="e_prod_name[]" value="'+ products[i].prod_name +'"/>' +
                                          '<input type="hidden" name="e_uom[]" value="'+ products[i].uom_code +'"/>' +
                                          '<input type="hidden" name="e_curr_code[]" value="'+  products[i].currency_code +'"/>' +
                                          '<input type="hidden" name="e_unit_price[]" value="'+ products[i].unit_price +'"/>' +
                                          '<input type="hidden" name="e_quantity[]" value="'+ products[i].quantity +'"/>' +
                                          '<input type="hidden" name="e_total_price[]" value="'+ products[i].total_price +'"/></td></tr>';
                    }
                  }

      
                $('#product-dt-e').find('tbody').append(AppendString);

                if(forecast=='' || forecast==null)
                {
                  var x = document.getElementById("efcode");
                  x.style.display = "none";
                } 
                else 
                {
                  $('#edit_forecast_code').val(forecast);
                  var x = document.getElementById("efcode");
                  x.style.display = "block";
                }

                $('#edit_id').val(data.id);
                $('#edit_quotation_code').val(quot_code);
               
                $('#edit_customer_code option[value="'+customer+'"]').prop('selected', true);
                $('#edit_customer_code').formSelect();
                $('#edit_payment_term option[value="'+payment+'"]').prop('selected', true);
                $('#edit_payment_term').formSelect();
                $('#edit_currency_code option[value="'+currency+'"]').prop('selected', true);
                $('#edit_currency_code').formSelect();

                computeTotal('edit');
                computeGrandTotal('e');
                $('#editModal').modal('open');
            
        });
    }

    function viewItem(id)
    {
        $('.tabs').tabs('select','view_details');
        $.get('quotation/'+id, function(response){
               
                var AppendString = "";
                var i, j = "";
                var data = response.data;

                console.log(data);
      
                var cust = data.customers;
                var curr = data.currency;
                var paym = data.payment;

                var quot_code = data.quot_code;
                var forecast = data.forecast_code;
                var customer = cust.cust_name;
                var payment = paym.term_name;

                var currency = curr.currency_name;
                var symbol = curr.symbol;

                var curr_w_sym = symbol + ' - ' + currency;

                var productsMatrix = data.products;
                var products = JSON.parse(productsMatrix);



                var myTablex = document.getElementById("product-dt-v");

                var rowCount = myTablex.rows.length;
                for (var x=rowCount-1; x>0; x--) 
                  {
                    myTablex.deleteRow(x); 
                  }
                  
                
                for(i in products)
                  {
                    for(j in products[i].seq)
                    {
                      AppendString += 
                          "<tr><td>" + products[i].prod_code + 
                          "</td><td>" + products[i].prod_name + 
                          "</td><td>" + products[i].uom_code + 
                          "</td><td>" + products[i].currency_code  + 
                          "</td><td>" + products[i].unit_price  + 
                          "</td><td>" + products[i].quantity   + 
                          "</td><td>" + products[i].total_price  + 
                            "</td></tr>";
                    }
                  }

                $('#product-dt-v').find('tbody').append(AppendString);

                $('#v_quotation_code').val(quot_code);
                $('#v_customer_code').val(customer);
                $('#v_payment_term').val(payment);
                $('#v_currency_code').val(curr_w_sym);

                if(forecast=='' || forecast==null)
                {
                  var x = document.getElementById("facode");
                  x.style.display = "none";
                } 
                else 
                {
                  $('#v_forecast_code').val(forecast);
                  var x = document.getElementById("facode");
                  x.style.display = "block";
                }

            $('#viewModal').modal('open');
            computeGrandTotal('v');
        });
    }

    function appItem(id)
    {
        $('.tabs').tabs('select','app_details');
        $.get('quotation/'+id, function(response){

          var AppendString = "";
                var i, j = "";
                var data = response.data;

                console.log(data);
      
                var cust = data.customers;
                var curr = data.currency;
                var paym = data.payment;

                var quot_code = data.quot_code;
                var forecast = data.forecast_code;
                var customer = cust.cust_name;
                var payment = paym.term_name;

                var currency = curr.currency_name;
                var symbol = curr.symbol;

                var curr_w_sym = symbol + ' - ' + currency;

                var productsMatrix = data.products;
                var products = JSON.parse(productsMatrix);



                var myTablex = document.getElementById("product-dt-app");

                var rowCount = myTablex.rows.length;
                for (var x=rowCount-1; x>0; x--) 
                  {
                    myTablex.deleteRow(x); 
                  }
                  
                
                for(i in products)
                  {
                    for(j in products[i].seq)
                    {
                      AppendString += 
                          "<tr><td>" + products[i].prod_code + 
                          "</td><td>" + products[i].prod_name + 
                          "</td><td>" + products[i].uom_code + 
                          "</td><td>" + products[i].currency_code  + 
                          "</td><td>" + products[i].unit_price  + 
                          "</td><td>" + products[i].quantity   + 
                          "</td><td>" + products[i].total_price  + 
                            "</td></tr>";
                    }
                  }

                $('#product-dt-app').find('tbody').append(AppendString);

                $('#id_app').val(data.id);
                $('#seq_app').val(data.current_sequence);
                $('#appid_app').val(data.current_approver);

                $('#app_quotation_code').val(quot_code);
                $('#app_customer_code').val(customer);
                $('#app_payment_term').val(payment);
                $('#app_currency_code').val(curr_w_sym);

                if(forecast=='' || forecast==null)
                {
                  var x = document.getElementById("fcode");
                  x.style.display = "none";
                } 
                else 
                {
                  $('#app_forecast_code').val(forecast);
                  var x = document.getElementById("fcode");
                  x.style.display = "block";
                }

                computeGrandTotal('a');
                $('#appModal').modal('open'); 
        
        });
    }

    function deleteItem(id,quot)
    {
        $('#del_id').val(id);
        $('#del_quot').val(quot);
        $('#deleteModal').modal('open');
    }

    function deleteRow(r,loc) 
    {
      var locx = loc;
      if(locx=='f')
      {
        var i = r.parentNode.parentNode.rowIndex;
        var x = r.parentNode.parentNode.cells.item(0).innerHTML;
        var index = Prod_codeF.indexOf(x)
        Prod_codeF.splice(index)
        document.getElementById("product-dt-f").deleteRow(i);
        computeGrandTotal('f');
      } 
      else if(locx=='e')
      {
        var i = r.parentNode.parentNode.rowIndex;
        var x = r.parentNode.parentNode.cells.item(0).innerHTML;
        var index = Prod_codeE.indexOf(x)
        Prod_codeE.splice(index)
        document.getElementById("product-dt-e").deleteRow(i);
        computeGrandTotal('e');
      }
      else
      {
        var i = r.parentNode.parentNode.rowIndex;
        var x = r.parentNode.parentNode.cells.item(0).innerHTML;
        var index = Prod_code.indexOf(x)
        Prod_code.splice(index)
        document.getElementById("product-dt").deleteRow(i);
        computeGrandTotal('m');
      }
    }

    // (this,\''+ forecastx +'\')
    var quotation = $('#quotation-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/quotation/all",
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
                    return  '<a href="#" onclick="viewItem('+data+'), getApproverMatrix('+row.id+',\'v\')">'+row.quot_code+'</a>';
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
                  }
                   
                }
            },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    if(row.status=='Pending')
                    {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="getApprover(2,\'edit\',\'Sales Quotation\'), editItem(\''+(row.quot_code)+'\')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+',\''+(row.quot_code)+'\')"><i class="material-icons">delete</i></a>';
                    }
                    else
                    {
                      return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem(\''+(row.quot_code)+'\')" disabled><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+',\''+(row.quot_code)+'\')" disabled><i class="material-icons">delete</i></a>';
                    }

                }
            }
        ]
    });

    var quotapproval = $('#approval-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/quotation/all_approval",
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
                    return  '<a href="#" onclick="viewItem('+data+'), getApproverMatrix('+row.id+',\'v\')">'+row.quot_code+'</a>';
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
                  }
                   
                }
            },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="appItem('+row.id+'), getApproverMatrix('+row.id+',\'x\')"><i class="material-icons">rate_review</i></a>';
                }
            }
        ]
    });


  </script>

  <!-- End of SCRIPTS -->

@endsection
