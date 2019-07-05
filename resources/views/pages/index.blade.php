<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name', 'HRIS')}}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-primary">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 bg-white border-right text-center">
                    <img class="img-fluid h-100 w-100" src="{{url('/images/banner.png')}}" alt="Banner">
                </div>
                <div class="col-lg-4 bg-primary">
                    <div class="row h-100">
                        <div class="col-12 align-self-center">
                            <div class="form-group mt-3">
                                <h2 class="text-center text-white">Welcome to {{config('app.name', 'HRIS')}}</h2>
                                <hr style="width:40%;background-color:#fff;">
                                <input type="text" class="form-control mt-5 mb-3" placeholder="Username">
                                <input type="password" class="form-control mb-4" placeholder="Password">
                                <button class="btn btn-success mb-5 w-100">Sign In</button>
                                <h6 class="text-white text-center">&copy;   Copyright 2019 RGC</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>
