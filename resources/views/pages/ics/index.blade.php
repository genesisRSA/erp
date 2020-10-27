<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ICS</title>

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
                <img class="img-fluid my-auto mx-auto" src="{{url('/images/dcs-banner.png')}}" alt="Banner" style="max-height:600px;">
                <div class="row bg-teal align-self-stretch" style="min-width:30%;">
                    <div class="col-12 align-self-center">
                        <div class="form-group mt-3">
                            <div class="container">
                                <form method="POST" action="{{ route('ics.login') }}">
                                    @csrf
                                    @csrf
                                    <h2 class="text-center text-white">
                                        <img src="{{url('/images/rgclogo.png')}}" alt="Logo" style="max-height:70px;"><br>Welcome to Information Control<br> System
                                    </h2>
                                    <hr style="width:40%;background-color:#fff;">
                                    <div class="form-group row">
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            </div>
                                            <input type="text" name="email" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Username or Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <button type="submit" class="btn btn-success mb-5 w-100">{{ __('Login') }}</button>
                                    </div>
                                </form>
                            </div>
                            <h6 class="text-white text-center">&copy;   Copyright 2019 RGC</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    @if(!$errors->isEmpty())
        $(document).ready(function (){
            $('#errorModal').modal('show');
        });
    @endif
</script>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" role="alert">
                Please see below list of errors : 
                <ul class="mt-3">
                    @foreach ($errors->all() as $message) 
                        <li>{{$message}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
</div>
</html>
