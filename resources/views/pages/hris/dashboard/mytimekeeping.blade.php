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
                <li class="nav-item">
                    <a class="nav-link" id="ob-tab" data-toggle="tab" href="#ob" role="tab" aria-controls="ob" aria-selected="true">Official Business</a>
                </li>
            @if(Auth::user()->is_lv_approver)
                <li class="nav-item">
                    <a class="nav-link" id="obapproval-tab" data-toggle="tab" href="#obapproval" role="tab" aria-controls="obapproval" aria-selected="true">Official Business Approval</a>
                </li>
            @endif
                <li class="nav-item">
                    <a class="nav-link" id="cs-tab" data-toggle="tab" href="#cs" role="tab" aria-controls="cs" aria-selected="true">Change Shift</a>
                </li>
            @if(Auth::user()->is_cs_approver)
                <li class="nav-item">
                    <a class="nav-link" id="csapproval-tab" data-toggle="tab" href="#csapproval" role="tab" aria-controls="csapproval" aria-selected="true">Change Shift Approval</a>
                </li>
            @endif
                <li class="nav-item">
                    <a class="nav-link" id="ot-tab" data-toggle="tab" href="#ot" role="tab" aria-controls="ot" aria-selected="true">Overtime</a>
                </li>
            @if(Auth::user()->is_ot_approver)
                <li class="nav-item">
                    <a class="nav-link" id="otapproval-tab" data-toggle="tab" href="#otapproval " role="tab" aria-controls="csapproval" aria-selected="true">Overtime Approval</a>
                </li>
            @endif
            </ul>
            <div class="tab-content border border-top-0" id="myTabContent">
                <!--Leave-->
                <div class="tab-pane fade show active" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                    <div class="container-fluid pt-3 mb-3">
                        @if(strtotime(date('H:i:s')) <= strtotime('15:00:00'))
                        <a href="{{ route('leave.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Leave</a>
                        @endif
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
                <!--OB-->
                <div class="tab-pane fade" id="ob" role="tabpanel" aria-labelledby="ob-tab">
                    <div class="container-fluid pt-3 mb-3">
                        @if(strtotime(date('H:i:00'))<=strtotime(date('15:00:00')))
                        <a href="{{ route('ob.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Official Business</a>
                        @endif
                        <table id="myob-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Purpose</th>
                                    <th>Destination</th>
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
                <!--End of OB-->
                <!--OB Approval-->
                <div class="tab-pane fade" id="obapproval" role="tabpanel" aria-labelledby="obapproval-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="obapproval-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Requestor</th>
                                    <th>Purpose</th>
                                    <th>Destination</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of OB Approval-->
                <!--CS-->
                <div class="tab-pane fade" id="cs" role="tabpanel" aria-labelledby="cs-tab">
                    <div class="container-fluid pt-3 mb-3">
                        @if(strtotime(date('H:i:00'))<=strtotime(date('15:00:00')))
                        <a href="{{ route('cs.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Change Shift</a>
                        @endif
                        <table id="mycs-dt" class="table table-striped table-bordered" style="width:100%;">
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
                <!--End of CS-->
                <!--CS Approval-->
                <div class="tab-pane fade" id="csapproval" role="tabpanel" aria-labelledby="csapproval-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="csapproval-dt" class="table table-striped table-bordered" style="width:100%;">
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
                <!--End of CS Approval-->
                <!--OT-->
                <div class="tab-pane fade" id="ot" role="tabpanel" aria-labelledby="ot-tab">
                    <div class="container-fluid pt-3 mb-3">
                        @if(strtotime(date('H:i:00'))<=strtotime(date('15:00:00')))
                        <a href="{{ route('ot.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> File Overtime</a>
                        @endif
                        <table id="myot-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
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
                <!--End of OT-->
                <!--OT Approval-->
                <div class="tab-pane fade" id="otapproval" role="tabpanel" aria-labelledby="otapproval-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="otapproval-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Requestor</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of OT Approval-->
            </div>
        </div>
    </div>
@stop

