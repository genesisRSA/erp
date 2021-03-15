@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales <i class="material-icons">arrow_forward_ios</i></span> Sales Visit</h4>
    </div>
  </div>
  <div class="row main-content">

    <div class="col s12 m12 l12">
      <div class="card" style="margin-top: 0px">
        <div class="card-content">
          <table class="responsive-table highlight" id="visit-dt" style="width: 100%">
            <thead>
              <tr>
                  <th>ID</th> 
                  <th>Site</th>
                  <th>Visit Code</th>
                  <th>Location Name</th>
                  <th>Date Visit</th>

              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <a href="{{ route('visit.create') }}" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button"  data-position="left" data-tooltip="Add Sales Visit Details"><i class="material-icons">add</i></a>

  </div>

  <!-- MODALS -->

  <div id="addModal" class="modal">
    {{-- <form method="POST" action="{{route('forecast.store')}}"> --}}
      <form>
    @csrf
      <div class="modal-content">
        <h4>Add Sales Forecast</h4>

        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#forecast">Forecast Details</a></li>
          {{-- need ID and module for getApprover()  --}}
          <li class="tab col s12 m4 l4"><a href="#signatories">Signatories</a></li>
        </ul><br>

        <div id="forecast" name="forecast">

          <div class="row">
            <div class="input-field col s12 m4 l6">
              {{-- <input type="text" id="add_forecast_code" name="forecast_code" value="{{$forecast}}{{$today}}-{{$lastforecast}}" readonly/> --}}
              <label for="forecast_code">Forecast Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="add_forecast_year" name="forecast_year" onchange="getApprover(1,'add','Sales Forecast');" required>
                <option value="" disabled selected>Choose your option</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
              </select>
              <label for="forecast_year">Forecast Year<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="add_forecast_month" name="forecast_month" required>
                <option value="" disabled selected>Choose your option</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
              <label for="forecast_month">Forecast Month<sup class="red-text">*</sup></label>
            </div> 
          </div>

          <div class="row">
            <div class="input-field col s12 m4 l4">
              <select id="add_site_code" name="site_code" required>
                <option value="" disabled selected>Choose your option</option>
                @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l5">
              <select id="add_prod_code" name="prod_code" required>
                <option value="" disabled selected>Choose your option</option>
                {{-- @foreach ($products as $prod)
                  <option value="{{$prod->prod_code}}">{{$prod->prod_name}}</option>
                @endforeach --}}
              </select>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="add_uom_code" name="uom_code" required>
                <option value="0" disabled selected>Choose your option</option>
                {{-- @foreach ($uoms as $uom)
                  <option value="{{$uom->uom_code}}">{{$uom->uom_name}}</option>
                @endforeach --}}
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row">
            <div class="input-field col s12 m3 l3">
              <select id="add_currency_code" name="currency_code" onchange="computeTotal('add');" required>
                <option value="0" disabled selected>Choose your option</option>
                {{-- @foreach ($currencies as $curr)
                  <option value="{{$curr->currency_code}}">{{$curr->symbol}} - {{$curr->currency_name}}</option>
                @endforeach --}}
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0.0000" id="add_unit_price" name="unit_price" type="number" step="0.0001" style="text-align: right" class="number validate" onkeyup="computeTotal('add');" required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              {{--  pattern="^[\d,]+$" --}}
              <input placeholder="0" id="add_quantity" name="quantity" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('add');" required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0.0000" id="add_total_price" name="total_price" type="text" step="0.0001"  style="text-align: right" class="number" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
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

  <div id="editModal" class="modal">
    {{-- <form method="POST" action="{{route('forecast.patch')}}"> --}}
      <form>
    @csrf
      <div class="modal-content">
        <h4>Edit Sales Forecast Details</h4>

        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#edit-forecast">Forecast Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#edit-signatories" onclick="getApprover(1,'edit','Sales Forecast');">Signatories</a></li>
        </ul><br>

        <div id="edit-forecast" name="edit-forecast">
          <input type="hidden" name="id" id="edit_id">
          <div class="row">
            <div class="input-field col s12 m4 l6">
              <input type="text" id="edit_forecast_code" name="forecast_code" placeholder="FORECAST" readonly/>
              <label for="forecast_code">Forecast Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="edit_forecast_year" name="forecast_year" required>
                <option value="" disabled selected>Choose your option</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
              </select>
              <label for="forecast_year">Forecast Year<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="edit_forecast_month" name="forecast_month" required>
                <option value="" disabled selected>Choose your option</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
            {{-- <input type="text" name="edit_forecast_month" id="forecast_month" class="datepicker"> --}}
              <label for="forecast_month">Forecast Month<sup class="red-text">*</sup></label>
            </div> 
          </div>

          <div class="row">
            <div class="input-field col s12 m4 l4">
              <select id="edit_site_code" name="site_code" required>
                <option value="" disabled selected>Choose your option</option>
                {{-- @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach --}}
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

          

            <div class="input-field col s12 m4 l5">
              <select id="edit_prod_code" name="prod_code" required>
                <option value="" disabled selected>Choose your option</option>
                {{-- @foreach ($products as $prod)
                  <option value="{{$prod->prod_code}}">{{$prod->prod_name}}</option>
                @endforeach --}}
              </select>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <select id="edit_uom_code" name="uom_code" required>
                <option value="0" disabled selected>Choose your option</option>       
                  {{-- @foreach ($uoms as $i)
                    <option value="{{$i->uom_code}}">{{$i->uom_name}}</option>
                  @endforeach --}}
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row">
            <div class="input-field col s12 m3 l3">
              <select id="edit_currency_code" name="currency_code" onchange="computeTotal('edit');" required>
                <option value="0" disabled selected>Choose your option</option>
                {{-- @foreach ($currencies as $curr)
                  <option value="{{$curr->currency_code}}">{{$curr->symbol}} - {{$curr->currency_name}}</option>
                @endforeach --}}
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0.0000" id="edit_unit_price" name="unit_price" type="number" step="0.0001" style="text-align: right" class="number validate" onkeyup="computeTotal('edit');" required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              {{--  pattern="^[\d,]+$" --}}
              <input placeholder="0" id="edit_quantity" name="quantity" type="number" style="text-align: right" class="number validate" onkeyup="computeTotal('edit');" required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="edit_total_price" name="total_price" type="text" step="0.0001" style="text-align: right" class="number validate" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>

          </div>

        </div>
 
        <div id="edit-signatories" name="edit-signatories">

          {{-- current signatories --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-edit">
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
        <h4>Sales Forecast Details</h4>

        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#view-forecast">Forecast Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#view-signatories">Signatories</a></li>
        </ul><br>

        <div id="view-forecast" name="view-forecast">
          <input type="hidden" name="id" id="view_id">
          <div class="row">
            <div class="input-field col s12 m4 l6">
              <input type="text" id="view_forecast_code" name="forecast_code" placeholder="FORECAST" readonly/>
              <label for="forecast_code">Forecast Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <input placeholder="0" type="text" id="view_forecast_year" name="forecast_year" readonly>
              <label for="forecast_year">Forecast Year<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <input placeholder="0" type="text" id="view_forecast_month" name="forecast_month" readonly>
              <label for="forecast_month">Forecast Month<sup class="red-text">*</sup></label>
            </div> 
          </div>

          <div class="row">
            <div class="input-field col s12 m4 l4">
              <input placeholder="0" type="text" id="view_site_code" name="site_code" readonly>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l5">
              <input placeholder="0" type="text" id="view_prod_code" name="prod_code" readonly>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m4 l3">
              <input placeholder="0" type="text" id="view_uom_code" name="uom_code" readonly>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row">
            <div class="input-field col s12 m3 l3">
              <input placeholder="0.0000" type="text" id="view_currency_code" name="currency_code" readonly>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0.0000" id="view_unit_price" name="unit_price" type="number" step="0.0001" style="text-align: right" class="number validate" readonly>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="view_quantity" name="quantity" type="number" style="text-align: right" class="number validate" readonly>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="view_total_price" name="total_price" type="text" step="0.0001" style="text-align: right" class="number validate" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>

          </div>

        </div>
 
        <div id="view-signatories" name="view-signatories">

          {{-- current signatories --}}
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <h6 style="padding: 10px; padding-top: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Current Signatories</b></h6><hr style="margin: 0px">
                <div class="card-content" style="padding: 10px; padding-top: 0px">
                  <table class="highlight" id="matrix-dt-view">
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
                  <table class="highlight" id="matrix-dt-view-h">
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
        <a href="#!" class="modal-close green waves-effect waves-light btn"><i class="material-icons left">keyboard_return</i>Return</a>
      </div>
    </form>
  </div>

  <div id="appModal" class="modal">
    {{-- <form method="POST" action="{{route('forecast.approve')}}"> --}}
    <form>
    @csrf
      <div class="modal-content">
        <h4>Sales Forecast Details Approval</h4>

        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#app-forecast">Forecast Details</a></li>
          <li class="tab col s12 m4 l4"><a href="#app-signatories" id="app_signatories">Signatories</a></li>
        </ul><br>

        {{-- hidden items --}}
        <input type="hidden" name="id" id="id_app"/>
        <input type="hidden" name="seq" id="seq_app"/>
        <input type="hidden" name="appid" id="appid_app"/>
        <input type="hidden" name="appname" id="appname_app">
        {{-- hidden items --}}

        <div id="app-forecast" name="app-forecast">
          <div class="row">
            <div class="input-field col s12 m4 l6">
              <input placeholder="0" type="text" id="app_forecast_code" name="forecast_code" readonly>
              <label for="forecast_code">Forecast Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m2 l3">
              <input placeholder="0" type="text" id="app_forecast_year" name="forecast_year" readonly>
              <label for="forecast_year">Forecast Year<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m2 l3">
              <input placeholder="0" type="text" id="app_forecast_month" name="forecast_month" readonly>
              <label for="forecast_month">Forecast Month<sup class="red-text">*</sup></label>
            </div> 
          </div>

          <div class="row">
            <div class="input-field col s12 m3 l4">
              <input placeholder="0" type="text" id="app_site_code" name="site_code" readonly>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l5">
              <input placeholder="0" type="text" id="app_prod_code" name="prod_code" readonly>
              <label for="prod_code">Product<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" type="text" id="app_uom_code" name="uom_code" readonly>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row">
            <div class="input-field col s12 m3 l3">
              <input placeholder="0" type="text" id="app_currency_code" name="currency_code" readonly>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="app_unit_price" name="unit_price" type="text" style="text-align: right" class="number validate" readonly>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="app_quantity" name="quantity" type="number" style="text-align: right" class="number validate" readonly>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="app_total_price" name="total_price" type="text" style="text-align: right" class="number validate" readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>
 

          </div>
          <hr style="padding:1px;color:blue;background-color:blue">

        </div>
 
        <div id="app-signatories" name="app-signatories">

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

          {{-- history signatories --}}
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
          <hr style="padding:1px;color:blue;background-color:blue">
        </div>
        
      </div>
      <div class="modal-footer">

     
        <div class="row" style="padding: 10px">

          <div class="input-field col s12 m9 l9">

            {{-- <i class="material-icons prefix">mode_edit</i> --}}
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
    {{-- <form method="POST" action="{{route('forecast.delete')}}"> --}}
      <form>
        @csrf
        <div class="modal-content">
            <h4>Delete Sales Forecast Details</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Sales Visit Details</strong>?</p>
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
  {{-- AIzaSyB_d6VrUMGRuMiQcBEfqwOvhrlJv86AyOA --}}
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['map_apikey']}}&callback=initMaps" async defer></script> --}}

  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  {{-- <script type="text/javascript" src="{{ asset('js/googlemap.js') }}"></script> --}}
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script> 
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

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


    });

    function getStatus(status)
    {
      var stat = status;
      $('#status').val(stat);
    }

    function getApprover(id, loc, modules)
    {     
          $('.tabs').tabs('select','forecast');
          $.get('forecast/getApprover/'+id+'/'+modules, function(response){

                var AppendString = "";
                var i, j = "";
                var data = response.data;
                var dataMatrix = data.matrix;
                var matrix = JSON.parse(dataMatrix);
               

                if(loc=='add'){
                  var myTable = document.getElementById("matrix-dt");
                } 
                else if(loc=='edit') {
                  var myTable = document.getElementById("matrix-dt-edit");
                } 
                else if(loc=='view') {
                  var myTable = document.getElementById("matrix-dt-view");
                } 
              
                var rowCount = myTable.rows.length;
                for (var x=rowCount-1; x>0; x--) 
                  {
                    myTable.deleteRow(x); 
                  }
                
                console.log(matrix);
               
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
                else if(loc=='edit') {
                  $('#matrix-dt-edit').find('tbody').append(AppendString);
                }
                else if(loc=='view') {
                  $('#matrix-dt-view').find('tbody').append(AppendString);
                }
          });
    } 

    function getApproverMatrix(id, loc)
    {
          $.get('forecast/getApproverMatrix/'+id, function(response){

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
                var myTable = document.getElementById("matrix-dt-view");
                var myTableH = document.getElementById("matrix-dt-view-h");
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
                  $('#matrix-dt-view').find('tbody').append(AppendString);
                  $('#matrix-dt-view-h').find('tbody').append(AppendStringH);
                  }
                  else
                  {
                  $('#matrix-dt-app').find('tbody').append(AppendString);
                  $('#matrix-dt-app-h').find('tbody').append(AppendStringH);
                  }

          });
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

      } else {
        var unit_price = $('#edit_unit_price').val();
        var quantity = $('#edit_quantity').val();

        var e = document.getElementById('edit_currency_code');
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
      var totalprice = formatter.format(total_price);
      var total_price_w_com = addCommas(totalprice);
      var total_w_currency = currency + ' ' + total_price_w_com;
      //var total_w_currency = total_price_w_com + ' ' + currency;

      if(loc=='add')
      {
        $('#add_total_price').val(total_w_currency);
      } else {
        $('#edit_total_price').val(total_w_currency);
      }
    }

    function addCommas(x) 
    {
      var parts = x.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
    }

    function editItem(id)
    {
        $('.tabs').tabs('select','edit-forecast');
        $.get('forecast/'+id, function(response){
            var data = response.data;
            $('#edit_id').val(data.id);
            $('#edit_forecast_code').val(data.forecast_code);

            $('#edit_forecast_year option[value="'+data.forecast_year+'"]').prop('selected', true);
            $('#edit_forecast_year').formSelect();
            $('#edit_forecast_month option[value="'+data.forecast_month+'"]').prop('selected', true);
            $('#edit_forecast_month').formSelect();
            $('#edit_site_code option[value="'+data.site_code+'"]').prop('selected', true);
            $('#edit_site_code').formSelect();
            $('#edit_prod_code option[value="'+data.prod_code+'"]').prop('selected', true);
            $('#edit_prod_code').formSelect();
            $('#edit_uom_code option[value="'+data.uom_code+'"]').prop('selected', true);
            $('#edit_uom_code').formSelect();
            $('#edit_currency_code option[value="'+data.currency_code+'"]').prop('selected', true);
            $('#edit_currency_code').formSelect();
    
            $('#edit_unit_price').val(data.unit_price);
            $('#edit_quantity').val(data.quantity);
            $('#edit_total_price').val(data.total_price);

            $('#editModal').modal('open');
            
        });
    }

    function viewItem(id)
    {
        $('.tabs').tabs('select','view-forecast');
        $.get('forecast/'+id, function(response){
            var data = response.data;
            var curr_symbol = data.currency.symbol;
            var curr_name = data.currency.currency_name;
            var currency =  curr_symbol + ' - ' + curr_name;
            
            
            $('#view_id').val(data.id);
            $('#view_forecast_code').val(data.forecast_code);
            $('#view_forecast_year').val(data.forecast_year);
            $('#view_forecast_month').val(data.forecast_month);
            $('#view_site_code').val(data.sites.site_desc);
            $('#view_prod_code').val(data.products.prod_name);
            $('#view_uom_code').val(data.uoms.uom_name);
            $('#view_currency_code').val(currency);
            $('#view_unit_price').val(data.unit_price);
            $('#view_quantity').val(data.quantity);
            $('#view_total_price').val(data.total_price);

            $('#viewModal').modal('open');
            
        });
    }

    function appItem(id)
    {
        $('.tabs').tabs('select','app-forecast');
        $.get('forecast/'+id, function(response){

            const formatter = new Intl.NumberFormat('en-US', {
              minimumFractionDigits: 4,      
              maximumFractionDigits: 4,
            });

            var data = response.data;
            var dataUP = data.unit_price;
            var dataTP = data.total_price;
            var curr_x = data.currency;
            var curr_name = curr_x.currency_name;
            var curr = dataTP.substr(dataTP, 1);
            
            dataTP = dataTP.substr(2);
            dataTP = dataTP.replace(/,/g, "");

            var dataUPx = formatter.format(dataUP);
            var dataTPx = formatter.format(dataTP);
            var unitPrice = addCommas(dataUPx);
            var totalPrice = addCommas(dataTPx)
            totalPrice = curr + " " + totalPrice;

            $('#id_app').val(data.id);
            $('#seq_app').val(data.current_sequence);
            $('#appid_app').val(data.current_approver);
            
            $('#app_forecast_code').val(data.forecast_code);
            $('#app_forecast_year').val(data.forecast_year);
            $('#app_forecast_month').val(data.forecast_month);
            $('#app_site_code').val(data.site_code);
            $('#app_prod_code').val(data.prod_code);
            $('#app_uom_code').val(data.uom_code);
            $('#app_currency_code').val(curr_name);
            $('#app_unit_price').val(unitPrice);
            $('#app_quantity').val(data.quantity);
            $('#app_total_price').val(totalPrice);

            $('#appModal').modal('open');
            
        });
    }

    function deleteItem(id)
    {
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    var visits = $('#visit-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/reiss/visit/all",
        "columns": [
            {  "data": "id" },
            {   "data": "id",
                "render": function ( data, type, row, meta ) {
                  return row.sites.site_desc;
                }
            },
            {  "data": "visit_code" },
            {  "data": "loc_name" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+row.id+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
                }
            }
        ]
    });

    // var approvaldt = $('#approval-dt').DataTable({
    //     "lengthChange": false,
    //     "pageLength": 15,
    //     "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
    //     "pagingType": "full",
    //     "ajax": "/api/reiss/forecast/all_approval",
    //     "columns": [
    //       {  "data": "id" },
    //         {   "data": "id",
    //             "render": function ( data, type, row, meta ) {
    //               return row.sites.site_desc;
    //             }
    //         },
    //         {  "data": "prod_code" },
    //         {
    //             "data": "id",
    //             "render": function ( data, type, row, meta ) {
    //                 return  '<a href="#" onclick="viewItem('+row.id+'), getApproverMatrix('+row.id+',\'v\')">'+row.forecast_code+'</a>';
    //             }
    //         },
    //         {   "data": "id",
    //             "render": function ( data, type, row, meta ) {
    //               return row.employee_details.full_name;
    //             }
    //         },
    //         {
    //             "data": "status",
    //             "render": function ( data, type, row, meta ) {
    //               switch(data){
    //                 case 'Approved':
    //                   return  '<span class="badge green white-text">Approved</span>';
    //                 break;
    //                 case 'Pending':
    //                   return  '<span class="badge blue white-text">Pending</span>';
    //                 break;
    //                 case 'Rejected':
    //                   return  '<span class="badge red white-text">Rejected</span>';
    //                 break;
    //                 case 'For Approval':
    //                   return  '<span class="badge yellow white-text">For Approval</span>';
    //                 break;
    //                 case 'For Review':
    //                   return  '<span class="badge yellow white-text">For Review</span>';
    //                 break;
    //               }
                   
    //             }
    //         },
    //         {
    //             "data": "id",
    //             "render": function ( data, type, row, meta ) {
    //                 return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="appItem('+row.id+'), getApproverMatrix('+row.id+',\'x\')"><i class="material-icons">rate_review</i></a>';
    //             }
    //         }
    //     ]
    // });


  </script>

  <!-- End of SCRIPTS -->

@endsection
