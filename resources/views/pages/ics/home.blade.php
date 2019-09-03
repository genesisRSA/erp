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
                
                User!
            </span>
            <hr>
            <p class="card-text">Welcome to our Asset Inventory System! Asset Inventory Management System enables a company to maintain a centralized record of every asset and item in the control of the organization, providing a single source of truth for the location of every item, vendor and supplier information, specifications, and the total number of a particular item currently in stock.</p>
          </div>
    </div>
@stop

