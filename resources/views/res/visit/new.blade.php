@extends('layouts.resmain')

@section('content')
  <div class="row blue-text text-darken-4 white" style="border-bottom: 1px solid rgba(0,0,0,0.14);">
    <div class="col s12 m12">
        <h4 class="title"><span class="grey-text darken-4">Sales<i class="material-icons">arrow_forward_ios</i></span><span class="grey-text darken-4">Sales Visit<i class="material-icons">arrow_forward_ios</i></span>New Visit</h4>
    </div>
  </div>
  <div class="card">  
    <div class="card-content">
    

      <div id="map">

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
