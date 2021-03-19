@extends('layouts.resmain')
<style>
   .center {
          display: block;
          padding-top: 100px;
          margin-left: auto;
          margin-right: auto;
          width: 50%;
          height: 50%;
        }
</style>

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
                  <input type="text" id="add_visit_code" name="visit_code" value="{{$visit}}" class="grey lighten-4" readonly/>
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
                  <textarea id="add_current_loc" name="current_loc" class="materialize-textarea grey lighten-4" placeholder="Amkor P3/P4" required readonly></textarea>
                  <label for="current_loc">Current Location<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <textarea id="add_complete_address" name="complete_address" class="materialize-textarea"  placeholder="PTC" required></textarea>
                  <label for="complete_address">Complete Address<sup class="red-text">*</sup></label>
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
                <a href="{{route('visit.index')}}" class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</a>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="card mb-3 col s12 m9 l9">
          <div class="card-body">
            <div id="map"></div>
            <div id="notice" style="height: 800px; display:none">
              <img src="{{ asset('images/location_unavailable_2.png') }}" class="center" >

              <p id="message" class="center"></p>
            </div> 
          </div>
        </div>
      </div>  
    </div>
  </div>
  <!-- SCRIPTS -->
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['map_apikey']}}&libraries=places&v=3.exp" async defer></script>
  <script type="text/javascript">

    var searchInput = 'add_complete_address';

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
          alert ("Geolocation is not supported by this browser.");
        }
      }

      // activate GeoCoding API
      function success(position){

        var notice = document.getElementById("notice");
        var map = document.getElementById("map");
        notice.style.display = "none";
        map.style.display = "block";

        var infoWindow = new google.maps.InfoWindow;
        var latval = position.coords.latitude;
        var lngval = position.coords.longitude;

 

        $('#curr_lat').val(latval);
        $('#curr_long').val(lngval);

        $.ajax({
          url:'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latval+','+lngval+'&key=AIzaSyB_d6VrUMGRuMiQcBEfqwOvhrlJv86AyOA',
          success:function(data){
            $('#add_current_loc').val(data.results[0].formatted_address);
            M.textareaAutoResize($('#add_current_loc'));
          }
        })
        initMaps(latval, lngval);
        
      }

      function fail(error){
        var notice = document.getElementById("notice");
        var mess = document.getElementById("message");
        var map = document.getElementById("map");
        notice.style.display = "block";
        map.style.display = "none";

        switch(error.code) {
          case error.PERMISSION_DENIED:
          mess.innerHTML = "User denied the request for Geolocation. Please allow this browser to access your current location by clicking the location icon on the upper right portion of the browser, and click <i>allways allow</i>. Refresh this page by pressing CTRL + F5."
            break;
          case error.POSITION_UNAVAILABLE:
          mess.innerHTML = "Location information is unavailable."
            break;
          case error.TIMEOUT:
          mess.innerHTML = "The request to get user location timed out."
            break;
          case error.UNKNOWN_ERROR:
          mess.innerHTML = "An unknown error occurred."
            break;
        }
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

  </script>

  <!-- End of SCRIPTS -->

@endsection
