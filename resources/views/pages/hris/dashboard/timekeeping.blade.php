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
                <li class="nav-item">
                    <a class="nav-link" id="shift-tab" data-toggle="tab" href="#shift" role="tab" aria-controls="shift" aria-selected="true">Shift</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ob-tab" data-toggle="tab" href="#ob" role="tab" aria-controls="ob" aria-selected="true">Official Business</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="obposted-tab" data-toggle="tab" href="#obposted" role="tab" aria-controls="obposted" aria-selected="true">Official Business Posted</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cs-tab" data-toggle="tab" href="#cs" role="tab" aria-controls="cs" aria-selected="true">Change Shift</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="csposted-tab" data-toggle="tab" href="#csposted" role="tab" aria-controls="csposted" aria-selected="true">Change Shift Posted</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ot-tab" data-toggle="tab" href="#ot" role="tab" aria-controls="ot" aria-selected="true">Overtime</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="otposted-tab" data-toggle="tab" href="#otposted" role="tab" aria-controls="otposted" aria-selected="true">Overtime Posted</a>
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
                <!--Shift-->
                <div class="tab-pane fade show" id="shift" role="tabpanel" aria-labelledby="shift-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <a href="{{ route('employeeshift.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Create Shift</a>
                        <table id="shift-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Employee</th>
                                    <th>Shift</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Shift-->
                <!--OB-->
                <div class="tab-pane fade" id="ob" role="tabpanel" aria-labelledby="ob-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="ob-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Filer</th>
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
                <!--OB Posted-->
                <div class="tab-pane fade" id="obposted" role="tabpanel" aria-labelledby="obposted-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="obposted-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Filer</th>
                                    <th>Purpose</th>
                                    <th>Destination</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of OB Posted-->
                <!--CS-->
                <div class="tab-pane fade" id="cs" role="tabpanel" aria-labelledby="cs-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="cs-dt" class="table table-striped table-bordered" style="width:100%;">
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
                <!--End of CS-->
                <!--CS Posted-->
                <div class="tab-pane fade" id="csposted" role="tabpanel" aria-labelledby="csposted-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="csposted-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Type</th>
                                    <th>Filer</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of CS Posted-->
                <!--Overtime-->
                <div class="tab-pane fade" id="ot" role="tabpanel" aria-labelledby="ot-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="ot-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
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
                <!--End of Overtime-->
                <!--Overtime Posted-->
                <div class="tab-pane fade" id="otposted" role="tabpanel" aria-labelledby="otposted-tab">
                    <div class="container-fluid pt-3 mb-3">
                        <table id="otposted-dt" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Filer</th>
                                    <th>Date Filed</th>
                                    <th>Status</th>
                                    <th>Last Approved By</th>
                                    <th>Last Approved</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End of Overtime Posted-->
            </div>
        </div>
    </div>
@stop

