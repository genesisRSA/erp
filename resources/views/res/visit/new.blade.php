@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Sales Visit<i class="material-icons">arrow_forward_ios</i></span>New Visit</h4>
    </div>
  </div>
  <div class="d-flex flex-row">
    <div class="m-3 main-content">  
      <div class="row">
        <div class="card mb-3 col s12 m3 l3">
          <div class="card-body" style="height: 789px">
            <form method="POST" action="{{route('visit.store')}}">
              @csrf
              <h6 style="padding: 10px; padding-top: 10px; padding-left: 10px; padding-right: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Visit Details</b></h6> <hr style="margin: 0px">
              <div class="row">
                <br>
                <input type="hidden" name="lat" id="curr_lat">
                <input type="hidden" name="long" id="curr_long">
                
                <div class="input-field col s12 m12 l12">
                  <input type="text" id="add_visit_code" name="visit_code" value="{{$visit}}" readonly/>
                  <label for="visit_code">Visit Code<sup class="red-text"></sup></label>
                </div>
                
                <div class="input-field col s12 m12 l12">
                  <select id="add_site_code" name="site_code" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($sites as $site)
                      <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                    @endforeach
                  </select>
                  <label for="site_code">Site<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <textarea id="add_loc_name" name="loc_name" class="materialize-textarea" placeholder="Amkor P3/P4" required/></textarea>
                  <label for="loc_name">Location<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <textarea id="add_visit_purpose" name="visit_purpose" class="materialize-textarea"  placeholder="On-site Visit" required></textarea>
                  <label for="visit_purpose">Purpose<sup class="red-text">*</sup></label>
                </div>

              </div>
              <br>
              
              <div class="row col s12 m12 l12" style="padding-right: 0px">
                <div class="col s12 m3 l3"></div>
                <div class="col s12 m9 l9 right-align" style="padding-right: 0px">
                <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <button class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</button>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="card mb-3 col s12 m9 l9">
          <div class="card-body">
            <div id="map"></div> 
          </div>
        </div>
      </div>  
    </div>
  </div>
  <!-- SCRIPTS -->
  {{-- AIzaSyB_d6VrUMGRuMiQcBEfqwOvhrlJv86AyOA --}}
  {{-- <script type="text/javascript" src="{{ asset('js/googlemap.js') }}"></script> --}}
  {{-- <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script>  --}}
  {{-- <script src=https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js></script> --}}
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['map_apikey']}}&libraries=places&v=3.exp" async defer></script>

  {{-- callback=initMaps& --}}
  <script type="text/javascript">

    var searchInput = 'add_loc_name';

    $(document).ready(function () {
      geoLocationInit();

      var autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
      });
        
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
      });

    });

      function geoLocationInit() {
        if(navigator.geolocation){
          navigator.geolocation.getCurrentPosition(success, fail);
        } else {
          alert ("Browser not supported");
        }
      }

      // activate GeoCoding API
      function success(position){
        console.log(position);
        var infoWindow = new google.maps.InfoWindow;
        console.log(infoWindow);
        var latval = position.coords.latitude;
        var lngval = position.coords.longitude;

        $('#curr_lat').val(latval);
        $('#curr_long').val(lngval);

        $.ajax({
          url:'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latval+','+lngval+'&key=AIzaSyB_d6VrUMGRuMiQcBEfqwOvhrlJv86AyOA',
          success:function(data){
            console.log(data);
            $('#add_loc_name').val(data.results[0].formatted_address);
          }
        })
        initMaps(latval, lngval);
      }


      function fail(){
        alert('Unable to get current position');
      }

      function initMaps(lat, lng) {
        var map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: lat, lng: lng },
          zoom: 16,
        });

        google.maps.event.addListener(map, "click", (event) => {
            addMarker({location:event.latLng});
        });

        
        let MarkerArray = [ 
            {location:{lat: lat, lng: lng}, 
            // imageIcon: "https://img.icons8.com/nolan/2x/marker.png", 
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
         };
      }  

    // var visits = $('#visit-dt').DataTable({
    //     "lengthChange": false,
    //     "pageLength": 15,
    //     "aaSorting": [[ 0, "asc"],[ 2, "desc"]],
    //     "pagingType": "full",
    //     "ajax": "/api/reiss/visit/all",
    //     "columns": [
    //         {  "data": "id" },
    //         {   "data": "id",
    //             "render": function ( data, type, row, meta ) {
    //               return row.sites.site_desc;
    //             }
    //         },
    //         {  "data": "visit_code" },
    //         {  "data": "loc_name" },
    //         {
    //             "data": "id",
    //             "render": function ( data, type, row, meta ) {
    //                 return  '<a href="#" class="btn-small amber darken3 waves-effect waves-dark" onclick="editItem('+row.id+')"><i class="material-icons">create</i></a> <a href="#" class="btn-small red waves-effect waves-light" onclick="deleteItem('+row.id+')"><i class="material-icons">delete</i></a>';
    //             }
    //         }
    //     ]
    // });
 


  </script>

  <!-- End of SCRIPTS -->

@endsection
