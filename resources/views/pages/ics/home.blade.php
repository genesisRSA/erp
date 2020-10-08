@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <img class="img-fluid mr-3" src="{{url('/images/group.png')}}" />
            <span class="lead">
                @if(date('a')=='am')
                    Good Morning
                @else
                    Good Afternoon
                @endif
                
                {{Auth::user()->name}}!
            </span>
            <hr>
            <p class="card-text">Welcome to our Information Control System!</p>
          </div>
    </div>
@stop

