@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">Attendance</h3>
            <hr>
            <p class="card-text">This module provides data for each employee's attendance.</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="raw-tab" data-toggle="tab" href="#raw" role="tab" aria-controls="general" aria-selected="true">Raw Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="calculated-tab" data-toggle="tab" href="#calculated" role="tab" aria-controls="calculated" aria-selected="false">Calculated Attendance</a>
                </li>
            </ul>
            <div class="tab-content border border-top-0" id="myTabContent">
                <!--RAW ATTENDANCE-->
                <div class="tab-pane fade show active" id="raw" role="tabpanel" aria-labelledby="raw-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label>Site</label>
                                <select id="psite_code" class="form-control">
                                    <option value="RTI" selected>Richetec Inc.</option>
                                    <option value="RSA">RTI System Automation Inc.</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Date From</label>
                                <input type="date" id="date_from" value="{{date('d')>=9&&date('d')<=23?date('Y-m-09'):date('Y-m-24',strtotime( '-1 month', strtotime( date('Y-m-d') ) ))}}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Date To</label><br>
                                <div class="btn-group">
                                    <input type="date" id="date_to" value="{{date('d')>=9&&date('d')<=23?date('Y-m-23'):date('Y-m-08')}}" class="form-control">
                                    <button type="button" id="run_attendance" class="btn btn-success">View</button>
                                </div>
                                <button class="btn btn-warning" id="alteration"><i class="fas fa-upload"></i> Punch Alteration</button>
                            </div>
                        </div>
                        <table id="attendance-dt" class="table table-striped table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID No.</th>
                                    <th>Employee Name</th>
                                    <th>Shift</th>
                                    <th>Shift Date</th>
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
                            <tfoot>
                                <tr>
                                    <th>ID No.</th>
                                    <th>Employee Name</th>
                                    <th>Shift</th>
                                    <th>Shift Date</th>
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
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!--END OF RAW ATTENDANCE-->
                <!--CALCULATED ATTENDANCE-->
                <div class="tab-pane fade" id="calculated" role="tabpanel" aria-labelledby="calculated-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label>Site</label>
                                <select id="calcpsite_code" class="form-control">
                                    <option value="RTI" selected>Richetec Inc.</option>
                                    <option value="RSA">RTI System Automation Inc.</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Date From</label>
                                <input type="date" id="calcdate_from" value="{{date('d')>=9&&date('d')<=23?date('Y-m-09'):date('Y-m-24',strtotime( '-1 month', strtotime( date('Y-m-d') ) ))}}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Date To</label><br>
                                <div class="btn-group">
                                    <input type="date" id="calcdate_to" value="{{date('d')>=9&&date('d')<=23?date('Y-m-23'):date('Y-m-08')}}" class="form-control">
                                    <button type="button" id="run_calcattendance" class="btn btn-success">View</button>
                                </div>
                            </div>
                        </div>
                        <table id="calcattendance-dt" class="table table-striped table-bordered w-100">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Employee Name</th>
                                    <th>SL w/ Pay</th>
                                    <th>SL w/o Pay</th>
                                    <th>VL w/ Pay</th>
                                    <th>VL w/o Pay</th>
                                    <th>Days Worked</th>
                                    <th>Total Paid Days</th>
                                    <th>Requred Days</th>
                                    <th>Late in Minutes</th>
                                    <th>Regular OT</th>
                                    <th>Sunday OT</th>
                                    <th>Regular Holiday OT</th>
                                    <th>Special Holiday OT</th>
                                    <th>Night Differential</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>SL w/ Pay</th>
                                    <th>SL w/o Pay</th>
                                    <th>VL w/ Pay</th>
                                    <th>VL w/o Pay</th>
                                    <th>Days Worked</th>
                                    <th>Total Paid Days</th>
                                    <th>Requred Days</th>
                                    <th>Late in Minutes</th>
                                    <th>Regular OT</th>
                                    <th>Sunday OT</th>
                                    <th>Regular Holiday OT</th>
                                    <th>Special Holiday OT</th>
                                    <th>Night Differential</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@stop

