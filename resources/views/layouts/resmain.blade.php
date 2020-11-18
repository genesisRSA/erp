<!DOCTYPE html>
  <html>
    <head>
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
            margin-left: 60px;
            padding-bottom: 30px;
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
          margin-left: 85px;
          margin-right: 85px;
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
            margin-left: 0;
            margin-right: 0;
          }
        }
        
      </style> 
    </head>
    <body>
      
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
          $('.sidenav').sidenav();
          $('.collapsible').collapsible();
          $('.tap-target').tapTarget();
          $('.tooltipped').tooltip();
          //$('.tap-target').tapTarget('open');
        });

      </script>
      <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    </body>
  </html>
        