@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">Timekeeping</h3>
            <hr>
            <p class="card-text">This module provides information about Change Shift, Leaves and OTs.</p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>Success,</strong> {{$message}}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="leave-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="true">Leave</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="leaveposted-tab" data-toggle="tab" href="#leaveposted" role="tab" aria-controls="leaveposted" aria-selected="true">Leave Posted</a>
                </li>
            </ul>
            <div class="tab-content border border-top-0" id="myTabContent">
                <!--Leave-->
                <div class="tab-pane fade show active" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="leave-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Type</th>
                                    <th>Filer</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th>Current Approver</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Leave-->
                <!--Leave Posted-->
                <div class="tab-pane fade show" id="leaveposted" role="tabpanel" aria-labelledby="leaveposted-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="leaveposted-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Type</th>
                                    <th>Filer</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th>Current Approver</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Leave Posted-->
            </div>
        </div>
    </div>
@stop

