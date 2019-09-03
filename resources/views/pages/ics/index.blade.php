<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AIMS</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .bg-teal{
                background-color: #2b8ba3;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="d-flex flex-sm-row flex-md-column flex-lg-row flex-column" style="min-height:100vh;">
                <img class="img-fluid mx-auto" src="{{url('/images/ais-banner.png')}}" alt="Banner">
                <div class="row bg-teal align-self-stretch" style="min-width:30%;">
                    <div class="col-12 align-self-center">
                        <div class="form-group mt-3">
                            <div class="container">
                                <h2 class="text-center text-white">Welcome to Inventory Control<br>Management System</h2>
                                <hr style="width:40%;background-color:#fff;">
                                <input type="text" class="form-control mt-5 mb-3" placeholder="Username">
                                <input type="password" class="form-control mb-4" placeholder="Password">
                                <button class="btn btn-warning mb-5 w-100">Sign In</button>
                            </div>
                            <h6 class="text-white text-center">&copy;   Copyright 2019 RGC</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>
