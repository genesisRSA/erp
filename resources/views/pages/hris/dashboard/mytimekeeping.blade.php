@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">My Timekeeping</h3>
            <hr>
            <p class="card-text">This module provides information about Employees record.</p>
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
            @if(Auth::user()->is_lv_approver)
                <li class="nav-item">
                    <a class="nav-link" id="leaveapproval-tab" data-toggle="tab" href="#leaveapproval" role="tab" aria-controls="leaveapproval" aria-selected="true">Leave Approval</a>
                </li>
            @endif
               <!-- <li class="nav-item">
                    <a class="nav-link" id="overtime-tab" data-toggle="tab" href="#overtime" role="tab" aria-controls="overtime" aria-selected="false">Overtime</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="changeshift-tab" data-toggle="tab" href="#changeshift" role="tab" aria-controls="changeshift" aria-selected="false">Change Shift</a>
                </li>-->
            </ul>
            <div class="tab-content border border-top-0" id="myTabContent">
                <!--Leave-->
                <div class="tab-pane fade show active" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <a href="{{ route('leave.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Leave</a>
                        <table id="myleave-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Type</th>
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
                <div class="tab-pane fade" id="leaveposted" role="tabpanel" aria-labelledby="leaveposted-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="myleaveposted-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Type</th>
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
                <!--Leave Approval-->
                <div class="tab-pane fade" id="leaveapproval" role="tabpanel" aria-labelledby="leaveapproval-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="leaveapproval-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Type</th>
                                    <th>Requestor</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Leave Approval-->
                <!--Overtime-->
                <div class="tab-pane fade" id="overtime" role="tabpanel" aria-labelledby="overtime-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <a href="{{ route('leave.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Overtime</a>
                        <table id="overtime-dt" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Requestor</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th>Next Approver</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Overtime-->
                <!--Change Shift-->
                <div class="tab-pane fade" id="changeshift" role="tabpanel" aria-labelledby="changeshift-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <a href="{{ route('leave.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Change Shift</a>
                        <table id="leave-dt" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Filer</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th>Next Approver</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Change Shift-->
            </div>
        </div>
    </div>
@stop

