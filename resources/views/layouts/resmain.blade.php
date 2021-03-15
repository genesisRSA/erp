<!DOCTYPE html>
  <html>
    <head>
      <script src="http://code.jquery.com/jquery-3.4.1.js"></script>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen,projection"/>
      <title>RGC Enterprise System</title>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <style>
        header, main, footer {
          padding-left: 300px;
        }

        .title{
            margin-left: 30px;
        }

        .sidenav li.active{
            background-color: #0d47a1;
        }

        .sidenav li.active a{
            color:#ffffff;
        }

        .sidenav li.active>a>i.material-icons{
            color: #ffffff;
        }

        .sidenav li.active ul > li > a{
            color:rgba(0,0,0,0.87);
        }

        .sidenav .collapsible-body>ul:not(.collapsible)>li.active, .sidenav.sidenav-fixed .collapsible-body>ul:not(.collapsible)>li.active {
            background-color: #c5cae9;
        }

        .sidenav .collapsible-body>ul:not(.collapsible)>li.active a, .sidenav.sidenav-fixed .collapsible-body>ul:not(.collapsible)>li.active a {
            color:rgba(0,0,0,0.87);
        }

        .sidenav .collapsible-body li a, .sidenav.fixed .collapsible-body li a {
          padding-left: 85px;
        }

        .sidenav li.active ul > li > a{
          padding-left: 85px;
        }

        .main-content{
          padding-left: 30px;
          padding-right: 30px;
        }

        /* width */
        .sidenav::-webkit-scrollbar {
          width: 3px;
        }

        /* Track */
        .sidenav::-webkit-scrollbar-track {
          background: #eeeeee; 
        }
        
        /* Handle */
        .sidenav::-webkit-scrollbar-thumb {
          background: #888; 
        }

        /* Handle on hover */
        .sidenav::-webkit-scrollbar-thumb:hover {
          background: #555; 
        }

        .add-button{
          position: fixed;
          bottom: 5%;
          right: 2%;
        }

        .tabs .tab a {
          color: black;
        }
        .tabs .tab a.active {
          color: black;
        }
        .tabs .tab a:hover {
          color: black;
        }
        .tabs .tab a:focus {
          background-color: rgba(66, 74, 66, 0);
        }
        .tabs .tab a:focus.active {
          background-color: rgba(66, 74, 66, 0);
        }
        .tabs .indicator {
          background-color: blue;
        }

        input[type=checkbox]{
           /* Double-sized Checkboxes */
          -ms-transform: scale(1); /* IE */
          -moz-transform: scale(1); /* FF */
          -webkit-transform: scale(1); /* Safari and Chrome */
          -o-transform: scale(1); /* Opera */
          transform: scale(1);
          padding: 1px;
        }

        .dataTables_wrapper .dataTables_filter{
            float: right;
        }
        .dataTables_wrapper .dataTables_length{
            float: left;
        }

        th,td { font-size: 12px; padding: 2px;}

        @media only screen and (max-width : 992px) {
          header, main, footer {
            padding-left: 0;
          }
          .title{
            text-align: center;
            font-size: 1.5em;
            margin-left: 0;
            padding-bottom: 10px;
          }
          .main-content{
            padding-left: 15px;
            padding-right: 15px;
          }

          .sidenav-trigger{
            position: absolute;
            top: 25px;
            left: 25px;
          }
        }

        #map{
          height: 800px;
          width: 100%;
          margin: 0 auto;
        }
        .marker {
            background-image: url('/images/marker.png');
            background-repeat:no-repeat;
            background-size:100%;
            width: 100px;
            height: 100px;
            cursor: pointer; 
        }
        
      </style> 
    </head>
    <body class="blue darken-4">
      
      @include('includes.res.sidebar', ['page' => $page])
      <main>
            @yield('content')
      </main>

      <div class="tap-target" data-target="add-button">
        <div class="tap-target-content">
          <h5>Add</h5>
          <p>A bunch of text</p>
        </div>
      </div>
      <script src="{{ asset('js/app.js') }}"></script>
      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript">
        $(document).ready(function(){
          M.AutoInit();
          $('.modal').modal({
            "dismissible":false
          });

          @if ($message = Session::get('success'))
              var html = '<i class="material-icons left">info</i><span>{{$message}}</span>';
              M.toast({html: html+'<button class="btn-flat red-text toast-action" onclick="M.Toast.dismissAll()">DISMISS</button>'});
          @endif

          @if ($message = Session::get('errors'))
              var html = '<i class="material-icons left">info</i><span>{{$message}}</span>';
              M.toast({html: html+'<button class="btn-flat red-text toast-action" onclick="M.Toast.dismissAll()">DISMISS</button>'});
          @endif
          //$('.tap-target').tapTarget('open');
        });

      </script>
      <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    </body>
  </html>
        