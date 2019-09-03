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
            <p class="card-text">Welcome to our HRIS! The Human Resource Information System (HRIS) is a software or online solution for the data entry, data tracking, and data information needs of the Human Resources, payroll, management, and accounting functions within a business.</p>
          </div>
    </div>
    @if(Auth::user()->is_admin || Auth::user()->is_hr)
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-3">
                <h5 class="card-header bg-primary text-white"><i class="fas fa-calendar-day"></i> Today is {{date('D m/d/Y')}}</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <h5 class="card-header bg-success text-white"><i class="far fa-thumbs-up"></i> Top 5 Early Birds of the Week</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                 <h5 class="card-header bg-warning"><i class="far fa-thumbs-down"></i> Top 5 Late Comers of the Week</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <h5 class="card-header bg-dark text-white"><i class="fas fa-info-circle"></i> Notification Area</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                    <h5 class="card-header bg-danger text-white"><i class="fas fa-exclamation-circle"></i> Top 5 Absenteeism of the Week</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

