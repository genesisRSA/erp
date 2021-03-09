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
                    <div class="col-md-3 border-right">
                        <div class="d-none d-sm-block">
                            <h3 class="p-3 mb-4 border-bottom"><i class="fas fa-calendar-day mr-3"></i> Today, {{date('M d, Y')}}</h1>
                            <h5 class="p-3 border bg-success text-white"><i class="fas fa-sign-in-alt"></i> Time In:<span class="float-right" id="time-in"></span></h2>
                            <h5 class="p-3 border bg-danger text-white"><i class="fas fa-sign-out-alt"></i> Time Out:<span class="float-right" id="time-out"></span></h2>
                        </div>
                        <div class="d-xl-none">
                            <div class="d-sm-none">
                                <h3 class="p-3 mb-4 border-bottom"><i class="fas fa-calendar-day mr-3"></i> Today, {{date('M d, Y')}}</h3>
                                <h3 class="p-3 border bg-success text-white"><i class="fas fa-sign-in-alt"></i> <span class="float-right" id="time-in-mini"></span></h3>
                                <h3 class="p-3 border bg-danger text-white"><i class="fas fa-sign-out-alt"></i> <span class="float-right" id="time-out-mini"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="general" aria-selected="true">My Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="shift-tab" data-toggle="tab" href="#shift" role="tab" aria-controls="general" aria-selected="true">My Shift</a>
                            </li>
                        </ul>
                        <div class="tab-content border border-top-0" id="myTabContent">
                            <!--MY ATTENDANCE-->
                            <div class="tab-pane fade show active" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                                <div class="container-fluid mt-3">
                                    <table id="my-attendance-td" class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Shift Date</th>
                                                <th>Shift</th>
                                                <th>Shift In</th>
                                                <th>Shift Out</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                                <th>SL w/ Pay</th>
                                                <th>VL w/ Pay</th>
                                                <th>VL w/o Pay</th>
                                                <th>Late</th>
                                                <th>Rendered Hours Work</th>
                                                <th>Regular OT</th>
                                                <th>Sunday OT</th>
                                                <th>Legal OT</th>
                                                <th>Special OT</th>
                                                <th>Rendered OT</th>
                                                <th>Night Diff</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!--MY SHIFT-->
                            <div class="tab-pane fade" id="shift" role="tabpanel" aria-labelledby="shift-tab">
                                <div class="container-fluid mt-3">
                                    <table id="my-shift-td" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Date</th>
                                                <th>Shift</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

