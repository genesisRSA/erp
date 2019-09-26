@extends('layouts.main')

@section('title',ucwords($page))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h3><a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left"></i></a> Leave : {{$leave->ref_no}}</h3>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error,</strong> Please see fields with <i class="fas fa-times"></i> mark on it.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('leave.update', $leave->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="leave-tab" data-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="true">Leave Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Approval History</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0" id="myTabContent">
                    <!--Leave Information-->
                    <div class="tab-pane fade show active" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                        <div class="container-fluid">
                            <div class="row pt-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Leave Type</label>
                                        <input type="text" class="form-control" value="{{$leave->type}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date From</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="leave_from" id="leave_from" value="{{$leave->leave_from}}"  readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date To</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="leave_to" id="leave_to" value="{{$leave->leave_to}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Range Option</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_one_day" class="custom-control-input" id="" {{$leave->leave_from == $leave->leave_to ? 'checked' : ''}} readonly>
                                        <label class="custom-control-label" for="is_one_day">Is One Day ?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Details</label>
                                        <textarea class="form-control" name="details" id="details" rows="3" placeholder="Leave Details" readonly>{{$leave->details}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Requestor</label><br>
                                        <a href="/{{$leave->filer_employee->emp_photo}}" target="_blank"><img src="/{{$leave->filer_employee->emp_photo}}" class="img-fluid rounded-circle bg-white border" style="height:48px;"/></a> <span class="badge badge-secondary">{{$leave->filer_employee->full_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Filed</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{$leave->date_filed}}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label><br>
                                        @if($leave->status == 'Approved')
                                            <button type="button" class="btn btn-success" style="width:100%;"><i class="fas fa-check-circle"></i>  {{$leave->status}}</button>
                                        @elseif($leave->status == 'Declined')
                                            <button type="button" class="btn btn-danger" style="width:100%;"><i class="fas fa-times-circle"></i> {{$leave->status}}</button>
                                        @elseif($leave->status == 'Posted')
                                            <button type="button" class="btn btn-secondary" style="width:100%;"><i class="fas fa-vote-yea"></i> {{$leave->status}}</button>
                                        @else
                                            <button type="button" class="btn btn-warning" style="width:100%;"><i class="fas fa-hourglass-half"></i>  {{$leave->status}}</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Current Approver</label><br>
                                        @if($leave->approver_employee)
                                            <a href="/{{$leave->approver_employee->emp_photo}}" target="_blank"><img src="/{{$leave->approver_employee->emp_photo}}" class="img-fluid rounded-circle bg-white border" style="height:48px;"/></a> <span class="badge badge-secondary">{{$leave->approver_employee->full_name}}</span>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Leave Information-->
                    <!--Leave History-->
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <div class="container-fluid">
                            <h3 class="pt-3"></h3>
                            <table class="table table-striped table-bordered" style="width:100%;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Updated By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $log)
                                        <tr>
                                            <td>{{date('M d, Y',strtotime($log->transaction_date))}}</td>
                                            <td>
                                                @if($log->status == 'Approved')
                                                    <button type="button" class="btn btn-success" style="width:100%;"><i class="fas fa-check-circle"></i>  {{$log->status}}</button>
                                                @elseif($log->status == 'Declined')
                                                    <button type="button" class="btn btn-danger" style="width:100%;"><i class="fas fa-times-circle"></i> {{$log->status}}</button>
                                                    @elseif($log->status == 'Posted')
                                                    <button type="button" class="btn btn-secondary" style="width:100%;"><i class="fas fa-vote-yea"></i> {{$log->status}}</button>
                                                @else
                                                    <button type="button" class="btn btn-warning" style="width:100%;"><i class="fas fa-hourglass-half"></i>  {{$log->status}}</button>
                                                @endif
                                            </td>
                                            <td>{{$log->remarks}}</td>
                                            <td>
                                                @if($log->approved_by != 'N/A')
                                                  <a href="/{{App\Employee::where('emp_no','=',$log->approved_by)->first()->emp_photo}}" target="_blank"><img class="img-fluid rounded-circle bg-white border" src="/{{App\Employee::where('emp_no','=',$log->approved_by)->first()->emp_photo}}" style="height:48px;"/></a> <span class="badge badge-secondary">{{App\Employee::where('emp_no','=',$log->approved_by)->first()->full_name}}</span>
                                                @else

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--End of Leave History-->
                </div>
            </form>
        </div>
    </div>
@stop

