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
                        <table id="attendance-dt" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--END OF RAW ATTENDANCE-->
                <!--CALCULATED ATTENDANCE-->
                <div class="tab-pane fade" id="calculated" role="tabpanel" aria-labelledby="calculated-tab">
                    <div class="container-fluid pt-3 mb-3">
                    </div>
                </div>
                <!--END OF CALCULATED ATTENDANCE-->
            </div>



        </div>
    </div>
@stop

