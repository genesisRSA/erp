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
        <h4 class="title"><span class="grey-text darken-4">Sales<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Sales Visit<i class="material-icons">arrow_forward_ios</i></span>View Visit</h4>
    </div>
  </div>
  <div class="d-flex flex-row">
    <div class="m-3 main-content">  
      <div class="row">
        <div class="card mb-3 col s12 m3 l3">
          <div class="card-body" style="height: 789px">
            {{-- <form method="POST" action="{{route('visit.patch')}}"> --}}
              <form>
              @csrf
              <h6 style="padding: 10px; padding-top: 10px; padding-left: 10px; padding-right: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Visit Details</b></h6> <hr style="margin: 0px">
              <div class="row">
                <br>
                <input type="hidden" name="view_lat" id="curr_lat" value="{{number_format($visits->loc_latitude, 10, '.', '')}}">
                <input  type="hidden" name="view_long" id="curr_long" value="{{number_format($visits->loc_longhitude, 10, '.', '')}}">
                
                <div class="input-field col s12 m12 l12">
                  <input type="text" id="view_visit_code" name="visit_code" value="{{$visits->visit_code}}" readonly/>
                  <label for="visit_code">Visit Code<sup class="red-text"></sup></label>
                </div>
                
                <div class="input-field col s12 m12 l12">
                  <select id="view_site_code" name="site_code" disabled>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($sites as $site)
                     @if($visits->site_code==$site->site_code)
                      <option value="{{$site->site_code}}" selected>{{$site->site_desc}}</option>
                     @endif
                    @endforeach
                  </select>
                  <label for="site_code">Site<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <textarea id="view_current_loc" name="current_loc" class="materialize-textarea" placeholder="Amkor P3/P4" readonly>{{$visits->current_location}}</textarea>
                  <label for="current_loc">Current Location<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <textarea id="view_complete_address" name="complete_address" class="materialize-textarea"  placeholder="PTC" readonly>{{$visits->complete_address}}</textarea>
                  <label for="complete_address">Complete Address<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <textarea id="view_visit_purpose" name="visit_purpose" class="materialize-textarea"  placeholder="On-site Visit" readonly>{{$visits->visit_purpose}}</textarea>
                  <label for="visit_purpose">Purpose<sup class="red-text">*</sup></label>
                </div>

              </div>
              <br>
              
 
                <div class="col s12 m12 l12 right-align" style="padding-right: 0px">
                
                <a href="{{route('visit.index')}}" class="green waves-effect waves-dark btn"><i class="material-icons left">keyboard_return</i>Return</a>
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

    var searchInput = 'view_complete_address';

    $(document).ready(function () {
     // geoLocationInit();

      var autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
      });
        
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
      });

      var latx = document.getElementById('curr_lat').value;
      var lngx = document.getElementById('curr_long').value ; 
      initMaps(latx,lngx);

    });


      function initMaps(lat, lng) {
 
        var map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: parseFloat(lat), lng: parseFloat(lng) },
          zoom: 16,
        });

        let MarkerArray = [ 
            {location:{lat: parseFloat(lat), lng: parseFloat(lng)}, 
            imageIcon: "https://img.icons8.com/doodle/48/000000/user-location.png", 
            content: '<h6>Visit Location</h6>'}
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
