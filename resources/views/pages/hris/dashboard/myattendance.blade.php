@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">My Attendance</h3>
            <hr>
            <p class="card-text">This module provides data of your attendance.</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="container-fluid pt-3 mb-3">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <h1 class="p-3 mb-4 border-bottom"><i class="fas fa-calendar-day mr-3"></i> Today, {{date('M d, Y')}}</h1>
                        <h2 class="p-3 border bg-success text-white"><i class="fas fa-sign-in-alt"></i> Time In:<span class="float-right" id="time-in"></span></h2>
                        <h2 class="p-3 border bg-danger text-white"><i class="fas fa-sign-out-alt"></i> Time Out:<span class="float-right" id="time-out"></span></h2>
                    </div>
                    <div class="col-md-8">
                        <table id="my-attendance-td" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Hours Work</th>
                                    <th>Late</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

