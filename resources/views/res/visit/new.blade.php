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
        <div class="card mb-3 col s12 m4 l4">
          <div class="card-body" style="height: 789px">
            <form method="POST" action="" enctype="multipart/form-data">
              <h6 style="padding: 10px; padding-top: 10px; padding-left: 10px; padding-right: 10px; margin-bottom: 0em; background-color:#0d47a1" class="white-text"><b>Visit Details</b></h6> <hr style="margin: 0px">
              <div class="row">
                <br>
                
                <div class="input-field col s12 m12 l12">
                  <input type="text" id="add_visit_code" name="visit_code" value="VISIT20210315" readonly/>
                  <label for="visit_code">Visit Code<sup class="red-text"></sup></label>
                </div>
                
                <div class="input-field col s12 m12 l12">
                  <select id="add_site_code" name="visit_site" required>
                    <option value="" disabled selected>Choose your option</option>
                    @foreach ($sites as $site)
                      <option value="{{$site->site_code}}">{{$site->site_desc}}</option>
                    @endforeach
                  </select>
                  <label for="visit_site">Site<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
                  <input type="text" id="add_visit_loc" name="visit_loc" value="" placeholder="Amkor P3/P4" required/>
                  <label for="visit_loc">Location<sup class="red-text">*</sup></label>
                </div>

                <div class="input-field col s12 m12 l12">
   
                  <textarea placeholder="On-site Visit" name="visit_purpose" class="materialize-textarea" required></textarea>
                  <label for="visit_purpose">Purpose<sup class="red-text">*</sup></label>
                </div>


              </div>

              <br>
              
              

              <div class="row col s12 m12 l12" style="padding-right: 0px">
                <div class="col s12 m3 l3"></div>
                <div class="col s12 m9 l9 right-align" style="padding-right: 0px">
                <button class="green waves-effect waves-light btn"><i class="material-icons left">check_circle</i>Save</button>
                <button class="red waves-effect waves-dark btn"><i class="material-icons left">cancel</i>Cancel</button>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="card mb-3 col s12 m8 l8">
          <div class="card-body">
            <div id="map"></div> 
          </div>
        </div>
      </div>  
    </div>
  </div>
  <!-- SCRIPTS -->
  {{-- AIzaSyB_d6VrUMGRuMiQcBEfqwOvhrlJv86AyOA --}}
  <script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['map_apikey']}}&callback=initMaps" async defer></script>

  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  {{-- <script type="text/javascript" src="{{ asset('js/googlemap.js') }}"></script> --}}
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.js"></script> 
  <script type="text/javascript" src="{{ asset('datatables/datatables.js') }}"></script>
  <script type="text/javascript">

//    let map;

    function initMaps() {
      var map = new google.maps.Map(document.getElementById("map"), {
        // 14.274014, 121.052879
        //  14.318953, 121.059537
        center: { lat: 14.274014, lng: 121.052879 },
        zoom: 16,
      });
    }

    $(document).ready(function () {
      geoLocationInit();
      function geoLocationInit() {
        if(navigator.geolocation){
          navigator.geolocation.getCurrentPosition(success, fail);
        } else {
          alert ("Browser not supported");
        }
      }

      function success(position){
        console.log(position);
        var infoWindow = new google.maps.InfoWindow;
        console.log(infoWindow);
        var latval = position.coords.latitude;
        var lngval = position.coords.longitude;
      }

      function fail(){
        alert('Unable to get current position');
      }

      // var map = new google.maps.Map(document.getElementById('map'))
      // {
      //   // center: {lat: -34.387, lng: 150.644},
      //   // scrollwheel: false,
      //   // zoom: 8 
      // }
    });

  

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
