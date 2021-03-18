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
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <a href="{{ route('visit.create') }}" class="btn-floating btn-large waves-effect waves-light green add-button tooltipped" id="add-button"  data-position="left" data-tooltip="Add Sales Visit Details"><i class="material-icons">add</i></a>

  </div>

  <!-- MODALS -->

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

  <div id="viewModal" class="modal dismissable">
    <form>
    @csrf
      <div class="modal-content" style="padding-bottom: 0px">
        <h4>Visit Location</h4>
        <div id="map" class="center"></div>
      </div>
      <div class="modal-footer" style="padding-right: 30px;">
        <a href="#!" class="modal-close green waves-effect waves-light btn"><i class="material-icons left">keyboard_return</i>Return</a>
      </div>
    </form>
  </div>

  <div id="deleteModal" class="modal bottom-sheet">
    <form method="POST" action="{{route('visit.delete')}}">
      {{-- <form> --}}
        @csrf
        <div class="modal-content">
            <h4>Delete Sales Visit Details</h4><br><br>
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
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['map_apikey']}}&libraries=places&v=3.exp" async defer></script>
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

    function viewMap(id)
    {
        $('.tabs').tabs('select','view-forecast');
        $.get('visit/'+id, function(response){
            var data = response.data;
            // console.log(data);

            var lat = data.loc_latitude;
            var lng = data.loc_longhitude;
            initMaps(lat, lng);
            $('#viewModal').modal('open');
            
        });
    }

    function deleteItem(id)
    {
        $('#del_id').val(id);
        $('#deleteModal').modal('open');
    }

    function initMaps(lat, lng) {
        var map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: lat, lng: lng },
          zoom: 16,
        });

        let MarkerArray = [ 
            {location:{lat: lat, lng: lng}, 
            imageIcon: "https://img.icons8.com/doodle/48/000000/user-location.png", 
            content: '<h6>Current location</h6>'}
        ];

        for (let i = 0; i < MarkerArray.length; i++){
          addMarker(MarkerArray[i]);
        };

      function addMarker(property)
        {
            const marker = new google.maps.Marker({
            position:property.location,
            map:map,
            });
          
            if(property.imageIcon){
                marker.setIcon(property.imageIcon)
            }

            if(property.content)
            {
            const detailWindow = new google.maps.InfoWindow({
            content: property.content
            });

            marker.addListener("mouseover", () =>{
                detailWindow.open(map, marker);
            });
            }
         }
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
            {  "data": "complete_address" },
         
            {
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return  '<a href="#" class="btn-small blue waves-effect waves-light" onclick="viewMap('+row.id+')"><i class="material-icons">location_on</i></a> <a href="visit/'+row.id+'/edit" class="btn-small amber darken3 waves-effect waves-dark"><i class="material-icons">create</i></a>  <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
                }
            }
        ]
    });

  </script>

  <!-- End of SCRIPTS -->

@endsection
