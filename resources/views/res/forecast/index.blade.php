@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales<i class="material-icons">arrow_forward_ios</i></span> Sales Forecast</h4>
    </div>
  </div>
  <div class="row main-content">
  
    {{-- <ul id="tabs-swipe-demo" class="tabs"> --}}
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s12 m4 l4"><a class="active" href="#ongoing">On-going Forecasts</a></li>
      <li class="tab col s12 m4 l4"><a href="#approval">For Approval</a></li>
    </ul>

    <div id="ongoing" name="ongoing">
      <div class="col s12 m12">
        <div class="card">
          <div class="card-content">
            <table class="responsive-table highlight" id="forecast-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Site Code</th>
                    <th>Product Code</th>
                    <th>Forecast Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      
      <a href="#addModal" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped modal-trigger" id="add-button" data-position="left" data-tooltip="Add Sales Forecast Details"><i class="material-icons">add</i></a>
    </div>

    <div id="approval" name="approval">
      <div class="col s12 m12 l12">
        <div class="card">
          <div class="card-content">
            <table class="responsive-table highlight" id="approval-dt" style="width: 100%">
              <thead>
                <tr>
                    <th>ID</th> 
                    <th>Site Code</th>
                    <th>Product Code</th>
                    <th>Forecast Code</th>
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

  </div>

  <!-- MODALS -->

  <div id="addModal" class="modal">
    <form method="POST" action="{{route('forecast.store')}}">
      <form>
    @csrf
      <div class="modal-content">
        <h4>Add Sales Forecast</h4>

        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s12 m4 l4"><a class="active" href="#forecast">Forecast Details</a></li>
          {{-- need ID and module for getApprover()  --}}
          <li class="tab col s12 m4 l4"><a href="#signatories" onclick="getApprover(1,'add','Sales Forecast');">Signatories</a></li>
        </ul><br>

        <div id="forecast" name="forecast">

          <div class="row">
            <div class="input-field col s12 m4 l6">
              <input type="text" id="add_forecast_code" name="forecast_code" value="{{$forecast}}{{$today}}-{{$lastforecast}}" readonly/>
              <label for="forecast_code">Forecast Code<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m2 l3">
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

            <div class="input-field col s12 m2 l3">
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
            <div class="input-field col s12 m3 l4">
              <select id="add_site_code" name="site_code" required>
                <option value="" disabled selected>Choose your option</option>
                @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l5">
              <select id="add_prod_code" name="prod_code" required>
                <option value="" disabled selected>Choose your option</option>
                @foreach ($products as $prod)
                  <option value="{{$prod->prod_code}}">{{$prod->prod_name}}</option>
                @endforeach
              </select>
              <label for="prod_code">Item<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <select id="add_uom_code" name="uom_code" required>
                <option value="0" disabled selected>Choose your option</option>
                @foreach ($uoms as $uom)
                  <option value="{{$uom->uom_code}}">{{$uom->uom_name}}</option>
                @endforeach
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          </div>

          <div class="row">
            <div class="input-field col s12 m3 l3">
              <select id="add_currency_code" name="currency_code" onchange="computeTotal('add');" required>
                <option value="0" disabled selected>Choose your option</option>
                @foreach ($currencies as $curr)
                  <option value="{{$curr->symbol}}">{{$curr->currency_name}}</option>
                @endforeach
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0.00" id="add_unit_price" name="unit_price" type="text" class="number validate" onchange="computeTotal('add');" required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              {{--  pattern="^[\d,]+$" --}}
              <input placeholder="0" id="add_quantity" name="quantity" type="text" class="number validate" onchange="computeTotal('add');" required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="add_total_price" name="total_price" type="text" class="number" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>

          </div>

        </div>

        <div id="signatories" name="signatories">

          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <div class="card-content">
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
    <form method="POST" action="{{route('forecast.patch')}}">
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

            <div class="input-field col s12 m2 l3">
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

            <div class="input-field col s12 m2 l3">
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
            <div class="input-field col s12 m3 l4">
              <select id="edit_site_code" name="site_code" required>
                <option value="" disabled selected>Choose your option</option>
                @foreach ($sites as $site)
                  <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                @endforeach
              </select>
              <label for="site_code">Site<sup class="red-text">*</sup></label>
            </div>

          

            <div class="input-field col s12 m3 l5">
              <select id="edit_prod_code" name="prod_code" required>
                <option value="" disabled selected>Choose your option</option>
                @foreach ($products as $prod)
                  <option value="{{$prod->prod_code}}">{{$prod->prod_name}}</option>
                @endforeach
              </select>
              <label for="prod_code">Item<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <select id="edit_uom_code" name="uom_code" required>
                <option value="0" disabled selected>Choose your option</option>       
                  @foreach ($uoms as $i)
                    <option value="{{$i->uom_code}}">{{$i->uom_name}}</option>
                  @endforeach
              </select>
              <label for="uom_code">Unit of Measure<sup class="red-text">*</sup></label>
            </div>

          

          </div>

          <div class="row">
            <div class="input-field col s12 m3 l3">
              <select id="edit_currency_code" name="currency_code" onchange="computeTotal('edit');" required>
                <option value="0" disabled selected>Choose your option</option>
                @foreach ($currencies as $curr)
                  <option value="{{$curr->symbol}}">{{$curr->currency_name}}</option>
                @endforeach
              </select>
              <label for="currency_code">Currency<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0.00" id="edit_unit_price" name="unit_price" type="text" class="number validate" onchange="computeTotal('edit');" required>
              <label for="unit_price">Unit Price<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              {{--  pattern="^[\d,]+$" --}}
              <input placeholder="0" id="edit_quantity" name="quantity" type="text" class="number validate" onchange="computeTotal('edit');" required>
              <label for="quantity">Quantity<sup class="red-text">*</sup></label>
            </div>

            <div class="input-field col s12 m3 l3">
              <input placeholder="0" id="edit_total_price" name="total_price" type="text" class="number validate" required readonly>
              <label for="total_price">Total Price<sup class="red-text">*</sup></label>
            </div>

          </div>

        </div>

        <div id="edit-signatories" name="edit-signatories">

          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card">
                <div class="card-content">
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

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('forecast.delete')}}">
        @csrf
        <div class="modal-content">
            <h4>Delete Sales Forecast Details</h4><br><br>
            <div class="row">
                <div class="col s12 m6">
                    <input type="hidden" name="id" id="del_id">
                    <p>Are you sure you want to delete this <strong>Sales Forecast Details</strong>?</p>
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


    $(document).ready(function () {
        $('.tabs').tabs();

        $('#add_item_cat_code').change(function () {
             var id = $(this).val();

          $('#add_item_subcat_code').find('option').remove();

            $.ajax({
              url:'/rgc_entsys/item_master/getSubCategory/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#add_item_subcat_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].subcat_code;
                            var name = response.data[i].subcat_desc;

                            var option = "<option value='"+id+"'>"+name+"</option>"; 
                            dropdown.append(option);
                      }
                  }
                  dropdown.formSelect();
              }
            });
        });

        $('#edit_item_cat_code').change(function () {
             var id = $(this).val();

          $('#edit_item_subcat_code').find('option').remove();

            $.ajax({
              url:'/rgc_entsys/item_master/getSubCategory/'+id,
              type:'get',
              dataType:'json',
              success:function (response) {
                  var dropdown = $("#edit_item_subcat_code");
                  var len = 0;
                  if (response.data != null) {
                      len = response.data.length;
                  }

                  if (len>0) {
                      for (var i = 0; i<len; i++) {
                            var id = response.data[i].subcat_code;
                            var name = response.data[i].subcat_desc;

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

    });

    function getApprover(id, loc, modules){

          $.get('forecast/getApprover/'+id+'/'+modules, function(response){

                var AppendString = "";
                var i, j = "";
                var data = response.data;
                var dataMatrix = data.matrix;
                console.log(dataMatrix);
                var matrix = JSON.parse(dataMatrix);
                console.log(matrix);

                if(loc=='add'){
                  var myTable = document.getElementById("matrix-dt");
                } else {
                  var myTable = document.getElementById("matrix-dt-edit");
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
                } else {
                  $('#matrix-dt-edit').find('tbody').append(AppendString);
                }

            });
    } 

    function computeTotal(loc)
    {
      if(loc=='add')
      {
        var unit_price = $('#add_unit_price').val();
        var quantity = $('#add_quantity').val();
        var currency = $('#add_currency_code').val();
      } else {
        var unit_price = $('#edit_unit_price').val();
        var quantity = $('#edit_quantity').val();
        var currency = $('#edit_currency_code').val();
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

      unit_price = unit_price.replace(/,/g, "");

      var total_price = unit_price * quantity;

      var total_w_currency = currency + '' + total_price;

      if(loc=='add')
      {
        $('#add_total_price').val(total_w_currency);
      } else {
        $('#edit_total_price').val(total_w_currency);
      }
    }

    function editItem(id){
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

    function deleteItem(id){
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

 var forecast = $('#forecast-dt').DataTable({
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/rgc_entsys/forecast/all",
        "columns": [
            {  "data": "id" },
            {  "data": "site_code" },
            {  "data": "prod_code" },
            {  "data": "forecast_code" },
            {  "data": "status" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+row.id+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
                }
            }
        ]
    });


   var approvaldt = $('#approval-dt').DataTable({
        "responsive": true,
        "lengthChange": false,
        "pageLength": 15,
        "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
        "pagingType": "full",
        "ajax": "/api/rgc_entsys/forecast/all_approval",
        "columns": [
          {  "data": "id" },
            {  "data": "site_code" },
            {  "data": "prod_code" },
            {  "data": "forecast_code" },
            {  "data": "created_by" },
            {  "data": "status" },
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small blue darken3 waves-effect waves-dark" onclick="checkApproval('+row.id+')"><i class="material-icons">rate_review</i></a>';
                }
            }
        ]
    });


  </script>

  <!-- End of SCRIPTS -->

@endsection
